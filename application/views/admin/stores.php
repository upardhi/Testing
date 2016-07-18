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
                    <h5>Stores List</h5>
					<a  class="btn btn-primary add-btn" href="<?php echo base_url(); ?>admin/administrator/add_stores">Add Store </a>
                  </header>
                  <div id="collapse4" class="body">
                    <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                      <thead>
                        <tr>
                          <th>Store Id</th>
                          <th>Store Name</th>
                          <th>Store Desc</th>
						  <th>Edit / Delete</th>
                        </tr>
                      </thead>
                      <tbody>
							<?php
						if(isset($stores))
						{
							foreach($stores as $row)
							{
								echo '<tr>
								<td>'.$row['store_id'].'</td>
								<td>'.ucfirst($row['store_name']).'</td>
								<td>'.substr(ucfirst($row['store_desc']),1,30).'......</td>		
								<td><a  class="" href="'.base_url().'admin/administrator/edit_stores/'.$row['store_id'].'"><i class="glyphicon glyphicon-edit"></i> </a><a  class="" href="'.base_url().'admin/administrator/delete_stores/'.$row['store_id'].'"><i class="glyphicon glyphicon-trash"></i> </a></td>												
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