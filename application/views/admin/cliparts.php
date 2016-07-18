<?php
$this->load->view('admin/vwHeader');
?>
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>dataTables.bootstrap.css">


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
                    <h5>Clipart List</h5>
					<a  class="btn btn-primary add-btn" href="<?php echo base_url(); ?>admin/Cliparts/add_cliparts">Add Cliparts </a>
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
                          <th>Clipart Id</th>
                          <th>Clipart Name</th>						
                          <th>Clipart Image</th>
						  <th>Edit / Delete</th>
                        </tr>
                      </thead>
                      <tbody>
							<?php
						if(isset($cliparts))
						{
							foreach($cliparts as $row)
							{
								echo '<tr>
								<td>'.$row['clipart_id'].'</td>
								<td>'.ucfirst($row['clipart_client_name']).'</td>
								
								<td class="tbl-img-wrap"><image src="'.CLIPART_IMAGE_ABS_PATH.$row['clipart_image_name'].'" </image></td>		
								<td><a  class="" href="'.base_url().'admin/cliparts/delete_clipart/'.$row['clipart_id'].'"><i class="glyphicon glyphicon-trash"></i> </a></td>												
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

         


          </div><!-- /.inner -->
        </div><!-- /.outer -->
      </div><!-- /#content -->
	  

	  
	  <?php
$this->load->view('admin/vwFooter');
?>

    <script src="<?php echo HTTP_JS_PATH; ?>/jquery-ui.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.dataTables.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>dataTables.bootstrap.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>/jquery.tablesorter.min.js"></script>
    <script src="<?php echo HTTP_JS_PATH; ?>/jquery.ui.touch-punch.min.js"></script>
	
	 <script>
      $(function() {
        Metis.MetisTable();
       // Metis.metisSortable();
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
	</style>
	