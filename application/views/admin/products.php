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
                    <h5>Product List</h5>
					<a  class="btn btn-primary add-btn" href="<?php echo base_url(); ?>admin/products/add_products">Add Products </a>
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
                          <th>Product Id</th>
                          <th>Product Name</th>
						  <th>Product Sku</th>
						  <th>Product Status</th>
                          <th>Product Desc</th>
						  <th>Edit / Delete/Add View</th>
                        </tr>
                      </thead>
                      <tbody>
							<?php
						if(isset($stores))
						{
							foreach($stores as $row)
							{
								echo '<tr>
								<td>'.$row['product_id'].'</td>
								<td>'.ucfirst($row['product_name']).'</td>
								<td>'.ucfirst($row['product_sku']).'</td>
								<td>'.ucfirst($row['product_status']).'</td>
								<td>'.substr(ucfirst($row['product_desc']),1,30).'......</td>		
								<td>
                <a  class="" href="'.base_url().'admin/products/edit_products/'.$row['product_id'].'"><i class="glyphicon glyphicon-edit"></i> </a>
                <a  class="" href="'.base_url().'admin/products/delete_products/'.$row['product_id'].'"><i class="glyphicon glyphicon-trash"></i> </a>
                <a  class="" href="'.base_url().'admin/ProductViews/index/'.$row['product_id'].'">Views</a>
                </td>												
								</td>                      
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

            <!--End Datatables-->
           


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