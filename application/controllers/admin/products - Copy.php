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
		
			 if ($this->form_validation->run() == FALSE) {
				 	echo '<pre>'; print_r($_POST); die('false');
                $data['reset'] = FALSE;
            } else {		
	
				 $product_details = array(
					'product_name' => $this->input->post('product_name'),
                    'product_sku' => $this->input->post('product_sku'),
					'product_desc' => $this->input->post('product_desc'),
					'product_status' => $this->input->post('product_status')
                );	
                if ($this->admin_model->insert('products', $product_details)) {
					 $product_id=$this->db->insert_id();
					 $details=array();
					 $details['product_id']
					 $this->admin_model->add_stores_products_mapping($product_id,);
				
                    $data['success'] = 'Store created successfully !';
                } else {
			
                    $data['error'] = 'An error occurred while creating stores, please try again !';
                }
			}
		}
		$data['stores'] = $this->admin_model->dbselect('stores');	
        $data['page']      = 'add_products';
        $this->load->view('admin/add_products', $data);
		
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
	
	function already_exist($sku){
		
		if($this->admin_model->check_sku_exist($sku,$_POST)){
			
			return false;
		}else{
			
			return true;
		}
		
	}
	
	
}