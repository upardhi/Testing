<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProductApi extends CI_Controller
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
        $this->QUESTION_IMAGE       = './uploads/questionImage/';
        $this->ANSWER_IMAGE         = './uploads/answerImage/';
        $this->QUESTION_IMAGE_THUMB = './uploads/questionImage/thumbnail/';
    }
	function get_product_data($product_sku='',$store_id=0)
    {

        $product_sku=@$_GET['sku'];
        $store_id=@$_GET['store_id'];
         
        if(!empty($product_sku)&& $product_sku !='' && !empty($store_id) && $store_id !=0){
            $data              = array();
            $data['stores_data']=$this->admin_model->get_details('stores','store_id',$store_id);
            $data['product_data']=$this->get_product_details($product_sku,$store_id);
            $product_data=$this->get_product_details($product_sku,$store_id);
           
           
            if($data['product_data'] !=FALSE){
                $data['ProductName']=$product_data->product_name;
                $data['ProductSku']=$product_data->product_sku;
                $data['ProductImage']=$product_data->product_image;
                $data['ProductDescription']=$product_data->product_desc;        
                $data['ProductAssetType']='color';
                $data['ProductViews']=$this->get_product_view_data($data['product_data']->product_id);
                $data['ProductVariant']=array();
                $data['ColorList']=array();
            }
            echo json_encode($data);

        }else{

            echo 'Sorry you have not passed Product sku or Store id. ';
        }

	}

    public function get_clipart_data($product_sku='',$store_id=0){
            $data              = array();  
            $data['cliparts'] = $this->admin_model->dbselect('cliparts');
              echo json_encode($data);  


    }
    
     function get_rule_details($view_id,$rule_widget_id){
      $sessionData=get_session_details();
        $adminDetails= $sessionData->admindetails;
        $this->db->select('*');
        $this->db->from('rules');
        $this->db->where('rule_view_id', $view_id);
        $this->db->where('user_id', $adminDetails['adminid']);
        $this->db->where('rule_widget_id', $rule_widget_id);
        $result = $this->db->get();
        $result_data= $result->row();
        echo json_encode($result_data);

    }


    private function get_product_details($product_sku, $store_id){

        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('product_sku', $product_sku);
        $this->db->where('product_status', 1);
        $result = $this->db->get();
        $result_data= $result->row();
       
        if(!empty($result_data))
        {
            $query = $this->db->query("SELECT * FROM stores_product_mapping where products_product_id = $result_data->product_id and stores_store_id=$store_id"); 
            $mapping=$query->result_array();
            
             
             if(!empty($mapping)){

                return $result_data;

             }else{
                log_message('info', "Sorry Product mapping is not available with store");
                return FALSE;
             }
        }else{
             log_message('info', "Sorry Product is not available.");
            return FALSE;
        }
    }

    /*
    @ function use for getting the product view details using views table and templates 
    table using product_id
    */
    private function get_product_view_data($product_id){

/*For getting the complete data from 3 table */
      /*  SELECT *
  FROM products,
       views,
       templates
  WHERE views.view_product_id = products.product_id AND
        views.view_template_id = templates.template_id*/

          $query = $this->db->query("SELECT view_id as ProductViewId, 
                                            view_id as Id,
                                            view_name as ViewName, 
                                            templates.template_canvas_width as Width,
                                            templates.template_canvas_height as Height,
                                            templates.template_top as Y,
                                            templates.template_left as X,
                                            templates.template_design_json as Design
                                            FROM views
                                            INNER JOIN templates
                                            ON templates.template_id=views.view_template_id 
                                            where views.view_product_id = $product_id"); 

            return $query->result_array();
    }

	
	function stores()
    {
		
        $data              = array();  
        $data['page']      = 'stores';
		$data['stores'] = $this->admin_model->dbselect('stores');	
        $this->load->view('admin/stores', $data);
		
	}
	function add_stores()
    {
		 $data = array();
 
        if (isset($_POST['save_store'])) {
			$this->form_validation->set_rules('store_name', 'Store Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('store_desc', 'Store Description', 'trim|required|xss_clean');
			
			 if ($this->form_validation->run() == FALSE) {
                $data['reset'] = FALSE;
            } else {	
				 $sessionData=get_session_details();
				  $adminDetails= $sessionData->admindetails;			
				 $store_details = array(
					'store_name' => $this->input->post('store_name'),
                    'store_desc' => $this->input->post('store_desc'),
					'user_id' =>$adminDetails['adminid']
                );	
                if ($this->admin_model->insert('stores', $store_details)) {
				
                    $data['success'] = 'Store created successfully !';
                } else {
			
                    $data['error'] = 'An error occurred while creating stores, please try again !';
                }
			}
		}
      
        $data['page']      = 'add_stores';
        $this->load->view('admin/add_stores', $data);
		
	}
	function edit_stores($store_id)
    {
		 $data = array();
 
        if (isset($_POST['save_store'])) {
			$this->form_validation->set_rules('store_name', 'Store Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('store_desc', 'Store Description', 'trim|required|xss_clean');
			
			 if ($this->form_validation->run() == FALSE) {
                $data['reset'] = FALSE;
            } else {			
				 $store_details = array(
					'store_name' => $this->input->post('store_name'),
                    'store_desc' => $this->input->post('store_desc')
                );	
                if ($this->admin_model->update_details('stores','store_id',$store_id,$store_details)) {
				
                    $data['success'] = 'Store updated successfully !';
                } else {
			
                    $data['error'] = 'An error occurred while updating stores, please try again !';
                }
			}
		}
		$data['stores_data']=$this->admin_model->get_details('stores','store_id',$store_id);
		$data['store_id']=$store_id;
        $data['page']      = 'add_stores';
        $this->load->view('admin/edit_stores', $data);
		
	}
	function delete_stores($store_id)
    {
		$this->admin_model->deleterecord('stores','store_id',$store_id);
		redirect(base_url() . 'admin/administrator/stores/');
	}
	
	
	public function uploadImage($user_id=0,$status='finish'){
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		header('Content-Type:application/json');
		
		if(isset($_FILES)){
			
			 foreach($_FILES as  $file){
			
			 $image_unq_name=md5(uniqid(rand(), true));
			 $selected_image_data_arr=explode(".",$file["name"]);
			 $image_with_unq_name=$image_unq_name.".".$selected_image_data_arr[1];
			 $imageDetails['UserImageDisplayName']=$selected_image_data_arr[0];
			 $target_file = USER_UPLOADED_PATH. $image_with_unq_name;
			  move_uploaded_file($file['tmp_name'], $target_file);
			  $imageDetails['UserImage']= basename($file["name"]);
			  $imageDetails['UserImageSrc']= $image_with_unq_name;
			 $imageDetails['UserId']=$user_id;
			 $this->admin_model->insert_front_data('userimages', $imageDetails);
		}
		if($status=='finish'){
			$data = $this->admin_model->getUserImages($user_id)->result_array();
			echo json_encode($data);
		}
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
	
	
}