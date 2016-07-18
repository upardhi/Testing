<?php
$this->load->view('admin/vwHeader');
?>
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jasny-bootstrap.min.css">
	 <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>validationEngine.jquery.min.css">
	
  

      <div id="content">
        <div class="outer">
          <div class="inner bg-light lter">

            <!--Begin Datatables-->
            <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header class="clearfix">
                    <div class="icons">
                      <i class="fa fa-table"></i>
                    </div>
                    <h5>Color List</h5>
				
                  </header>
                  <div id="collapse4" class="body">
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
                    <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                      <thead>
                        <tr>
                          <th>Color Id</th>
                          <th>Color Name</th>
						<th>Color Code</th>
                          <th>Color Image</th>
						  <th>Edit / Delete</th>
                        </tr>
                      </thead>
                      <tbody>
							<?php
						if(isset($colors))
						{
							foreach($colors as $row)
							{
								echo '<tr>
								<td>'.$row['color_id'].'</td>
								<td>'.ucfirst($row['color_name']).'</td>
								<td>'.ucfirst($row['color_code']).'</td>
								<td class="tbl-img-wrap">';
								if(isset($row['color_image'])){ 
									echo '<image src="'.COLOR_IMAGE_ABS_PATH.$row['color_image'].'" </image>';
								}else{
									echo 'No Image';
								}
								echo 
								'</td>		
								<td><a  class="" href="'.base_url().'admin/colors/index/'.$row['color_id'].'"><i class="glyphicon glyphicon-edit"></i> </a><a  class="" href="'.base_url().'admin/products/delete_clipart/'.$row['color_id'].'"><i class="glyphicon glyphicon-trash"></i> </a></td>												
								</tr>';
								
							}
							
						}
						?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- /.row -->
			
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
                    <form id="color-validation" class="form-inline"  enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/colors/index" method="post">
                      <div class="row form-group">
					  	<input type="hidden" name="color_id" value="<?=(isset($colors_data) ? $colors_data->color_id : 0)?>"/>
                        <div class="col-lg-3">
                          <input class="form-control autotab validate[required]" type="text" maxlength="20" tabindex="11" placeholder="Color Name"   name="color_name" value="<?=(isset($colors_data) ? $colors_data->color_name : '')?>">
                        </div><!-- /.col-lg-4 -->
                        <div class="col-lg-3">
                          <input class="form-control autotab validate[required]" type="text" maxlength="7" tabindex="12" placeholder="Color Hex" name="color_hex" value="<?=(isset($colors_data) ? $colors_data->color_hex : '')?>">
                        </div><!-- /.col-lg-4 -->
                        <div class="col-lg-3">
                          <input class="form-control " type="text" maxlength="5" tabindex="13" placeholder="Color Code" name="color_code" value="<?=(isset($colors_data) ? $colors_data->color_code : '')?>">
                        </div>
						<div class="col-lg-3">
							<div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file">
									<span class="fileinput-new">Select file</span> 
                            <span class="fileinput-exists">Change</span> 
                              <input type="file" name="color_image" >
                            </span> 
                            <span class="fileinput-filename tbl-img-wrap <?=(isset($colors_data) ? 'image-width' : '')?>"><?php if(isset($colors_data->color_image)){  ?><img  class="img-src" src="<?= COLOR_IMAGE_ABS_PATH.$colors_data->color_image;  ?>" /><?php  }?></span> 
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a> 
                          </div>
                        </div>
                      </div><!-- /.row -->
                      <div class="row form-group">
                        <div class="col-lg-4">
                          <input type="submit" value="Save Color"  name="save_color" class="btn btn-primary">
                        </div><!-- /.col-lg-6 -->
             
                      </div><!-- /.row -->
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!--END AUTOMATIC JUMP-->
           


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
		.tbl-img-wrap{max-width:100px;max-height:100px; position:relative}
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
	</style>
	