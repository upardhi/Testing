    <div class="clearfix" style="border-top:1px solid #000;margin-top:10px">
       <div class="clearfix" data-rule-container="text">
          <div class="col-lg-6" >
            <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch112" data-prop="allowTextEdit" class="success">
              <label for="ch112">Allow Text Edit</label>
            </div>
  
            <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch118" data-prop="allowDelete" class="success">
              <label for="ch118">Remove Object</label>
            </div>
          </div>
          <div class="col-lg-6" >
            <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch119" data-prop="allowFontFamily" class="success">
              <label for="ch119">Allow Font Family</label><i id="ch119-list" class="glyphicon glyphicon-th-list"></i>
            </div>
            <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch1110" data-prop="allowFontSize" class="success">
              <label for="ch1110">Allow Font Size</label>
            </div>
            <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch1111" data-prop="allowFontColor" class="success">
              <label for="ch1111">Allow Font Color</label><i id="ch1111-list" class="glyphicon glyphicon-th-list"></i>
            </div>
            <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch1112" data-prop="allowStrokeWidth" class="success">
              <label for="ch1112">Allow Stroke Width</label>
            </div>
            <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch1113" data-prop="allowStrokeColor" class="success">
              <label for="ch1113">Allow Stroke Color</label><i id="ch1113-list" class="glyphicon glyphicon-th-list"></i>
            </div>
            <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch1114" data-prop="allowAlignment" class="success">
              <label for="ch1114">Allow Alignment</label>
            </div>
          </div>
        </div>
         <button class="btn btn-primary btn-flat pull-left" data-btn="saveTextRule" style="margin-bottom: 5px;">Save Text rule</button>
    </div>

     

<!-- Font Dropdown Modal -->
<div id="fontModel" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Font For Current Widget</h4>
      </div>
      <div class="modal-body clearfix " > 
        <div class="checkbox anim-checkbox">
              <input type="checkbox" id="fontSelectall" data-prop="selectAll"  data-which-prop="fontSelection" class="success">
              <label for="fontSelectall">Select All</label>
            </div>
        <ul class="cols">
          
        <?php
                    if(isset($fonts))
                    {
                      foreach($fonts as $row)
                      {
                        echo ' <li >
                                <div class="checkbox anim-checkbox">
                                  <input type="checkbox" id="fontfamily-'.$row['font_id'].'" data-prop="fontSelection" class="success" value="'.$row['font_id'].'">
                                    <label  data-toggle="tooltip" title="'.$row['font_name'].'" for="fontfamily-'.$row['font_id'].'">'.$row['font_name'].'</label>
                                </div> 
                              </li>';
                      }
                    }
                  ?>
        </ul>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat" data-btn="saveFontFamily" data-dismiss="modal">Save Font List</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Font Dropdown Modal END -->

<!-- Color Dropdown Modal -->
<div id="colorModel" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Color For Current Widget</h4>
      </div>
      <div class="modal-body clearfix " > 
        <div class="checkbox anim-checkbox">
              <input type="checkbox" id="ch1112selectall" data-prop="selectAll"  data-which-prop="colorSelection" class="success">
              <label for="ch1112selectall">Select All</label>
            </div>
        <ul class="cols color-cols" id="colorGrid">
          
        <?php
                    if(isset($colors))
                    {
                      foreach($colors as $row)
                      {
                        echo ' <li >
                                <div class="checkbox anim-checkbox">
                                  <input type="checkbox" id="color-'.$row['color_id'].'" data-prop="colorSelection" class="success" value="'.$row['color_id'].'">
                                    <label  data-toggle="tooltip" title="'.$row['color_name'].'" for="color-'.$row['color_id'].'" style="background-color:'.$row['color_hex'].'"></label>
                                </div> 
                              </li>';
                      }
                    }
                  ?>
        </ul>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat" data-btn="saveFontColor" data-dismiss="modal">Save Font Color List</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Color Dropdown Modal END -->

