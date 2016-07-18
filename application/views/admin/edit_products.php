<?php
$this->load->view('admin/vwHeader');
?>
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
                    <form class="form-horizontal" id="popup-validation" action="<?php echo base_url(); ?>admin/Products/edit_products/<?= $product_id; ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="product_id" value="<?=(isset($product_data) ? $product_data->product_id : '')?>"/>
					<?=form_error('product_name'); ?>		
					<?=form_error('product_sku'); ?>		
					<?=form_error('product_store_id'); ?>								
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
                          <input type="text" class="validate[required] form-control" name="product_name" id="req" value="<?=(isset($product_data) ? $product_data->product_name : '')?>">
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-lg-4">Product SKU</label>
                        <div class="col-lg-4">
                          <input type="text" class="validate[required] form-control" name="product_sku" id="req1"    value="<?=(isset($product_data) ? $product_data->product_sku : '')?>">
                        </div>
                      </div>
					 
                      <div class="form-group">
                        <label class="control-label col-lg-4">Product Description</label>
                        <div class="col-lg-4">
                          <textarea class=" form-control" name="product_desc" ><?=(isset($product_data) ? $product_data->product_desc : '')?></textarea>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-lg-4">Store</label>
                        <div class="col-lg-4">
                          <select data-placeholder="Choose a Stores" class="form-control chzn-select" multiple="" tabindex="4" name="product_store_id[]"  id="stores">
                           
							<?php
							
									if(isset($stores))
									{
										foreach($stores as $row)
										{
											echo '<option value="'.$row['store_id'].'"  id="'.$row['store_id'].'" >'.$row['store_name'].'</option>';
											 
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
                              <input class="uniform" type="radio" name="product_status"   id="active"  >Active
                            </label>
                          </div>
						  
						  <div class="checkbox">
                            <label>
                              <input class="uniform" type="radio" name="product_status"  id="inactive" >Inactive
                            </label>
                          </div>
						  
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-lg-4">Image Upload</label>
                        <div class="col-lg-8">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><image src="<?php echo HTTP_PRODUCT_IMAGES_PATH ?><?= $product_data->product_image?>" </img>
							</div>
                            <div>
                              <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span> <span class="fileinput-exists">Change</span> 
                                <input type="file" name="product_image">
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
		  <script>
		 jQuery(document).ready(function(){
			   
					var selectedStores=<?php echo $product_store_mapping ;?>;
					jQuery.each(selectedStores,function(key,val){
						jQuery('#'+val.stores_store_id).attr('selected','selected');
						
						
					})
				var productStatus=<?= $product_data->product_status; ?>;
				if(productStatus){
					jQuery('#active').prop('checked','checked');
					jQuery('#active').val(true);
					jQuery('#inactive').val(false);

				}else{
					
					jQuery('#inactive').prop('checked','checked');
					jQuery('#inactive').val(false);
				}
		  })
		 
		   
			
		  </script>

<?php
$this->load->view('admin/vwFooter');
?>