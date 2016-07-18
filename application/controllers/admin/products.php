<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        is_adminlogged_in();
        $this->load->model('admin_model');
        $this->load->model('user_model');
		$this->load->library('form_validation');
        $this->load->helper(array(
            'form',
            'url'
        ));
        $this->PRODUCT_IMAGE       = './uploads/product_images/';
        $this->ANSWER_IMAGE         = './uploads/answerImage/';
        $this->QUESTION_IMAGE_THUMB = './uploads/questionImage/thumbnail/';
    }
	function index($msg="")
    {
		
        $data              = array();  
        $data['page']      = 'stores';
        if($msg=="dltsucc"){
        	$data['success']="Product and associated view with this product is deleted successfully.";
        }
		$data['stores'] = $this->admin_model->dbselect('products');	
        $this->load->view('admin/products', $data);
		
	}
	function add_products()
    {
		 $data = array();
		
        if (isset($_POST['save_product'])) {
			$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('product_sku', 'SKU ', 'trim|required|xss_clean|callback_already_exist');
			$this->form_validation->set_rules('product_store_id', 'Store ', 'required');
			if (empty($_FILES['product_image']['name']))
			{
					$this->form_validation->set_rules('product_image', 'Product Image ', 'required');
			}
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="padding:5px; margin-bottom:5px;"><p>', '</p></div>');
			$form_status=$this->form_validation->run();
			if($form_status){
				 $product_image=md5(uniqid(rand(), true));
				$product_image_data = $this->do_upload($product_image, $this->PRODUCT_IMAGE, 'product_image');
				
			}
			 if (!$form_status && @!$product_image_data['status']) {			
                $data['reset'] = FALSE;
            } else {		
				 // echo '<pre>'; print_r(get_session_details()); die();
				  $sessionData=get_session_details();
				  $adminDetails= $sessionData->admindetails;
				 $product_details = array(
					'product_name' => $this->input->post('product_name'),
                    'product_sku' => $this->input->post('product_sku'),
					'product_desc' => $this->input->post('product_desc'),
					'product_status' => $this->input->post('product_status')=='true'? true : false,
					'product_image' => $product_image_data['upload_data']['orig_name'],
					'product_client_image' => $product_image_data['upload_data']['client_name'],
					'product_width'=> $product_image_data['upload_data']['image_width'],
				 	'product_height'=> $product_image_data['upload_data']['image_height'],
					'user_id' =>$adminDetails['adminid']
                );	

                if ($this->admin_model->insert('products', $product_details)) {
					
					 $product_id=$this->db->insert_id();				 
					 $details=array();
					 $details['product_id']=$product_id;
					 $details['product_store_id']=$_POST['product_store_id'];
					 $this->admin_model->add_stores_products_mapping($details);
					  redirect(base_url() . 'admin/ProductViews/index/'.$product_id.'/productCreated');
					 
                    $data['success'] = 'Product created successfully !';
                } else {
			
                    $data['error'] = 'An error occurred while creating product, please try again !';
                }
			}
		}
		$data['stores'] = $this->admin_model->dbselect('stores');	
        $data['page']      = 'add_products';
        $this->load->view('admin/add_products', $data);
		
	}
	
	function edit_products($product_id)
    {
		 $data = array();
		
        if (isset($_POST['save_product'])) {
			$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('product_sku', 'SKU ', 'trim|required|xss_clean|callback_already_exist');
			$this->form_validation->set_rules('product_store_id', 'Store ', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="padding:5px; margin-bottom:5px;"><p>', '</p></div>');
			$form_status=$this->form_validation->run() ;
			$image_status=false;
			
			 if($form_status && $_FILES['product_image']['size']!=0){
					 $product_image=md5(uniqid(rand(), true));
					 $product_image_data = $this->do_upload($product_image, $this->PRODUCT_IMAGE, 'product_image');
					 $image_status=$product_image_data['status'];
					  
				 }
				
			 if (!$form_status ||  ($_FILES['product_image']['size']!=0 && !$image_status)) {
				 $data_array=array();
				 $data_array['product_name']=$_POST['product_name'];	
				 $data_array['product_sku']=$_POST['product_sku'];		
				 $data_array['product_desc']=$_POST['product_desc'];	
				 $data_array['product_store_id']=$_POST['product_store_id'];							 
				
               // $data['reset'] = FALSE;
            } else {		
			
				 $product_details = array(
					'product_name' => $this->input->post('product_name'),
                    'product_sku' => $this->input->post('product_sku'),
					'product_desc' => $this->input->post('product_desc'),
					'product_status' => ($this->input->post('product_status')=='true' || $this->input->post('product_status')=='on')? true : false
					
                );	
					
				 if(isset($product_image_data)){
				 	 $product_details['product_width']=$product_image_data['upload_data']['image_width'];
				 	 $product_details['product_height']=$product_image_data['upload_data']['image_height'];
					 $product_details['product_image']=$product_image_data['upload_data']['orig_name'];
					 $product_details['product_client_image']=$product_image_data['upload_data']['client_name'];
				 }
				
				
                if ($this->admin_model->update_details('products','product_id',$product_id,$product_details)) {
					
					 $details=array();
					 $details['product_id']=$product_id;
					 $details['product_store_id']=$this->input->post('product_store_id');
					 $this->admin_model->update_stores_products_mapping($details);
					 $data['success'] = 'Product updated successfully !';
                } else {
			
                    $data['error'] = 'An error occurred while updating product, please try again !';
                }
				
				
               
			}
		}
		$data['product_id']=$product_id;
		$data['product_data']=$this->admin_model->get_details('products','product_id',$product_id);
		$data['product_store_mapping']=json_encode($this->admin_model->dbmultiselect('stores_product_mapping','products_product_id',$product_id));
		$data['stores'] = $this->admin_model->dbselect('stores');	
        $data['page']      = 'edit_products';
		
        $this->load->view('admin/edit_products', $data);
		
	}
	
	function delete_stores($store_id)
    {
		$this->admin_model->deleterecord('stores','store_id',$store_id);
		redirect(base_url() . 'admin/administrator/stores/');
	}
	
	function already_exist($sku){
		if(isset($_POST['product_store_id'])){
			if($this->admin_model->check_sku_exist($sku,$_POST)){
				$this->form_validation->set_message('product_sku', 'SKU already exists. Select another SKU');
				return FALSE;
			}else{
				
				return TRUE;
			}
			
		}else{
			return FALSE;
		}
		
		
	}
	
	public function do_upload($imageName, $folderName, $file)
    {
        $config = array(
            'upload_path' => $folderName,
            'allowed_types' => "gif|jpg|png|jpeg",
            'overwrite' => TRUE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'file_name' => $imageName
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload($file)) {
            $data = array(
                'upload_data' => $this->upload->data(),
				'status'=> true,
				'image_name' => $imageName
            );
            return $data;
        } else {
            $error = array(
                'error' => $this->upload->display_errors(),
				'status'=> false
            );
            return $error;
        }
    }
    function delete_products($product_id){
    	$this->admin_model->deleterecord('views','view_product_id',$product_id);
    	$this->admin_model->deleterecord('products','product_id',$product_id);
		 redirect(base_url() . 'admin/products/index/dltsucc');

    }
	
	
}