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
                    <h5>Font List</h5>
        
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
                          <th>Font Id</th>
                          <th>Font Display Name</th>
                          <th>Font Code</th>
                          <th>Font Image</th>
                          <th>Edit / Delete</th>
                        </tr>
                      </thead>
                      <tbody>
              <?php
            if(isset($fonts))
            {
              foreach($fonts as $row)
              {
                echo '<tr>
                <td>'.$row['font_id'].'</td>
                <td>'.ucfirst($row['font_display_name']).'</td>
                <td>'.ucfirst($row['font_code']).'</td>
                <td class="tbl-img-wrap">';
                if(isset($row['font_image'])){ 
                  echo '<image src="'.FONTS_IMAGE_ABS_PATH.$row['font_image'].'" </image>';
                }else{
                  echo 'No Image';
                }
                echo 
                '</td>    
                <td><a  class="" href="'.base_url().'admin/fonts/index/'.$row['font_id'].'"><i class="glyphicon glyphicon-edit"></i> </a><a  class="" href="'.base_url().'admin/products/delete_clipart/'.$row['font_id'].'"><i class="glyphicon glyphicon-trash"></i> </a></td>                       
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
                    <h5>Add fonts</h5>
                  </header>
                  <div class="body">
                    <div class="clearfix"> </div>
                    <form id="font-validation" class="form-inline"  enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/fonts/index" method="post">
                      <div class="row form-group">
              <input type="hidden" name="font_id" value="<?=(isset($fonts_data) ? $fonts_data->font_id : 0)?>"/>
                        <div class="col-lg-3">
                          <input class="form-control autotab validate[required]" type="text" maxlength="100" tabindex="11" placeholder="Font Name"   name="font_name" value="<?=(isset($fonts_data) ? $fonts_data->font_name : '')?>">
                        </div><!-- /.col-lg-4 -->
                        <div class="col-lg-3">
                          <input class="form-control autotab validate[required]" type="text" maxlength="100" tabindex="12" placeholder="Font Display Name" name="font_display_name" value="<?=(isset($fonts_data) ? $fonts_data->font_display_name : '')?>">
                        </div><!-- /.col-lg-4 -->
                        <div class="col-lg-3">
                          <input class="form-control " type="text" maxlength="5" tabindex="13" placeholder="Font Code" name="font_code" value="<?=(isset($fonts_data) ? $fonts_data->font_code : '')?>">
                        </div>
            <div class="col-lg-3">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file">
                  <span class="fileinput-new">Select file</span> 
                            <span class="fileinput-exists">Change</span> 
                              <input type="file" name="font_image" >
                            </span> 
                            <span class="fileinput-filename tbl-img-wrap <?=(isset($fonts_data) ? 'image-width' : '')?>"><?php if(isset($fonts_data->font_image)){  ?><img  class="img-src" src="<?= FONTS_IMAGE_ABS_PATH.$fonts_data->font_image;  ?>" /><?php  }?></span> 
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a> 
                          </div>
                        </div>
                      </div><!-- /.row -->
                      <div class="row form-group">
                        <div class="col-lg-4">
                          <input type="submit" value="Save font"  name="save_font" class="btn btn-primary">
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
         $('#font-validation').validationEngine();
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
  .image-width{    width: 50px;
    height: 30px; vertical-align: bottom;}
    [data-provides="fileinput"]{    padding-bottom: 0;
    margin-bottom: 0;}
  </style>
  