/***This function will work when user clicks on link In this code it will get the id of parent element and perform hide and show of ul and li tag. ***/

$(document).ready(function(){
	var font_size_range=128;
	var font_stroke_range=5;
	var font_family=['Impact','Arial','Times New Roman']
	var fontListOptions='';
	var fontFamilyOptions='';
	var fontStrokeOption='';
	for(var i=1; i<=font_size_range;i++){
		fontListOptions+='<li><a href="#">'+(++i)+'</a></li>'
	}
	
	for(var i=0; i<font_family.length;i++){
		fontFamilyOptions+='<li><a href="#">'+font_family[i]+'</a></li>'
	}
	
	for(var i=1; i<=font_stroke_range;i++){
		fontStrokeOption+='<li><a href="#">'+(i-0.5)+'</a></li>'
	}
	
	$('.font-sizes').html(fontListOptions);
	$('.font-family').html(fontFamilyOptions);
	$('.font-stroke').html(fontStrokeOption);
	
})



$("#mydesignmall [data-toggle='tab']").click(function() {				
	var _id = $(this).attr('href');
	$(".divleft").animate({marginLeft: '-365px'},350);	
	$(".rightPanels > "+_id+"").show();		
});
/***This function will work when user click back button from panel div it will close the current div and display ul for listing of elemnts ***/
var _listId;
$("[data-btn='back']").click(function(){	
	$(".divleft").animate({marginLeft: '0px'},350,hideElement);	
	_listId = $(this).closest('li');
});
/** This function is used to hide element based on class or id**/
function hideElement(){
	$(_listId).hide();	
}
$("#openFileUpload").click(function(){
	document.getElementById('file-upload').click();
	
});

$("#btnComputer").click(function(){
	$(".div-computer").show();
	$(".div-google").hide();
});


$("#btnGoogleSearch").click(function(){
	$(".div-google").show();
	$(".div-computer").hide();
});