<!-- Stroke Color Dropdown Modal -->
<div id="steokeColorModel" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Stroke Color For Current Widget</h4>
      </div>
      <div class="modal-body clearfix " > 
        <div class="checkbox anim-checkbox">
              <input type="checkbox" id="strokeColor" data-prop="selectAll"  data-which-prop="strokeColorSelection" class="success">
              <label for="strokeColor">Select All</label>
            </div>
        <ul class="cols color-cols" id="colorGrid">
          
        <?php
                    if(isset($colors))
                    {
                      foreach($colors as $row)
                      {
                        echo ' <li >
                                <div class="checkbox anim-checkbox">
                                  <input type="checkbox" id="strokecolor-'.$row['color_id'].'" data-prop="strokeColorSelection" class="success" value="'.$row['color_id'].'">
                                    <label  data-toggle="tooltip" title="'.$row['color_name'].'" for="strokecolor-'.$row['color_id'].'" style="background-color:'.$row['color_hex'].'"></label>
                                </div> 
                              </li>';
                      }
                    }
                  ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-flat" data-btn="saveStrokeColor" data-dismiss="modal">Save Stroke Color List</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Color Dropdown Modal END -->



<script type="text/javascript">
 var selectedFontFamily=[];
  var selectedFontColor=[];
  var selectedStrokeColor=[];
  $('#ch119-list').click(function(){

    if($('#ch119').is(':checked')){

      $('#fontModel').modal('show');
    }else{
      selectedFontFamily=[];
      $('[data-prop="fontSelection"]').removeAttr('checked');
      $('[data-prop="selectAll"]').removeAttr('checked');
    }

  })

  $('#ch1111-list').click(function(){
   
    if($('#ch1111').is(':checked'))
      $('#colorModel').modal('show');
    else{
      selectedFontColor=[];
      $('[data-prop="colorSelection"]').removeAttr('checked');
      $('[data-prop="selectAll"]').removeAttr('checked');
    }
  });

  $('#ch1113-list').click(function(){
   
    if($('#ch1113').is(':checked'))
      $('#steokeColorModel').modal('show');
    else{
      selectedStrokeColor=[];
      $('[data-prop="strokeColorSelection"]').removeAttr('checked');
      $('[data-prop="selectAll"]').removeAttr('checked');
    }
  })

  $('#3434343,#ch114,#ch115,#ch116,#ch117').click(function(){
    var property=$(this).attr('data-common-prop');
    var val = $(this).prop('checked');
    fabricObject.getActiveObject().set(property,val);
    fabricObject.renderAll();
  })


