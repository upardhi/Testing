<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Colors extends CI_Controller
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
	function index($color_id=0)
    {
		$data = array();
		//echo '<pre>'; print_r($_POST);die();
        if (isset($_POST['save_color'])) {
			
			$this->form_validation->set_rules('color_name', 'Color Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('color_hex', 'Color Hex ', 'trim|required|xss_clean');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="padding:5px; margin-bottom:5px;"><p>', '</p></div>');
			$form_status=$this->form_validation->run();
			if (!empty($_FILES['color_image']['name']))
			{
			
				 $color_image=md5(uniqid(rand(), true));
				 $color_image_data = $this->do_upload($color_image, COLORS_PATH, 'color_image');
				 
			}

			 if (!$form_status) {			
                $data['reset'] = FALSE;
            } else {		
				  
				 $color_details = array(
					'color_name' => $this->input->post('color_name'),
                    'color_hex' => $this->input->post('color_hex'),
					'color_code' => $this->input->post('color_code')
					
                );	
				if(!empty($_FILES['color_image']['name'])){
					$color_details['color_image'] = $color_image_data['upload_data']['orig_name'];
				}
				if($this->input->post('color_id') ==0){
					if ($this->admin_model->insert('colors', $color_details)) {
						$data['success'] = 'Color added successfully !';
						
					} else {
				
						$data['error'] = 'An error occurred while creating color, please try again !';
					}
				}else{
					$color_id=$this->input->post('color_id');
				   if ($this->admin_model->update_details('colors', 'color_id', $color_id,$color_details)) {
						$data['success'] = 'Color edited successfully !';
					} else {
				
						$data['error'] = 'An error occurred while updating color, please try again !';
					}
					
				}
			}
		}else{
			//echo $color_id; die();
			if($color_id!=0){
					$data['colors_data']=$this->admin_model->get_details('colors','color_id',$color_id);
			}
		
			
			//TODO Edit  code here 
			
		}
	
 
        $data['page']      = 'colors';
		$data['colors'] = $this->admin_model->dbselect('colors');	
        $this->load->view('admin/colors', $data);
		
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