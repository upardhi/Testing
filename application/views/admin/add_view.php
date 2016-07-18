<?php
$this->load->view('admin/vwHeader');
?>
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jasny-bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>validationEngine.jquery.min.css">
	<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jquery.Jcrop.css">
	
	<script src="<?php echo HTTP_JS_PATH; ?>/jquery.Jcrop.min.js"></script>
	

	

	<script type="text/javascript">
 var jcrop_api;
  jQuery(function($){
  	var x1=<?php echo isset($view_data->view_x) ? $view_data->view_x:0 ?>;
  	var y1=<?php echo isset($view_data->view_x) ? $view_data->view_y:0 ?>;
  	var w=<?php echo isset($view_data->view_x) ? $view_data->view_width:0 ?>;
  	var h=<?php echo isset($view_data->view_x) ? $view_data->view_height:0 ?>;


   

    $('#target').Jcrop({
      onChange:   showCoords,
      onSelect:   showCoords,
      onRelease:  clearCoords
    },function(){
      jcrop_api = this;
      if(x1&&y1&&w&&h){
      	  jcrop_api.setSelect([x1,y1,x1+w,y1+h]);
      }
    
    });

    $('#coords').on('change','input',function(e){
      var x1 = $('#x1').val(),
         
          y1 = $('#y1').val();
       
      jcrop_api.setSelect([x1,y1,x2,y2]);
    });

    function createViews(){
    	$.ajax({
    		url:url

    	})

    }

  });

  // Simple event handler, called from onChange and onSelect
  // event handlers, as per the Jcrop invocation above
  function showCoords(c)
  {
    $('#x1').val(c.x);
    $('#y1').val(c.y);

    $('#w').val(c.w);
    $('#h').val(c.h);
    if(!c.w || !c.h || !$('#view_name').val()){
    	$('#save_view').attr('disabled','disabled');
    }else{
		$('#save_view').removeAttr('disabled');

    }
  };

  function clearCoords()
  {
    $('#coords input').val('');
  };

  function checkValidation(){
 	if($('#w').val() && $('#h').val() && $('#h').val()){
 		$('#save_view').removeAttr('disabled');
 	}else{
 		$('#save_view').attr('disabled','disabled');
 	}
    

  }
function Upload() {
    //Get reference of FileUpload.
    var fileUpload = document.getElementById("fileUpload");
 
    //Check whether the file is valid Image.
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
 
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    $('#target').attr('src',this.src);
			          jcrop_api.setImage(this.src,function(){
				        this.setOptions({
				          bgOpacity: 1,
				          outerImage: this.src
				        });
				    });
                    return true;
                };
 
            }
        } else {
            alert("This browser does not support HTML5.");
            return false;
        }
    } else {
        alert("Please select a valid Image file.");
        return false;
    }
}
</script>

  

      <div id="content">
        <div class="outer">
          <div class="inner bg-light lter">

			 <!--BEGIN AUTOMATIC JUMP-->
            <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header>
                    <div class="icons">
                      <i class="fa fa-exchange"></i>
                    </div>
                    <h5>Add Colors</h5>
                  </header>
                  <div class="body">
                <form class="form-horizontal" id="popup-validation" action="<?php echo base_url(); ?>admin/ProductViews/add_view/<?= $product_id; ?>/<?= isset($view_data->view_id) ? $view_data->view_id:0;?>" method="post" enctype="multipart/form-data">
                  	<div class="tbl-img-wrap-prt">
                  		<?php if(!empty($view_data->view_image)){ ?>

	                  	  		<img id="target" src="<?php echo VIEW_IMAGES_ABS_PATH.$view_data->view_image; ?>" />	
		                  	<?php }else {?>
	                  	  		<img id="target" src="<?php echo PRODUCT_IMAGES_ABS_PATH.$product_data->product_image; ?>" />	

		                  	<?php } ?>
		                  	<div class="inline-labels">
							    <label>Left *<input type="text" size="4" id="x1" name="view_x" value="<?php echo isset($view_data->view_x) ? $view_data->view_x:'' ?>" /></label>
							    <label>Top* <input type="text" size="4" id="y1" name="view_y"  value="<?php echo isset($view_data->view_y) ? $view_data->view_y:'' ?>" /></label>
							  
							    <label>Width* <input type="text" size="4" id="w" name="view_width" value="<?php echo isset($view_data->view_width) ? $view_data->view_width:'' ?>" /></label>

							    <label>Height* <input type="text" size="4" id="h" name="view_height"  value="<?php echo isset($view_data->view_height) ? $view_data->view_height:'' ?>" /></label>
							    <label>View Name *<input type="text"  id="view_name" name="view_name" onkeyUp="checkValidation()"   value="<?php echo isset($view_data->view_name) ? $view_data->view_name:'' ?>" /></label>
							   
							     <label>View Image <input type="file" id="fileUpload" name="view_image" onchange="Upload()" ></label>
							        
						    </div>
                  	</div>

                    <div class="form-actions no-margin-bottom">
                        <input type="submit" id="save_view" value="Save Product"  name="save_view" class="btn btn-primary" disabled>
						<a  class="btn btn-primary" href="<?php echo base_url(); ?>admin/products/index">Back To Product List</a>
                      </div>
                  </div>
                </form>
                </div>
              </div>

            </div>

              
           


          </div><!-- /.inner -->
        </div><!-- /.outer -->
      </div><!-- /#content -->
	  

	  
	  <?php
$this->load->view('admin/vwFooter');
?>

    <script src="<?php echo HTTP_JS_PATH; ?>/jquery-ui.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.dataTables.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>dataTables.bootstrap.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jasny-bootstrap.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>/jquery.tablesorter.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>/jquery.ui.touch-punch.min.js"></script>
	 <script src="<?php echo HTTP_JS_PATH; ?>jquery.validationEngine.min.js"></script>
	  <script src="<?php echo HTTP_JS_PATH; ?>jquery.validationEngine-en.min.js"></script>
	   <script src="<?php echo HTTP_JS_PATH; ?>jquery.validate.min.js"></script>

	
	 <script>
      $(function() {
        Metis.MetisTable();
         $('#color-validation').validationEngine();
      });
    </script>
	<style type="text/css">
	.tbl-img-wrap-prt{width:100%;margin-bottom: 10px;}
		.tbl-img-wrap{max-width:500px;max-height:500px; height:500px;position:relative; margin: auto;}
		.tbl-img-wrap img{    vertical-align: middle;
    position: absolute;
    max-width: 100%;
    max-height: 100%;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;}
	.btn-file{overflow:none;}
	.image-width{width:50px;height:50px;}
	.jcrop-holder{margin: auto; margin-bottom: 50px;}
	.inline-labels{margin: auto}
    .jcrop-holder{
  box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.15);
    -webkit-box-shadow:  0px 0px 1px 1px rgba(0,0,0,0.15);
    -moz-box-shadow:  0px 0px 1px 1px rgba(0,0,0,0.15);
  }
	</style>
