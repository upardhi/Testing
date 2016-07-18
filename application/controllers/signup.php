<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signup extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
       
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
        $data         = array();
        $this->load->view('signup',$data);
	}
	     
    function newadmin()
    {
        $data = array();
        if (isset($_POST['createadminbttn'])) {
			
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_adminemail_exists');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
            
            if ($this->form_validation->run() == FALSE) {
			
                $data['reset'] = FALSE;
            } else {
				
                $admindetails = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
					 'mobilenumber' => $this->input->post('mobilenumber'),
                    'email' => $this->input->post('email'),
                    'company' => $this->input->post('company'),
                    'password' => sha1($this->input->post('password')
					
					)
                );
                if ($this->user_model->insert('administrators', $admindetails)) {
                    $data['success'] = 'Account created successfully!';
                } else {
				
                    $data['error'] = 'An error occurred while creating account, please try again !';
                }
                
                
            }
			$data['form_data']=$_POST;
        }
        $data['page'] = 'createadmin';
        $this->load->view('signup', $data);
    }
   
	     
	function login()
		{
	
			$data = array();
			
			if(isset($_POST['loginbttn']))
			{
				$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
				$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
				if($this->form_validation->run() == FALSE) 
				{
					$data['reset'] = FALSE;
				}
				else
				{
					$username = $this->input->post('email');
					$password = sha1($this->input->post('password'));
					
					if($this->admin_model->login($username, $password))
					{
						redirect(base_url().'admin/administrator');
					}
					else
					{
						$data['error'] = 'Wrong Username/password combination, please try again !';
					}
				}
			}
			$this->load->view('signup', $data);
	}

    function email_exists($email)
    {
        if ($this->user_model->email_exists($email)) {
            $this->form_validation->set_message('email_exists', 'Email already exists. Select another email');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function username_exists($username)
    {
        if ($this->user_model->username_exists($username)) {
            $this->form_validation->set_message('username_exists', 'Username already exists. Select another username');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function adminemail_exists($email)
    {
        if ($this->admin_model->adminemail_exists($email)) {
            $this->form_validation->set_message('adminemail_exists', 'Email already exists. Select another email');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function adminusername_exists($username)
    {
        if ($this->admin_model->adminusername_exists($username)) {
            $this->form_validation->set_message('adminusername_exists', 'Username already exists. Select another username');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	function logout()
    {
        $this->session->unset_userdata('admindetails');
        $this->index();
    }
}