$(document).ready(function(){
	
	//var templateRenderingData={"parent":"[data-editor-view-id = '1120']","templateData":{"applicationType":"editor","viewId":1120,"variantId":1218,"image":{"width":600,"height":600,"title":"Front","src":"img/"},"canvas":{"width":476,"height":524,"top":21,"left":61}},"borderWidth":2,"padding":5};
	//createCanvas(templateRenderingData,1);
	  $(window).on("resize", changeEditorStyle);
       $(window).on("orientationchange", changeEditorStyle);
	
	
})




















	
    /*for creating canvas component
    @ data (req) : canvas data for drawing editor
    @canvastype (req): for static or dynamic canvas*/
     function createCanvas(data, canvasType) {
		 debugger;
        var fabricObject = null;
        var domData = this.renderDom(data);
        this.dynamicCanvas = canvasType;
        if (this.dynamicCanvas) {
            fabricObject = this.createDynamicCanvas(domData);
        }
        else {
            fabricObject = this.createStaticCanvas(domData);
        }
        if($templateDesign){
		     fabricObject.loadFromJSON($templateDesign,function(){

		        	fabricObject.renderAll();
		        	arrengeText();
					arrengeImage();
		        })

        }
   
       	fabricObject.on('selection:cleared', function(obj,t) {
       		
			removeSelectedObject();
			
		});
		fabricObject.on('object:selected', function(obj) {
			selectObject(obj);
			setSelect(obj.target);
		})

        
        return { fabricObject: fabricObject, domData: domData };
    }

    /*for creating canvas component
    @ data (req) : data for drawing dom
   */
     function renderDom(data) {
        
        var parentContainer = data.parent
        var templateData = data.templateData;
        var borderWidth = data.borderWidth;
        var padding = data.padding;
        var viewsScaleFactor = 1;
        if (typeof templateData.hasCanvasImageSrc == 'undefined' || templateData.hasCanvasImageSrc == null) {
            templateData.hasCanvasImageSrc = false;
        }
        /*rendering template*/
       // $(parentContainer).html($("#create-canvas-tmpl").tmpl(templateData));
     
        /*prepaire selectors*/
        var mainContainer = $(parentContainer);
        var viewsImgList = '[data-view-id="' + templateData.viewId + '"][data-application-type="' + templateData.applicationType + '"]';
        var viewsContainer = $(viewsImgList);
        var image = $(viewsImgList + ' [data-component-type="product-image"]');
        var canvasContainer = $(viewsImgList + ' [data-component-type="canvas-container"]');
        var canvas = $(viewsImgList + ' [data-component-type="canvas"]');
        var canvasImageContainer = $(viewsImgList + ' [data-component-type="canvas-image"]');
        /*taking existing data from selectors*/
        var imageWidth = image.width();
        var imageHeight = image.height();
        var canvasHeight = canvas.height();
        var canvasWidth = canvas.width();
        var containerHeight = mainContainer.height();
        var containerWidth = mainContainer.width();
        /*taking canvas id and other information for creating fabric object*/
        var viewId = templateData.viewId;
        var variantId = templateData.variantId; 
        var canvasId = canvas.attr('id');

        /*calculated scale factor */
        var viewsInformation = { canvas: { width: canvasWidth, height: canvasHeight }, image: { width: imageWidth, height: imageHeight }, container: { width: containerWidth, height: containerHeight }, padding: padding };
        viewsScaleFactor = this.calculateScalingFactor(viewsInformation);

        /*applied scale factor on view images and canvases */
        viewsContainer.css('width', imageWidth * viewsScaleFactor);
        viewsContainer.css('height', imageHeight * viewsScaleFactor);
        image.attr('width', imageWidth * viewsScaleFactor);
        image.attr('height', imageHeight * viewsScaleFactor);
        canvasContainer.css('width', (canvasWidth * viewsScaleFactor) - borderWidth);
        canvasContainer.css('height', (canvasHeight * viewsScaleFactor) - borderWidth);
        canvasImageContainer.css('width', (canvasWidth * viewsScaleFactor) - borderWidth);
        canvasImageContainer.css('height', (canvasHeight * viewsScaleFactor) - borderWidth);
        var canvasContainerTop = parseFloat(canvasContainer.css('top')) * viewsScaleFactor;
        var canvasContainerLeft = parseFloat(canvasContainer.css('left')) * viewsScaleFactor;
        canvasContainer.css('top', canvasContainerTop);
        canvasContainer.css('left', canvasContainerLeft);

        var domData = {
            canvasId: canvasId,
            viewId: parseFloat(viewId),
            variantId: parseFloat(variantId),
            canvasWidth: canvasWidth,
            canvasHeight: canvasHeight,
            scaleFactor: viewsScaleFactor
        };
		changeEditorStyle();
        return domData;
    }
    /*for creating dynamic fabric canvas component
    @ domData (req) : data for drawing dom
   */
  function createDynamicCanvas(domData) {
        var domData = domData;
        //var fabricObject = {};
        fabricObject = new fabric.Canvas(domData.canvasId.toString());
        fabricObject.viewId = domData.viewId;
        fabricObject.setHeight(fabricObject.getHeight() * domData.scaleFactor);
        fabricObject.setWidth(fabricObject.getWidth() * domData.scaleFactor);
        fabricObject.renderAll();
        return fabricObject;
    }
    /*for creating static fabric canvas component
    @ data (req) : data for drawing dom
   */
     function createStaticCanvas(domData) {
        var domData = domData;
        var fabricObject = {};
        fabricObject = new fabric.StaticCanvas(domData.canvasId.toString());
        fabricObject.viewId = domData.viewId;
        fabricObject.setHeight(fabricObject.getHeight() * domData.scaleFactor);
        fabricObject.setWidth(fabricObject.getWidth() * domData.scaleFactor);
        fabricObject.renderAll();
        return fabricObject;

    }
    /*for creating canvas component
    @ data (req) : data for drawing dom
   */
