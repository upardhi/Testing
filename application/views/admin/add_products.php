<?php
$this->load->view('admin/vwHeader');
?>
    <!-- metisMenu stylesheet -->

    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>uniform.default.min.css">
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jasny-bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>validationEngine.jquery.min.css">

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
                    <h5>Add Product</h5>

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
                  <div id="collapse2" class="body">
                    <form class="form-horizontal" id="product-validation" action="<?php echo base_url(); ?>admin/Products/add_products" method="post" enctype="multipart/form-data">
					<?=form_error('product_name'); ?>		
					<?=form_error('product_sku'); ?>		
					<?=form_error('product_store_id'); ?>			
					<?=form_error('product_image'); ?>							
					<?php
					 	
					if(isset($error) && $error !='')
					{
						?>
					<div class="alert alert-danger">
					<?php echo $error; ?>
				  </div>
					<?php
					}
					
					?>
									 <?php
					if(isset($success) && $success !='')
					{
						?>
					<div class="alert alert-success">
					<?php echo $success; ?>
				  </div>
					<?php
					}
					
					?>
				
                      <div class="form-group">
                        <label class="control-label col-lg-4">Product Name</label>
                        <div class="col-lg-4">
                          <input type="text" class="validate[required] form-control" name="product_name" id="req">
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-lg-4">Product SKU</label>
                        <div class="col-lg-4">
                          <input type="text" class="validate[required] form-control" name="product_sku" id="req1">
                        </div>
                      </div>
					 
                      <div class="form-group">
                        <label class="control-label col-lg-4">Product Description</label>
                        <div class="col-lg-4">
                          <textarea class=" form-control" name="product_desc" ></textarea>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-lg-4">Store</label>
                        <div class="col-lg-4">
                          <select data-placeholder="Choose a Stores" class="form-control chzn-select validate[required]" multiple="" tabindex="4" name="product_store_id[]">
                           
							<?php
							
									if(isset($stores))
									{
										foreach($stores as $row)
										{
											echo '<option value="'.$row['store_id'].'">'.$row['store_name'].'</option>';
											
										}
									}
							?>                                                               
                          </select>
                        </div>
                      </div>
					    <div class="form-group">
                        <label class="control-label col-lg-4">Product Status</label>
                        <div class="col-lg-4">
                         <div class="checkbox">
                            <label>
                              <input class="uniform" type="radio" name="product_status"  value="true" checked="true">Active
                            </label>
                          </div>
						  
						  <div class="checkbox">
                            <label>
                              <input class="uniform" type="radio" name="product_status"  value="false" checked="">Inactive
                            </label>
                          </div>
						  
                        </div>
                      </div>

                      
					   <div class="form-group">
                        <label class="control-label col-lg-4">Image Upload</label>
                        <div class="col-lg-8">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                            <div>
                              <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span> <span class="fileinput-exists">Change</span> 
                                <input type="file" name="product_image" class="validate[required]">
                              </span> 
                              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
                            </div>
                          </div>
                        </div>
                      </div>
					  <div class="form-actions no-margin-bottom">
                        <input type="submit" value="Save Product"  name="save_product" class="btn btn-primary">
						<a  class="btn btn-primary" href="<?php echo base_url(); ?>admin/products/index">Back To Product List</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
		  </div>
		  </div>
		  </div>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.validationEngine-en.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.validate.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>holder.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.uniform.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jasny-bootstrap.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.form.min.js"></script>
        <script src="<?php echo HTTP_JS_PATH; ?>/jquery.ui.touch-punch.min.js"></script>
   <script src="<?php echo HTTP_JS_PATH; ?>jquery.validationEngine.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.validationEngine-en.min.js"></script>
     <script src="<?php echo HTTP_JS_PATH; ?>jquery.validate.min.js"></script>
<?php
$this->load->view('admin/vwFooter');
?>
   <script>
      $(function() {
        
         $('#product-validation').validationEngine();
      });
    </script>