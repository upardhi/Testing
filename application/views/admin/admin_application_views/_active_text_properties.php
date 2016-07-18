

<div class="controls clearfix" id="controls" style="display:none;">

  <div class="clearfix">
    <div class="dropdown pull-left" >
      <button class="btn btn-default dropdown-toggle font-family-selected" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Dropdown <span class="caret"></span> </button>
      <ul class="dropdown-menu font-family" aria-labelledby="dropdownMenu1">
      </ul>
    </div>
    <div class="dropdown pull-left" >
      <button class="btn btn-default dropdown-toggle font-align-selected" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Align <span class="caret"></span> </button>
      <ul class="dropdown-menu text-align" aria-labelledby="dropdownMenu1">
        <li><a href="#">Left</a></li>
        <li><a href="#">Center</a></li>
        <li><a href="#">Right</a></li>
      </ul>
    </div>
    <div class="dropdown pull-left">
      <button class="btn btn-default dropdown-toggle font-size-selected" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Size <span class="caret"></span> </button>
      <ul class="dropdown-menu font-sizes" aria-labelledby="dropdownMenu1" >
      </ul>
    </div>
    <div class="font-color color input-group colorpicker-component pull-left" >
      <input type="text" value="#00AABB" class="form-control font-color" style="display:none" />
      <span class="input-group-addon"><i></i></span> </div>
    <div class="stroke-color color input-group colorpicker-component pull-left">
      <input type="text" value="#00AABB" data-container="font-color-select" class="form-control " style="display:none" />
      <span class="input-group-addon"><i class="font-color-select"></i></span> </div>
    <div class="dropdown pull-left" >
      <button class="btn btn-default dropdown-toggle  stroke-width-selected" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" > Stroke <span class="caret"></span> </button>
      <ul class="dropdown-menu font-stroke stroke-width" aria-labelledby="dropdownMenu1">
      </ul>
    </div>
    <button class="btn text-delete-btn btn-danger delete remove" type="button" title="">Delete</button>
  </div>

  <div class="clearfix" data-widget-rule-container="text">
    <div class="col-lg-6"  >
      <div class="checkbox anim-checkbox">
        <input type="checkbox" id="lockMovementX-{id}" data-common-prop="lockMovementX" class="success">
        <label for="lockMovementX-{id}" data-toggle="tooltip" title="Lock Horizontal Move">Lock H Move</label>
      </div>
      <div class="checkbox anim-checkbox">
        <input type="checkbox" id="lockMovementY-{id}" data-common-prop="lockMovementY" class="success">
        <label for="lockMovementY-{id}" data-toggle="tooltip" title="Lock Vertical Move">Lock V Move</label>
      </div>
      <div class="checkbox anim-checkbox">
        <input type="checkbox" id="lockRotation-{id}" data-common-prop="lockRotation" class="success">
        <label for="lockRotation-{id}" data-toggle="tooltip" title="Lock Rotation">Lock Rotation</label>
      </div>
    </div>
    <div class="col-lg-6" >
      <div class="checkbox anim-checkbox">
        <input type="checkbox" id="lockScalingX-{id}" data-common-prop="lockScalingX" class="success">
        <label for="lockScalingX-{id}" data-toggle="tooltip" title="Lock Horizontal Scale">Lock H Scale </label>
      </div>
      <div class="checkbox anim-checkbox">
        <input type="checkbox" id="lockScalingY-{id}" data-common-prop="lockScalingY" class="success">
        <label for="lockScalingY-{id}" data-toggle="tooltip" title="Lock Vertical Scale">Lock V Scale </label>
      </div>
    </div>
  </div>

</div>

<div class="modal fade bs-example-modal-sm in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">Messsage</h4>
      </div>
      <div class="modal-body" id="message"> Please select image object first and <br/>
        then try to update widget. </div>
    </div>
    <!-- /.modal-content --> 
  </div>
</div>


<script type="text/javascript">

$(document).ready(function(){
     $(document).on("click","[data-common-prop]", updateCommonProp);
     $(document).on("click",'.font-family li', updateFontFamily);
     $(document).on("click",'.font-sizes li', updateFontSize);
     $(document).on("click",'.text-align li', updateAlignment);
      $(document).on("click",'.stroke-width li', updateStroke);

    function updateFontFamily(){
      var family=$(this).text();
      fabricObject.getActiveObject().set('fontFamily',family);
      fabricObject.renderAll();
      $('.font-family-selected').html(family);
    
    }
    function updateAlignment(){
      var alignment=$(this).text().toLowerCase();
      fabricObject.getActiveObject().set('textAlign',alignment);
      fabricObject.renderAll();
      $('.font-align-selected').html(alignment);
    }
  
    function updateFontSize(){
      var fontSize=$(this).text();
      fabricObject.getActiveObject().set('fontSize',fontSize);
      fabricObject.renderAll();
      $('.font-size-selected').html(fontSize);
    
  }
    function updateCommonProp(){
        var property=$(this).attr('data-common-prop');
        var val = $(this).prop('checked');
        fabricObject.getActiveObject().set(property,val);
        fabricObject.renderAll();
    }
   
  function updateStroke(){
    var strokeWidth=$(this).text();
    fabricObject.getActiveObject().set('strokeWidth',parseFloat(strokeWidth));
    fabricObject.renderAll();
    $('.stroke-width-selected').html(strokeWidth);
  }
  


})

</script>
<style type="text/css">
.text-delete-btn{font-size: 14px !important;}
</style>
