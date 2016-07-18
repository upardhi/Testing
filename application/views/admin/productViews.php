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
                    <h5>Add Product Views</h5>
          <a  class="btn btn-primary add-btn" href="<?php echo base_url(); ?>admin/ProductViews/add_view/<?php echo $product_id; ?>">Add Product View </a>
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
                          <th>Id</th>
                          <th>View Name</th>
                           <th>Template Name</th>
                          <th>Edit / Delete/PreviewViews </th>
                        </tr>
                      </thead>
                      <tbody>
              <?php
            if(isset($product_view_data))
            {
              foreach($product_view_data as $row)
              {
                echo '<tr>
                <td>'.$row['view_id'].'</td>
                <td>'.ucfirst($row['view_name']).'</td>  
                 <td>'.ucfirst(isset($row['template_name']) ? $row['template_name']: '').'</td>  
                <td>
                <a  class="" href="'.base_url().'admin/ProductViews/add_view/'.$product_id.'/'.$row['view_id'].'"><i class="glyphicon glyphicon-edit"></i> </a>
                <a  class="" href="'.base_url().'admin/ProductViews/delete_product_view/'.$product_id.'/'.$row['view_id'].'"><i class="glyphicon glyphicon-trash"></i> </a></td> 

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