<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProductViews extends CI_Controller
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

    public function index($product_id=0,$msg=""){

        $data              = array();  
        $data['page']      = 'productview';
        if($msg=="dltsucc"){
            $data["success"]="Your view deleted successfully.";
        }
        if($msg=="productCreated"){
            $data["success"]="Product created successfully.";
        }
        $data['product_id']= $product_id;
        $data['product_view_data']=$this->admin_model->dbmultiselect('views','view_product_id',$product_id);
        //echo '<pre>'; print_r($data); die();
        $this->load->view('admin/productViews', $data);

    }

    public function add_view($product_id,$view_id=0){
      
         $data = array();
       
        if (isset($_POST['save_view'])) {
          
         
            $image_status=false;
            $form_status=true;
            
             if($form_status && $_FILES['view_image']['size']!=0){
                     $view_image=md5(uniqid(rand(), true));
                     $view_image_data = $this->do_upload($view_image,VIEW_IMAGES, 'view_image');
                     $image_status=$view_image_data['status'];
                      
                 }
                
             if (!$form_status ||  ($_FILES['view_image']['size']!=0 && !$image_status)) {
                 $data_array=array();
                 $data_array['view_name']=$_POST['view_name'];    
                 $data_array['view_x']=$_POST['view_x'];      
                 $data_array['view_y']=$_POST['view_y'];  
                 $data_array['view_width']=$_POST['view_width'];     
                 $data_array['view_height']=$_POST['view_height'];     

               // $data['reset'] = FALSE;
            } else {        
            
                 $view_details = array(
                    'view_name' => $this->input->post('view_name'),
                    'view_x' => $this->input->post('view_x'),
                    'view_y' => $this->input->post('view_y'),
                    'view_width' => $this->input->post('view_width'),
                    'view_height' => $this->input->post('view_height'),
                    'view_product_id' =>$product_id,
                    'view_template_id' => 0,
                    'view_rule_id'=>0
                    
                );  
                   
                 if(isset($view_image_data)){
                     $view_details['view_image']=$view_image_data['upload_data']['orig_name'];
                    
                 }

                if($view_id!=0){
 
                    if ($this->admin_model->update_details('views','view_id',$view_id,$view_details)) {
                          redirect(base_url() . 'admin/ProductViews/create_design/'.$product_id.'/'.$view_id);
                        //echo "<pre>"; print_r($this->db->last_query());
                         $data['success'] = 'Product updated successfully !';
                    } else {
                
                        $data['error'] = 'An error occurred while updating view, please try again !';
                    }

                }else{

                   
                    if ($this->admin_model->insert('views',$view_details)) {
                        $view_id=$this->db->insert_id();
                          redirect(base_url() . 'admin/ProductViews/create_design/'.$product_id.'/'.$view_id);
                         $data['success'] = 'Product view added successfully !';
                    } else {
                
                        $data['error'] = 'An error occurred while adding view, please try again !';
                    }

                }
               

            }
        }else{

            if($view_id !=0){

                $data['view_data']=$this->admin_model->get_details('views','view_product_id',$product_id,'view_id',$view_id);
              
                $template_id=$data['view_data']->view_template_id;
                if($data['view_data']->view_template_id !=0){
                    redirect(base_url() . 'admin/ProductViews/create_design/'.$product_id.'/'.$view_id);
                }
            }

        }
        $data['page']      = 'add_product_view';
        $data['product_id']= $product_id;
        $data['product_data']=$this->admin_model->get_details('products','product_id',$product_id);
        //echo '<pre>'; print_r($data); die();

        $this->load->view('admin/add_view', $data);
    }
    public function create_design($product_id,$view_id){
      // $this->load->library('GD');
      

        $data              = array();  
        $data['page']      = 'create_design';
        $data['view_id']= $view_id;
        $data['product_id']= $product_id;
        $data['view_data']=$this->admin_model->get_details('views','view_id',$view_id);
        $template_id=$data['view_data']->view_template_id;
        if($template_id !=0){
             $data['template_design_json']=$this->admin_model->get_details('templates','template_id',$template_id)->template_design_json;
         }else{
            $data['template_design_json']='';
         }
       
        $data['product_data']=$this->admin_model->get_details('products','product_id',$product_id);
        $data['global_rule_data']=json_encode($this->admin_model->get_details('rules','rule_view_id',$view_id));
        $data['cliparts'] = $this->admin_model->dbselect('cliparts');   
        $data['fonts'] = $this->admin_model->dbselect('fonts');   
        $data['colors'] = $this->admin_model->dbselect('colors');   
       
        $this->load->view('admin/create_design', $data);
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

    public function save_design(){

        $design_data=$_POST['designData'];
        $svg=$_POST['svg'];

        $descoded_json=json_decode($design_data);
        $decoded_svg=urldecode($svg);
        $sessionData=get_session_details();
        $adminDetails= $sessionData->admindetails;
        $view_id=$descoded_json->viewId;
        $svg_name=$this->generateImageUsingSVG($decoded_svg);
        $templateDesign_details = array(
                    'template_canvas_width' => $descoded_json->width,
                    'template_canvas_height' => $descoded_json->height,
                    'template_top' =>$descoded_json->top,
                    'template_left' => $descoded_json->left,
                    'template_design_json' =>json_encode($descoded_json->design),
                    'user_id' =>$adminDetails['adminid'],
                    'template_svg' =>$svg_name
                );  
         $this->admin_model->insert('templates',$templateDesign_details);
         $template_id=$this->db->insert_id();
         $view_details = array(
            'view_template_id'=> $template_id
            );
         $this->admin_model->update_details('views','view_id',$view_id,$view_details);
         
       
       // echo '<pre>'; print_r($_POST); die();

    }

    public function update_design(){

        $design_data=$_POST['designData'];
        $svg=$_POST['svg'];

        $descoded_json=json_decode($design_data);
        $decoded_svg=urldecode($svg);
        $sessionData=get_session_details();
        $adminDetails= $sessionData->admindetails;
        $view_id=$descoded_json->viewId;
        $svg_name=$this->generateImageUsingSVG($decoded_svg);

        $templateDesign_details = array(
                    'template_canvas_width' => $descoded_json->width,
                    'template_canvas_height' => $descoded_json->height,
                    'template_top' =>$descoded_json->top,
                    'template_left' => $descoded_json->left,
                    'template_design_json' =>json_encode($descoded_json->design),
                    'user_id' =>$adminDetails['adminid'],
                    'template_svg' =>$svg_name
                );  
         $this->admin_model->update_details('templates','template_id',$descoded_json->templateId,$templateDesign_details);
         echo $this->db->last_query();
    }
    function generateImageUsingSVG($svg){

        $svg_name=md5(uniqid(rand(), true));
        $svg_path=TEMPLATE_SVG_PATH.$svg_name.'.svg';
        $success = file_put_contents($svg_path, $svg);
        $this->replace_svg_image_paths($svg_path);
        //echo realpath ( $svg_path ); die();
        $this->load->library('image_magician', IMAGE_MAGIC_DIR_PATH);

       $this->image_magician->generate_png(realpath ( $svg_path ),$svg_name);
        return $svg_name.'.svg';
    }
    function reset_canvas_desing($product_id,$view_id){
        $view_details = array(
            'view_template_id'=> ''
            );
         $this->admin_model->update_details('views','view_id',$view_id,$view_details);
          redirect(base_url() . 'admin/ProductViews/add_view/'.$product_id.'/'.$view_id);
    }
    function delete_product_view($product_id,$view_id){
       
       if($this->admin_model->deleterecord('views','view_id',$view_id)){
          redirect(base_url() . 'admin/ProductViews/index/'.$product_id.'/dltsucc');
       }
    }
    function replace_svg_image_paths($svg){

        $xdoc = new DomDocument;
            $xdoc->Load($svg);
            $svg_element=$xdoc->getElementsByTagName('image');
            for ($i = $svg_element->length; --$i >= 0; ) {
              $el = $svg_element->item($i);
              $attribNode = $el->getAttributeNode('xlink:href');
              $result = explode('/', $attribNode->textContent);
                $index=count($result);
                $index-=1;
              
                $img=CLIPART_DIR_PATH.$result[$index];
              
                $el->setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', $img);

                $newFileContent = $xdoc->saveXML();
                 
                $fh = fopen($svg, 'w') or die("can't open file");
                fwrite($fh, $newFileContent);
                fclose($fh);
            }
          
    }
    public function save_global_rule(){
        $sessionData=get_session_details();
        $adminDetails= $sessionData->admindetails;
        $rule_data=$_POST["ruleData"];
        $rule_data=  json_decode($rule_data);
        $rule_id= $_POST["rule_id"];

       
        if(empty($rule_id)){
              $rule_details = array(
                   
                     "rule_allow_json" =>json_encode($rule_data->rule_allow_json),
                      "rule_type" =>$rule_data->rule_type,
                      "rule_view_id"=>$rule_data->rule_view_id,
                );
             $this->admin_model->insert('rules',$rule_details);
             $rule_id=$this->db->insert_id();
             echo $rule_id;
        }else{
             $rule_details = array(
                   
                     "rule_allow_json" =>json_encode($rule_data->rule_allow_json),
                      "rule_type" =>$rule_data->rule_type,
                      "rule_view_id"=>$rule_data->rule_view_id,
                );
            $this->admin_model->update_details('rules','rule_id',$rule_id,$rule_details);
             echo $rule_id;

        }


    }

     public function save_object_rule(){
        $sessionData=get_session_details();
        $adminDetails= $sessionData->admindetails;
        $rule_data=$_POST["ruleData"];
        $rule_data=  json_decode($rule_data);
        $rule_id= @$_POST["ruleId"];
       
       
        if(empty($rule_id)){
              $rule_details = array(
                   
                     "rule_allow_json" =>json_encode($rule_data->rule_allow_json),
                      "rule_type" =>$rule_data->rule_type,
                      "rule_view_id"=>$rule_data->rule_view_id,
                      "rule_widget_id"=>$rule_data->rule_widget_id,
                      "rule_widget_type"=>$rule_data->rule_widget_type
                );
             $this->admin_model->insert('rules',$rule_details);
             $rule_id=$this->db->insert_id();
             $rule_details['rule_id']= $rule_id;
             echo json_encode($rule_details);
        }else{
         // echo json_encode($rule_data); die('eeeee');
             $rule_details = array(
                   
                    "rule_allow_json" =>json_encode($rule_data->rule_allow_json),
                      "rule_type" =>$rule_data->rule_type,
                      "rule_view_id"=>$rule_data->rule_view_id,
                      "rule_widget_id"=>$rule_data->rule_widget_id,
                      "rule_widget_type"=>$rule_data->rule_widget_type
                );

            $this->admin_model->update_details('rules','rule_id',$rule_id,$rule_details);
            $rule_details['rule_id']= $rule_id;
             echo json_encode($rule_details);

        }


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



}