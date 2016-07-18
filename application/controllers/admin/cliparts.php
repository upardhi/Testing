<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliparts extends CI_Controller
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
        $this->PRODUCT_IMAGE       = './uploads/product_images/';
        $this->ANSWER_IMAGE         = './uploads/answerImage/';
        $this->QUESTION_IMAGE_THUMB = './uploads/questionImage/thumbnail/';
    }
	function index($status="")
    {
	
		
        $data              = array();  
		if(@$status=='dlt'){
			$data['success']="Clipart deleted successfully";
		}
        $data['page']      = 'cliparts';
		$data['cliparts'] = $this->admin_model->dbselect('cliparts');	
        $this->load->view('admin/cliparts', $data);
		
	}
	function add_cliparts()
    {
		
		 $data = array();
        $data['page']      = 'add_products';
        $this->load->view('admin/add_cliparts', $data);
		
	}
	
	function upload_cliparts()
    {
		
		 $clipart_image=md5(uniqid(rand(), true));
		 $product_image_data = $this->do_upload($clipart_image, CLIPARTS_PATH,'file');
		 if($product_image_data ['status']){
			  $clipart_details = array(	
					'clipart_image_name	' => $product_image_data['upload_data']['orig_name'],
					'clipart_client_name	' => $product_image_data['upload_data']['client_name']
                );	
		 
                if ($this->admin_model->insert('cliparts', $clipart_details)) {
					echo  'true';
					return true;
				}else{
						echo  $clipart_details['status'].'Database Err';
					return false;
				}
			 
		 }else{
				echo  'false'.'FILE ERROR';;
			 return false;
		 }
	}
	
	public function delete_clipart($clipart_id){
		
		$this->admin_model->deleterecord('cliparts','clipart_id',$clipart_id);
		redirect(base_url() . 'admin/cliparts/index/dlt');
	}
	
	
	public function do_upload($imageName, $folderName, $file)
    {
		
        $config = array(
            'upload_path' => $folderName,
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
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