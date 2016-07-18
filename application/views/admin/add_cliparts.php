<?php
$this->load->view('admin/vwHeader');
?>
    <!-- metisMenu stylesheet -->

    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>uniform.default.min.css">
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jasny-bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>validationEngine.jquery.min.css">
	    <script src="<?php echo HTTP_JS_PATH; ?>plupload.full.min.js"></script>
	 <script src="<?php echo HTTP_JS_PATH; ?>jquery.plupload.queue.min.js"></script>
	 	<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jquery.plupload.queue.css">

      <div id="content">
        <div class="outer">
          <div class="inner bg-light lter">
		                <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header class="dark">
                    <div class="icons">
                      <i class="fa fa-check"></i>
                    </div>
                    <h5>Add Cliparts</h5>

                    <!-- .toolbar -->
                    <div class="toolbar">
                      <nav style="padding: 8px;">
                        <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
                          <i class="fa fa-minus"></i>
                        </a> 
                        <a href="javascript:;" class="btn btn-default btn-xs full-box">
                          <i class="fa fa-expand"></i>
                        </a> 
                        <a href="javascript:;" class="btn btn-danger btn-xs close-box">
                          <i class="fa fa-times"></i>
                        </a> 
                      </nav>
                    </div><!-- /.toolbar -->
                  </header>
				  
							<form>
							  <div id="uploader"></div>
							</form>

					<div class="form-actions no-margin-bottom">
                      
						<a  class="btn btn-primary" href="<?php echo base_url(); ?>admin/cliparts/index">Back To Clipart List</a>
                      </div>
			  </div><!-- /.box -->
			 </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
		  </div>
		  </div>
		  </div>
		  

    <script src="<?php echo HTTP_JS_PATH; ?>holder.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.uniform.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jasny-bootstrap.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.form.min.js"></script>
<?php
$this->load->view('admin/vwFooter');
?>
<script>

$(document).ready(function(){
	    /*----------- BEGIN plupload CODE -------------------------*/
    $("#uploader").pluploadQueue({
        runtimes: 'html5,html4',
        url: '<?= base_url() ?>admin/cliparts/upload_cliparts',
        max_file_size: '<?= CLIPART_IMAGE_MAX_SIZE ?>',
        unique_names: true,
        filters: [
            {
                title: "Image files",
                extensions: "jpg,png,jpeg"
            }
        ]
    });
    /*----------- END plupload CODE -------------------------*/
	
	
})

</script>