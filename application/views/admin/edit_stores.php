<?php
$this->load->view('admin/vwHeader');
?>

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
                    <h5> Edit Store</h5>

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
                    <form class="form-horizontal" id="popup-validation" action="<?php echo base_url(); ?>admin/administrator/edit_stores/<?php echo $store_id ?>" method="post">
					<input type="hidden" name="store_id" value="<?=(isset($stores_data) ? $stores_data->store_id : '')?>"/>
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
                        <label class="control-label col-lg-4">Store Name</label>
                        <div class="col-lg-4">
                          <input type="text" class="validate[required] form-control" name="store_name" id="req"  value="<?=(isset($stores_data) ? $stores_data->store_name : '')?>">
                        </div>
                      </div>
					 
                      <div class="form-group">
                        <label class="control-label col-lg-4">Store Description</label>
                        <div class="col-lg-4">
                          <textarea class=" form-control" name="store_desc" > <?=(isset($stores_data) ? $stores_data->store_desc : '')?></textarea>
                        </div>
                      </div>

                      <div class="form-actions no-margin-bottom">
                        <input type="submit" value="Update Store"  name="save_store" class="btn btn-primary">
						<a  class="btn btn-primary" href="<?php echo base_url(); ?>admin/administrator/stores">Back To Stores</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
		  </div>
		  </div>
		  </div>

<?php
$this->load->view('admin/vwFooter');
?>