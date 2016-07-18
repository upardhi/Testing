<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fonts extends CI_Controller
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
	function index($font_id=0)
    {
		$data = array();
		//echo '<pre>'; print_r($_POST);die();
        if (isset($_POST['save_font'])) {
			
			$this->form_validation->set_rules('font_name', 'font Name', 'trim|required|xss_clean');
           
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="padding:5px; margin-bottom:5px;"><p>', '</p></div>');
			$form_status=$this->form_validation->run();
			if (!empty($_FILES['font_image']['name']))
			{
			
				 $font_image=md5(uniqid(rand(), true));
				 $font_image_data = $this->do_upload($font_image, FONTS_PATH, 'font_image');
				 
			}

			 if (!$form_status) {			
                $data['reset'] = FALSE;
            } else {		
				  
				 $font_details = array(
					'font_name' => $this->input->post('font_name'),
					'font_code' => $this->input->post('font_code'),
					'font_display_name' => $this->input->post('font_display_name')
					
                );	
				if(!empty($_FILES['font_image']['name'])){
					$font_details['font_image'] = $font_image_data['upload_data']['orig_name'];
				}
				if($this->input->post('font_id') ==0){
					if ($this->admin_model->insert('fonts', $font_details)) {
						$data['success'] = 'font added successfully !';
						
					} else {
				
						$data['error'] = 'An error occurred while creating font, please try again !';
					}
				}else{
					$font_id=$this->input->post('font_id');
				   if ($this->admin_model->update_details('fonts', 'font_id', $font_id,$font_details)) {
						$data['success'] = 'font edited successfully !';
					} else {
				
						$data['error'] = 'An error occurred while updating font, please try again !';
					}
					
				}
			}
		}else{
			//echo $font_id; die();
			if($font_id!=0){
					$data['fonts_data']=$this->admin_model->get_details('fonts','font_id',$font_id);
			}
		
			
			//TODO Edit  code here 
			
		}
	
 
        $data['page']      = 'fonts';
		$data['fonts'] = $this->admin_model->dbselect('fonts');	
        $this->load->view('admin/fonts', $data);
		
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