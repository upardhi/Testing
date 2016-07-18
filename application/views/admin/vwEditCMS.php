<?php
$this->load->view('admin/vwHeader');
?>
<!--  
Author : Abhishek R. Kaushik 
Downloaded from http://devzone.co.in
-->
 
<script src="<?php echo HTTP_ASSETS_PATH_ADMIN; ?>tinymce/tinymce.min.js"></script>
<script>

    tinymce.init({selector: 'textarea',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste jbimages"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
        relative_urls: false,
         

    height: "500",
    width:900
    });
</script>

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1>CMS <small>Edit Page</small></h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>admin/cms/"><i class="icon-dashboard"></i> CMS</a></li>
                <li class="active"><i class="icon-file-alt"></i> Edit Page</li>        


            </ol>
        </div>
    </div><!-- /.row -->


    <div class="fld">
        <form method="post" action="<?php echo base_url(); ?>admin/cms/update_cms">
        <table>
            <tr><td>Page</td><td>&nbsp;</td><td><?php  
                    echo isset($cms[0]['label']) && !empty($cms[0]['label']) ? $cms[0]['label'] : '';     
                    ?></td></tr>
              <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
              <tr><td>Content</td><td>&nbsp;</td><td>  <input type="hidden" value="<?php echo isset($cms[0]['id']) && !empty($cms[0]['id']) ? $cms[0]['id'] : '';?>" name="pst_id"> 
                      <textarea name="tst_content"><?php  
                    echo isset($cms[0]['content']) && !empty($cms[0]['content']) ? $cms[0]['content'] : '';     
                    ?></textarea>

                </td></tr>
              <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="btn_submit" class="btn btn-primary" value="Submit"></td></tr>
        </table>        
        </form>
    </div>      

</div><!-- /#page-wrapper -->

<?php
$this->load->view('admin/vwFooter');
?>