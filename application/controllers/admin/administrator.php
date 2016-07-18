<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administrator extends CI_Controller
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
	function index()
    {
		
        $data              = array();  
        $data['page']      = 'stores';
		$data['stores'] = $this->admin_model->dbselect('stores');	
        $this->load->view('admin/stores', $data);
		
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
	
	
}