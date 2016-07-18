<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        //is_adminlogged_in();
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
	function index()
    {
		
        $data              = array();  
        $data['page']      = 'stores';
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
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="padding:5px; margin-bottom:5px;"><p>', '</p></div>');
			 if ($this->form_validation->run() == FALSE) {
				
                $data['reset'] = FALSE;
            } else {		
	
				 $product_details = array(
					'product_name' => $this->input->post('product_name'),
                    'product_sku' => $this->input->post('product_sku'),
					'product_desc' => $this->input->post('product_desc'),
					'product_status' => $this->input->post('product_status')=='on'?1:0;
                );	
                if ($this->admin_model->insert('products', $product_details)) {
					
					 $product_id=$this->db->insert_id();				 
					 $details=array();
					 $details['product_id']=$product_id;
					 $details['product_store_id']=$_POST['product_store_id'];
					 $this->admin_model->add_stores_products_mapping($details);
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
		echo '<pre>'; print_r($_POST); die();
        if (isset($_POST['save_product'])) {
			$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('product_sku', 'SKU ', 'trim|required|xss_clean|callback_already_exist');
			$this->form_validation->set_rules('product_store_id', 'Store ', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="padding:5px; margin-bottom:5px;"><p>', '</p></div>');
			 if ($this->form_validation->run() == FALSE) {
				 $data_array=array();
				 $data_array['product_name']=$_POST['product_name'];	
				 $data_array['product_sku']=$_POST['product_sku'];		
				 $data_array['product_desc']=$_POST['product_desc'];	
				 $data_array['product_store_id']=$_POST['product_store_id'];							 
				 
                $data['reset'] = FALSE;
            } else {		
			
				 $product_details = array(
					'product_name' => $this->input->post('product_name'),
                    'product_sku' => $this->input->post('product_sku'),
					'product_desc' => $this->input->post('product_desc'),
					'product_status' => $this->input->post('product_status')=='on'?1:0;
                );	
                if ($this->admin_model->update_details('products','product_id',$product_id,$product_details)) {
					
                   		 
					 $details=array();
					 $details['product_id']=$product_id;
					 $details['product_store_id']=$this->input->post['product_store_id'];
					 $this->admin_model->update_stores_products_mapping($details);
                } else {
			
                    $data['error'] = 'An error occurred while updating product, please try again !';
                }
				
				
               
			}
		}
		$data['product_id']=$product_id;
		$data['product_data']=$this->admin_model->get_details('products','product_id',$product_id);
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
	
	
}