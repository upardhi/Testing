                <div class="alert alert-info" role="alert">These rules are directly applied to the view lavel.</div>
                <div  class="col-lg-6">
                   <div class="checkbox anim-checkbox">
                      <input type="checkbox" id="showAddTextButton" class="success">
                      <label for="showAddTextButton">Show Add Text Btn</label>
                   </div>
                    <div class="checkbox anim-checkbox">
                      <input type="checkbox" id="allowText" class="success">
                      <label for="allowText">Allow Text</label>
                    </div>
                    <div class="checkbox anim-checkbox">
                      <input type="checkbox" id="allowBringForward" class="success">
                      <label for="allowBringForward">Bring Forwards</label>
                    </div>
                    <div class="checkbox anim-checkbox">
                      <input type="checkbox" id="bringToFront" class="success">
                      <label for="bringToFront">Bring To Front</label>
                    </div>
                 </div>

                <div  class="col-lg-6">
                     <div class="checkbox anim-checkbox">
                        <input type="checkbox" id="showAddImageButton" class="success">
                        <label for="showAddImageButton">Show Add Image Btn</label>
                     </div>
                     <div class="checkbox anim-checkbox">
                        <input type="checkbox" id="allowImage" class="success">
                        <label for="allowImage">Allow Image</label>
                     </div>
                     <div class="checkbox anim-checkbox">
                        <input type="checkbox" id="sendToBack" class="success">
                        <label for="sendToBack">Send To Back</label>
                     </div>
                    <div class="checkbox anim-checkbox">
                      <input type="checkbox" id="sendBackwards" class="success">
                      <label for="sendBackwards">Send Backwards</label>
                    </div>
                </div>
                <button class="btn btn-primary btn-flat" data-btn="saveGlobalRule" style="margin-bottom: 5px;">Save global rule for this view</button>

<script type="text/javascript">

  $(document).ready(function(){
    var globalRuleJson={};

    function saveGlobalRule(){
      $('[data-container="globalRule"] input').each(function(key,val){
        var id= $(this).attr('id');
        var status= $(this).prop('checked');
       globalRuleJson[id]=status;

      })  
      var globalRuleData={};

      globalRuleData.rule_view_id=viewId;
      globalRuleData.rule_type=1;
      globalRuleData.rule_allow_json=globalRuleJson;
      var url;
     
       url="<?= base_url(); ?>admin/ProductViews/save_global_rule";
      

      $.ajax({
      url:url,
      method:'POST',
      contentType:"application/x-www-form-urlencoded; charset=UTF-8",
      data: {"ruleData":JSON.stringify(globalRuleData),"rule_id":ruleId},
      success:function(resonse){
        $('#message').html('Your global rule save against this view.')
            $('#myModal2').modal('show');
            ruleId=resonse

      },
      error:function(){
          $('#message').html('Sorry we are unable to save global rule.')
            $('#myModal2').modal('show');
      }


    })
    }

    function setGlobalRuleValues(){
      if(ruleAllowJson){
        var decodedJson=JSON.parse(ruleAllowJson);
         $.each(decodedJson,function(key,val){
            $('#'+key).prop('checked',val);


         })

      }

    }

    setGlobalRuleValues();
    $(document).on('click','[data-btn="saveGlobalRule"]',saveGlobalRule)




  });

</script>


