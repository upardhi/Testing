<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>application_assets/styles/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>application_assets/styles/bootstrap-colorpicker.min.css">
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-md-7 col-sm-6 no-padding showcase leftDivManagable"> 
      <script type="text/javascript">
    var viewId= '<?= $view_id ?>';
    var canvas='';
    var globalRuleReceivedData=<?= $global_rule_data; ?>;
    var templateId=<?= $view_data->view_template_id; ?>;
     var ruleId='';
     var ruleAllowJson='';
    if(globalRuleReceivedData){
         ruleId=globalRuleReceivedData['rule_id'];
          ruleAllowJson=globalRuleReceivedData['rule_allow_json'];

    }


    var templateRenderingData='';
    var width=<?= $view_data->view_width; ?>;
    var height=<?= $view_data->view_height; ?>;
    var canvas_top= <?= $view_data->view_y; ?>;
    var canvas_left= <?= $view_data->view_x; ?>;
    var placeHolderImagePath='<?= base_url();?>'+'/application_assets/img/placeholder2.png';
    var saveGlobalRuleUrl="<?= base_url(); ?>admin/ProductViews/save_design";
    var updateGlobalRuleUrl="<?= base_url(); ?>admin/ProductViews/update_design";
    var getRuleDetails="<?= base_url(); ?>admin/ProductViews/get_rule_details";
  
    var $templateDesign='';
    $(document).ready(function(){
       templateRenderingData={"parent":"[data-editor-view-id = '1120']","templateData":{"applicationType":"editor","viewId":1120,"variantId":1218,"image":{"width":600,"height":600,"title":"Front","src":"img/"},"canvas":{"width":476,"height":524,"top":21,"left":61}},"borderWidth":2,"padding":5};
      templateRenderingData.parent="[data-editor-view-id = '<?= $view_id ?>']";
      templateRenderingData.templateData.viewId= '<?= $view_id ?>';
      templateRenderingData.templateData.image.width=<?= $product_data->product_width; ?>;
      templateRenderingData.templateData.image.height=<?= $product_data->product_height; ?>;
      templateRenderingData.templateData.image.title="<?= $view_data->view_name; ?>";
      templateRenderingData.templateData.canvas.width=<?= $view_data->view_width; ?>;
      templateRenderingData.templateData.canvas.height=<?= $view_data->view_height; ?>;
      templateRenderingData.templateData.canvas.top=<?= $view_data->view_x; ?>;
      templateRenderingData.templateData.canvas.left=<?= $view_data->view_y; ?>;
       $templateDesign= '<?= $template_design_json; ?>'
       canvas=createCanvas(templateRenderingData,1).fabricObject;
      
    debugger;
    
    })
  </script>
      <div class="art-editor-container" data-art-container="editor-container">
        <div class="art-prod-img-area" data-art-container="image-area">
          <table data-art-container="product-image-table" data-art-editor-container-id="<?= $view_id?>" style="height: 100%; width: 100%; text-align: center;">
            <tbody>
              <tr>
                <td style="vertical-align:top;"><div data-art-container="product-image-container" data-editor-view-id="<?= $view_id?>" data-editor-variant-id="<?= $view_id?>" style="position: relative; width: <?= $product_data->product_width; ?>px; height: <?= $product_data->product_height; ?>px;">
                    <div class="is_center" data-component-type="product-parent" data-view-id="<?= $view_id?>" data-variant-id="<?= $view_id?>" data-application-type="editor" style="width: <?= $view_data->view_width; ?>px; height: <?= $view_data->view_height; ?>px;">
                      <div data-art-product-image-holder="product-image-holder">
                        <?php if(!empty($view_data->view_image)){ ?>
                        <img data-component-type="product-image" src="<?php echo VIEW_IMAGES_ABS_PATH.$view_data->view_image; ?>" class="productImage" alt="Front" width="<?= $product_data->product_width; ?>" height="<?= $product_data->product_height; ?>" data-view-id="<?= $view_id?>"/>
                        <?php }else { ?>
                        <img data-component-type="product-image" src="<?php echo PRODUCT_IMAGES_ABS_PATH.$product_data->product_image; ?>" class="productImage" alt="Front" width="<?= $product_data->product_width; ?>" height="<?= $product_data->product_height; ?>" data-view-id="<?= $view_id?>" />
                        <?php } ?>
                      </div>
                      <div data-component-type="canvas-container" class="editorContainer" width="<?= $view_data->view_width; ?>" height="<?= $view_data->view_height; ?>" style="position: absolute; width: <?= $view_data->view_width; ?>px; height: <?= $view_data->view_height; ?>px; left: <?= $view_data->view_x; ?>px; top: <?= $view_data->view_y; ?>px;">
                        <canvas data-component-type="canvas" id="editor_<?= $view_id?>" width="<?= $view_data->view_width; ?>" height="<?= $view_data->view_height; ?>" style="width: <?= $view_data->view_width; ?>px; height: <?= $view_data->view_height; ?>px; "></canvas>
                      </div>
                    </div>
                  </div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <!-- <img src="img/tshirt.png" style="width: 83%;margin: 3% 8%;"> --> 
      
    </div>
    <div class="col-lg-5 maindiv" id="mydesignmall">
      <div class="divleft">
        <ul class="list-group leftAccordion">
          <li class="list-group-item tab-header"> <a href="#styleAndColor" data-toggle="tab" class="style"> <span class="glyphicon glyphicon-wrench"></span> <span class="font-style">Cliparts</span> <span class="glyphicon glyphicon-chevron-right pull-right"></span> </a> </li>
          <li class="list-group-item tab-header"> <a href="#picture" data-toggle="tab" class="pictures"> <span class="glyphicon glyphicon-picture"></span> <span class="font-style">My pictures</span> <span class="glyphicon glyphicon-chevron-right pull-right"></span> </a> <span class="glyphicon glyphicon-plus-sign pull-right arrow-right add-popup" data-toggle="modal" data-target="#myModal"></span> </li>
          <li class="list-group-item tab-header"> <a href="#cliparts" data-toggle="tab" class="clipart"> <span class="glyphicon glyphicon-star-empty"></span> <span class="font-style">Image</span> <span class="glyphicon glyphicon-chevron-right pull-right"></span> </a> </li>
          <li class="list-group-item tab-header"> <a href="#texts" data-toggle="tab" class="Text"> <span class="glyphicon glyphicon-text-width"></span> <span class="font-style">Text</span> <span class="glyphicon glyphicon-chevron-right pull-right"></span> </a> </li>
          <li class="list-group-item tab-header"> <a href="#otherGoods" data-toggle="tab" class="other-goods"> <span class="glyphicon glyphicon-share"></span> <span class="font-style">Global Rules</span> <span class="glyphicon glyphicon-chevron-right pull-right"></span> </a> </li>
           <li class="list-group-item tab-header"> <a href="#imageRules" data-toggle="tab" class="other-goods"> <span class="glyphicon glyphicon-share"></span> <span class="font-style">Image Rules</span> <span class="glyphicon glyphicon-chevron-right pull-right"></span> </a> </li>

        </ul>
        <ul class="list-group rightPanels">
          <li id="styleAndColor"> <span class="tab-header text-header">
            <button class="btn btn-small btn-back" data-btn='back'><span class="glyphicon glyphicon-chevron-left"></span>Back</button>
            <span>Clipart Image</span> </span>
            <div class="mid-container">
              <?php
                    if(isset($cliparts))
                    {
                      echo '<ul class="image-grid" data-container="cliparts">';
                      foreach($cliparts as $row)
                      {
                        echo '<li onclick="updateImage(this)" data-image="'.CLIPART_IMAGE_ABS_PATH.$row['clipart_image_name'].'"><image title="'.$row['clipart_client_name'].'" src="'.CLIPART_IMAGE_ABS_PATH.$row['clipart_image_name'].'" </image></li>';
                      }
                      echo "</ul>";
                      
                    }
                    ?>
            </div>
          </li>
          <li id="picture"> <span class=" tab-header  text-header">
            <button class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span>Back</button>
            <span>My pictures</span> </span>
            <div class="mid-container">
              <h4 h4 class="text-primary">My pictures</h4>
              <input type="checkbox">
              Background Print Area </div>
          </li>
          <li id="cliparts"> <span class="tab-header  text-header">
            <button class="btn btn-default" data-btn='back'><span class="glyphicon glyphicon-chevron-left"></span>Back</button>
            <span>Image</span> </span>
            <div class="mid-container">
              <div  class="clearfix">
                <button type="button" class="btn btn-info add-text" style="-webkit-user-select: none;    margin-top: 10px;margin-bottom: 5px;" data-original-title="" title="" data-btn='add-image'> <span>Add Image</span> </button>
              </div>
              <div class="canvas-objects" >
                <ul class="image-grid" data-container="image">
                </ul>
              </div>
            </div>
          </li>
          <li id="texts"> <span class="tab-header  text-header">
            <button class="btn btn-default" data-btn='back'><span class="glyphicon glyphicon-chevron-left"></span>Back</button>
            <span>Text</span> </span>
            <div class="mid-container">
              <div  class="clearfix">
                <button type="button" class="btn btn-info add-text" style="-webkit-user-select: none;    margin-top: 10px;margin-bottom: 5px;" data-original-title="" title="" data-btn='add-text'> <span>Add Text</span> </button>
              </div>
              <div class="canvas-objects" data-container="text"> </div>
            </div>
          </li>
          <li id="otherGoods"> <span class="tab-header  text-header">
            <button class="btn btn-default"  data-btn='back'><span class="glyphicon glyphicon-chevron-left"></span>Back</button>
            <span>Text Rules</span> </span>
            <div class="mid-container">
              <div class="clearfix" data-container="globalRule">
                 <?php
                    $this->load->view('admin/admin_application_views/_application_global_rules');
                    ?>
               </div>
               <div class="clearfix" data-container="widgetRule" style="display:none;">
                   <?php
                    $this->load->view('admin/admin_application_views/_application_widget_lavel_rules');
                    ?>
                    <?php
                    $this->load->view('admin/admin_application_views/_application_widget_image_lavel_rules');
                    ?>
               </div>

            </div>
          </li>
          <li id="imageRules"> <span class="tab-header  text-header">
            <button class="btn btn-default"  data-btn='back'><span class="glyphicon glyphicon-chevron-left"></span>Back</button>
            <span>Image Rules</span> </span>
            <div class="mid-container">
              <div class="col-lg-6">
                
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <!-- Modal -->






<?php
                    $this->load->view('admin/admin_application_views/_active_text_properties');
                    ?>

<?php
                    $this->load->view('admin/admin_application_views/_active_image_properties');
                    ?>



 

</div>
<script src="<?php echo base_url();?>application_assets/scripts/cutomize.js"></script> 
<script src="<?php echo base_url();?>application_assets/scripts/bootstrap-colorpicker.min.js"></script> 
<script src="<?php echo base_url();?>application_assets/scripts/fabric.js"></script>
<style type="text/css">
.mid-container .alert{
    padding: 4px;
    margin-bottom: 0px; 

}
</style>
</body></html>