function calculateScalingFactor (_viewsInformation) {

        var viewsScaleFactor = 1;
        var sw = (_viewsInformation.container.width - _viewsInformation.padding) / _viewsInformation.image.width;
        var sh = (_viewsInformation.container.height - _viewsInformation.padding) / _viewsInformation.image.height;

        if (sw <= sh) {
            viewsScaleFactor = sw;
        } else {
            viewsScaleFactor = sh;
        }
        return viewsScaleFactor;
    }
	
	function    setEditorStyle (viewId) {
        var scaleFactor = calculateScaleFactor(viewId);
        var viewContainer = $('[data-editor-view-id="' + viewId + '"]');
        viewContainer.css('transform', 'scale(' + scaleFactor + ',' + scaleFactor + ')');
        viewContainer.css('-webkit-transform', 'scale(' + scaleFactor + ',' + scaleFactor + ')');
        viewContainer.css('-moz-transform', 'scale(' + scaleFactor + ',' + scaleFactor + ')');
        viewContainer.css('-ms-transform', 'scale(' + scaleFactor + ',' + scaleFactor + ')');
        viewContainer.css('-o-transform', 'scale(' + scaleFactor + ',' + scaleFactor + ')');

        /*Calculating left position for product image's view*/
        var left = ($('[data-art-container="editor-container"]').width() - viewContainer.width() * scaleFactor) / 2;
        viewContainer.css('left', left);
    }
	
	    /* calculateScaleFactor function calculates tranform/scaling factor and left alignment to product's image
    @param viewId {string} unique-id of the active product image's view 
    */
    function calculateScaleFactor (viewId) {
        $('[data-art-container="product-image-container"]').css("transform-origin", "0% 0%");
        var viewContainer = $('[data-editor-view-id="' + viewId + '"]');
        var cssWidthScale = $('[data-art-container="image-area"]').width() / viewContainer.width();
        var cssHeightScale = $('[data-art-container="image-area"]').height() / viewContainer.height();
        var scaleFactor = Math.min(cssWidthScale, cssHeightScale);
        return scaleFactor;
    }
	
	    /*
     Triggered on window's resize,orientation change; Gets active product image view's id and passes same to setEditorStyle function
    */
    function changeEditorStyle () {
     
          
            setEditorStyle(viewId);
      
    }
	
	
	var objectArr=[];
	/*Add/Update Code start from here */
	$(document).ready(function(){
		 $(document).on("click","[data-btn='add-text']", addText);
		 $(document).on("click","[data-btn='add-image']", addImage);
		 
		 $(document).on("click",'[data-container="text-object"]', selectWidget);
		  $(document).on("click",'[data-container="image-object"]', selectWidget);
		 $(document).on("keyup",'[data-container="text-object"]', updateText);
		
		 $(document).on("click",'.remove', removeObject);
		
		 $(document).on("click",'#save-design', saveDesign);
		
		 //$(document).on("change",'#showAddTextButton', showDefaultTextObjectSetting);
		 
		
	});
	
	function selectWidget(){
		var id=$(this).attr('data-id');
		var listOfObj=fabricObject.getObjects();
			$.each(listOfObj,function(key,val){
				$('#'+val.id).removeClass('active');
				if(val.id==id){
					fabricObject.setActiveObject(val);
					$('#'+id).addClass('active');
					setSelect(val);
				}
			});
			
	}
	function setSelect(obj){
		$('.font-family-selected').html(obj.fontFamily);
		$('.font-size-selected').html(obj.fontSize);
		$('.stroke-width-selected').html(obj.strokeWidth);
		$('.font-align-selected').html(obj.textAlign);
		$('.font-align-selected').html(obj.textAlign);
		$('#lockMovementX-'+obj.id).prop('checked',obj.lockMovementX);
		$('#lockMovementY-'+obj.id).prop('checked',obj.lockMovementY);
		$('#lockRotation-'+obj.id).prop('checked',obj.lockRotation);
		$('#lockScalingX-'+obj.id).prop('checked',obj.lockScalingX);
		$('#lockScalingY-'+obj.id).prop('checked',obj.lockScalingY);
		$('.font-color-select').css('background-color',obj.fill);
		$('[data-container="font-color-select"]').val(obj.fill);
	}

	function arrengeText(idOfActiveObj){
		var textArr=fabricObject.getObjects('text');
		var ctrlHtml= $('#controls').html();
		objectArr=textArr;
		var textStr='<div class="canvas-object text"  id="{id}"  ><div class="body"><textarea placeholder="Your Text"   data-id="{id}"  class=""    data-container="text-object">{{text}}</textarea></div><div class="controls clearfix" data-container="controls">'+ctrlHtml+'</div></div>';
		var textHtml='';
		$.each(textArr,function(key,val){
			var temp='';
			temp=textStr.replace(/{id}/g,val.id);
			temp=temp.replace('{{text}}',val.text);
			textHtml+=temp;
			
		});
		
		$('[data-container="text"]').html(textHtml);
		
		//$('[data-container="controls"]').html(ctrlHtml.replace(/{id}/g,idOfActiveObj))
		if(idOfActiveObj){
			$('#'+idOfActiveObj).addClass('active');
			$('[data-container="text-object"][data-id='+idOfActiveObj+']').click();
		}
		
		$('.color').colorpicker().on('changeColor', function(e) {
            if($(e.currentTarget).hasClass('font-color')){
				updateColor(e.color.toHex());
			}
			 if($(e.currentTarget).hasClass('stroke-color')){
				 updateStrokeColor(e.color.toHex());
			 }
        });
	}
	
	
	function arrengeImage(imageId){
		var imageArr=fabricObject.getObjects('image');
		var ctrlHtml= $('#image-controls').html();
		imageArr=imageArr;
		var imageStr='<li  id="{id}"  data-container="image-object" data-id="{id}"><img  class="is_center" src="{{src}}"  />'+ctrlHtml+'</li>';
		var imgHtml='';
		$.each(imageArr,function(key,val){
			var temp='';
			temp=imageStr.replace(/{id}/g,val.id);
			temp=temp.replace('{{src}}',val.getSrc());
			imgHtml+=temp;
			
		});
		
		$('[data-container="image"]').html(imgHtml);
		if(imageId)
		$('[data-container="image-object"][data-id='+imageId+']').click();
	}
	
	function updateText(){
		var text=$(this).val();
		fabricObject.getActiveObject().set('text',text);
		fabricObject.renderAll();
		
	}
	
	
	/*Function for Add text*/
	function addText(){
		var id=makeid()
		var text = new fabric.Text('Your Text', { left: 200, top: 100 ,id:id});
		fabricObject.add(text);
		setSelect(text);
		arrengeText(id);
		
	}

	function makeid()
	{
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		for( var i=0; i < 25; i++ )
			text += possible.charAt(Math.floor(Math.random() * possible.length));

		return text;
	}
	
	


	
	
	function updateColor(fontColor){
		
		fabricObject.getActiveObject().set('fill',fontColor);
		fabricObject.renderAll();
		//$('.font-size-selected').html(fontSize);
	}
	function updateStrokeColor(strokeColor){
		fabricObject.getActiveObject().set('stroke',strokeColor);
		fabricObject.renderAll();
	}
	
	function removeObject(){
		fabricObject.getActiveObject().remove();
		fabricObject.renderAll();
		arrengeText();
	}
	
	function addImage(){
		var imageURL= placeHolderImagePath;
		var newId=makeid();
		fabric.Image.fromURL(imageURL, function(object) {
				object.id = newId
				object.left=fabricObject.width/2;
				object.top=fabricObject.height/2;
				object.width=200;
				object.height=200;
				fabricObject.renderAll.bind(fabricObject)
				fabricObject.add(object);
				arrengeImage(newId);
			}, {crossOrigin:'anonymous'});
		};

	function saveDesign(){
		var svg=encodeURIComponent(canvas.toSVG());
		var url;
		if(!templateId){
			 url=saveGlobalRuleUrl;
		}else{
			url=updateGlobalRuleUrl;
		}
		

		var customizeData={design:canvas.toJSON(['id',
			'lockMovementY',
			'lockMovementX',
			'lockScalingX',
			'lockScalingY',
			'lockRotation']),
			top:canvas_top,
			left:canvas_left,
			width:width,
			height:height,
			svg:svg,
			viewId:viewId,
			templateId:templateId
		};
		var svg_data=svg
		$.ajax({
			url:url,
			method:'POST',
			contentType:"application/x-www-form-urlencoded; charset=UTF-8",
			data: {"designData":JSON.stringify(customizeData),"svg":svg},
			success:function(){
				$('#message').html('Design has been saved successfully')
       			$('#myModal2').modal('show');

			},
			error:function(){
				$('#message').html('Design not saved please try later.')
       			$('#myModal2').modal('show');

			}

		})

	}
	function updateImage(event){
		var src= $(event).attr('data-image');
  		var img= new Image();
       var object = canvas.getActiveObject();
       if(object && object.type=="image"){
	       var width=object.width;
	       var height=object.height;
	       img.onload= function (imageElement) {
	         var object = canvas.getActiveObject();

	         object.setElement(img);
	         object.width=width;
	         object.height=height;
	         object.setCoords();
	         canvas.renderAll();
	         arrengeImage(object.id);
	         
	       };
	      img.src=src;
	      img.crossOrigin = 'anonymous';

       }else{
       		$('#message').html('Please select image object first and <br/> then try to update widget.')
       		$('#myModal2').modal('show');

       }
      

	}
	function removeSelectedObject(){
		arrengeText();
		arrengeImage();
	}

	function selectObject(obj){
		$('[data-container="text"] div').removeClass('active')
		$('[data-container="image-object"]').removeClass('active');
		$('[data-rule-container]').hide();
		$('[data-rule-container="'+obj.target.type+'"]').show()
		$('#'+obj.target.id).addClass('active');
	}


	$('[data-prop="selectAll"]').click(function(){

		if($(this).is(':checked')){
			var selelctAllTarget=$(this).attr('data-which-prop');
			$('[data-prop="'+selelctAllTarget+'"]').prop('checked','checked');

		}else{
			var selelctAllTarget=$(this).attr('data-which-prop');
			$('[data-prop="'+selelctAllTarget+'"]').removeAttr('checked');
		}
			


	})
