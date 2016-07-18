<?php
$this->load->view('admin/vwHeader');
?>
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jasny-bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>validationEngine.jquery.min.css">
	<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jquery.Jcrop.css">

	

	
      <div id="content">
        <div class="outer">
          <div class="inner bg-light lter">

			 <!--BEGIN AUTOMATIC JUMP-->
            <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header class="clearfix">
                    <div class="icons">
                      <i class="fa fa-exchange"></i>
                    </div>
                    <h5>Create Desing</h5>
                    <a href="<?= base_url() ?>admin/ProductViews/reset_canvas_desing/<?= $product_id?>/<?= $view_id?>" class="btn btn-primary btn-rect pull-right"  style="padding:9px;color:#fff;margin:0 10px;" data-original-title="" title="" aria-describedby="popover891134">Reset Canvas area</a>  
                    <a href="#" class="btn btn-primary btn-rect pull-right" id="save-design" style="padding:9px;color:#fff;margin:0 10px;" data-original-title="" title="" aria-describedby="popover891134">Save Design</a>        
                  </header>
                  <div class="body">
                                          
                    <?php
                    $this->load->view('admin/_Application_View');
                    ?>

                  </div>
               
                </div>
              </div>

            </div>

              
           


          </div><!-- /.inner -->
        </div><!-- /.outer -->
      </div><!-- /#content -->
	  

	  
	  <?php
$this->load->view('admin/vwFooter');
?>