$('#ch119').change(function(){
  if(!$(this).is(':checked')){
      $('[data-prop="fontSelection"]').removeAttr('checked');
      $('[data-prop="selectAll"]').removeAttr('checked');
    }

})





  $(document).ready(function(){
  
    var globalTextRules={};
    function saveRule(type){
      var textRules={}
      var activeTextRule={};
       var textId=canvas.getActiveObject().id;  
      $('[data-rule-container="'+type+'"] [data-prop]').each(function(key,val){
        var id= $(this).attr('data-prop');
        var status= $(this).prop('checked');
        activeTextRule[id]=status;

      });
      activeTextRule['fontId']=selectedFontFamily;
      activeTextRule['colorId']=selectedFontColor;
      activeTextRule['strokeColorId'] = selectedStrokeColor;
     
      textRules.rule_widget_id=textId;
      textRules.rule_view_id=viewId;
      textRules.rule_type=2;
      textRules.rule_widget_type=type;
      if(globalTextRules[textId] && globalTextRules[textId].rule_id){
          textRules.rule_id=globalTextRules[textId].rule_id
      }
    
      textRules.rule_allow_json=activeTextRule;
      globalTextRules[textId]=textRules
      sendRuleDataToServer(textRules);  
    }


    function removeSelectionOfRule(){
      //$('[data-widget-rule-container="text"] input, [data-rule-container="image"] input').prop('checked',false);
    }

    function sendRuleDataToServer(textRules){
      var url="<?= base_url(); ?>admin/ProductViews/save_object_rule";
      $.ajax({
        url:url,
        method:'POST',
        contentType:"application/x-www-form-urlencoded; charset=UTF-8",
        data: {"ruleData":JSON.stringify(textRules),"ruleId":textRules.rule_id},
        success:function(resonse){
            var responseReceived= JSON.parse(resonse);
            globalTextRules[responseReceived.rule_widget_id].rule_id=responseReceived.rule_id;
        },
        error:function(){
            
        }
        })
    }

    

    function saveTextRule(){
        saveRule('text')

    }
    function saveImageRule(){
        saveRule('image');

    }
    function setRuleSelections(){
      var widgetId=fabricObject.getActiveObject().id;
      var widgetRules=globalTextRules[widgetId];

      if(widgetRules && widgetRules.rule_allow_json){
          var selectedRuleData=widgetRules.rule_allow_json;
          $.each(selectedRuleData,function(key,val){
            debugger;
            $('[data-rule-container="'+widgetRules.rule_widget_type+'"] [data-prop="'+key+'"]').prop('checked',val);
             if(key=="fontId"){
               $.each(val,function(k,v){
                 $('#fontfamily-'+v).prop('checked',true);
               })
             }else if(key=="strokeColorId"){
                $.each(val,function(k2,v2){
                 $('#color-'+v2).prop('checked',true);
               })

             }else if(key=="colorId"){
                $.each(val,function(k3,v3){
                 $('#strokecolor-'+v3).prop('checked',true);
               })
             }

          });
      }

    }

    function checkAndGetRule(callback){
        var widgetId=fabricObject.getActiveObject().id;
        if(!globalTextRules[widgetId]){

          $.ajax({
            url:getRuleDetails+'/'+viewId+'/'+widgetId,
            method:'GET',
            contentType:"application/x-www-form-urlencoded; charset=UTF-8",
            success:function(resonse){
              var receivedRuleDetails=JSON.parse(resonse);
              if(resonse && !$.isEmptyObject(receivedRuleDetails)){
                 
                 var allowJson=JSON.parse(receivedRuleDetails.rule_allow_json);
                 receivedRuleDetails["rule_allow_json"]=allowJson;
                 globalTextRules[widgetId]=receivedRuleDetails;
                 callback();

              }
             
            },
            error:function(){
                
            }
            });
        }else{
            callback();

        }
       


    }
   
    
  function saveFontFamily(){
    $('[data-prop="fontSelection"]').each(function(e){
        if($(this).prop('checked'))
          selectedFontFamily.push($(this).val());

    })
  
  }

  function saveFontColor(){
     $('[data-prop="colorSelection"]').each(function(e){
        if($(this).prop('checked'))
          selectedFontColor.push($(this).val());

    })


  }
    function saveStrokeColor(){
       $('[data-prop="strokeColorSelection"]').each(function(e){
        if($(this).prop('checked'))
          selectedStrokeColor.push($(this).val());

    })



    
  }


     $(document).on('click','[data-btn="saveFontFamily"]',saveFontFamily);
     $(document).on('click','[data-btn="saveFontColor"]',saveFontColor);
     $(document).on('click','[data-btn="saveStrokeColor"]',saveStrokeColor);
   
     $(document).on('click','[data-btn="saveTextRule"]',saveTextRule);
     $(document).on('click','[data-btn="saveImageRule"]',saveImageRule);





  fabricObject.on('object:selected', function(e) {
    removeSelectionOfRule();
    selectedFontFamily=[];
    selectedFontColor=[];
    selectedStrokeColor=[];
    $('[data-container="widgetRule"]').show();
   // $('[data-prop="fontSelection"]').prop('checked',false);
    $('[data-prop]').prop('checked',false);
   // $('[data-prop="colorSelection"]').prop('checked',false);
   // $('[data-prop="strokeColorSelection"]').prop('checked',false);
    checkAndGetRule(function(){

      setRuleSelections();
    })
    
  });

  fabricObject.on('selection:cleared', function(obj,t) {
    $('[data-container="widgetRule"] [data-rule-container="text"]').hide();
   
    removeSelectionOfRule();
      
  });
  });






 
</script>

<style type="text/css">

ul.cols {
    -moz-column-count: 4;
    -moz-column-gap: 20px;
    -webkit-column-count: 4;
    -webkit-column-gap: 10px;
    column-count: 4;
       column-gap: 10px;
    padding: 0;
    overflow: hidden;
}
ul.color-cols{
     column-count: 7;
    -moz-column-count:  7;
    -webkit-column-count:  7;

}
.cols .checkbox{  margin-top: 0px; 
     margin-bottom: 0px; }


.cols li{padding-left: 3px;}
#colorGrid li label {width: 30px; height: 30px;display: inline-block;}

</style>
