<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

     <title>MyDesignMall</title>

	     <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>font-awesome/css/font-awesome.min.css">

    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>main.min.css">

    <!-- metisMenu stylesheet -->
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>metisMenu.min.css">


    <!--Modernizr-->
    <script src="<?php echo HTTP_JS_PATH; ?>modernizr.min.js"></script>
		<!--jQuery -->
    <script src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>
	    <script>
      less = {
        env: "development",
        relativeUrls: false,
        rootpath: "../assets/"
      };
    </script>
  </head>
  <body class="  ">
    <div class="bg-dark dk" id="wrap">
      <div id="top">

        <!-- .navbar -->
        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container-fluid">

            <!-- Brand and toggle get grouped for better mobile display -->
            <header class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
              </button>
              
            </header>
            <div class="topnav">
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
                  <i class="glyphicon glyphicon-fullscreen"></i>
                </a> 
              </div>
              <div class="btn-group">

                <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                  <i class="fa fa-question"></i>
                </a> 
              </div>
              <div class="btn-group">
                <a href="<?php echo base_url()?>signup/logout" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                  <i class="fa fa-power-off"></i>
                </a> 
              </div>
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Show / Hide Left" data-toggle="tooltip" class="btn btn-primary btn-sm toggle-left" id="menu-toggle">
                  <i class="fa fa-bars"></i>
                </a> 
                <a data-placement="bottom" data-original-title="Show / Hide Right" data-toggle="tooltip" class="btn btn-default btn-sm toggle-right"> <span class="glyphicon glyphicon-comment"></span>  </a> 
              </div>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">


            </div>
          </div><!-- /.container-fluid -->
        </nav><!-- /.navbar -->
  
      
      </div><!-- /#top -->
      <div id="left">
        <div class="media user-media bg-dark dker">
          <div class="user-media-toggleHover">
            <span class="fa fa-user"></span> 
          </div>
          <div class="user-wrapper bg-dark">
    

          </div>
        </div>

        <!-- #menu -->
        <ul id="menu" class="bg-blue dker">
          <li class="nav-header">Menu</li>
          <li class="nav-divider"></li>
          <li class="">
            <a href="dashboard.html">
              <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Dashboard</span> 
            </a> 
          </li>
          <li class="">
            <a href="<?php echo base_url();?>admin/Products/index">
              <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Products</span> 
            </a> 
          </li>
           <li class="">
            <a href="<?php echo base_url();?>admin/Colors/index">
              <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Colors</span> 
            </a> 
          </li>
          <li class="">
            <a href="<?php echo base_url();?>admin/administrator/stores">
              <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Stores</span> 
            </a> 
          </li>
          <li class="">
            <a href="<?php echo base_url();?>admin/Cliparts/index/nop">
              <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Cliparts</span> 
            </a> 
          </li>
          <li class="">
            <a href="<?php echo base_url();?>admin/Fonts/index/nop">
              <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Fonts</span> 
            </a> 
          </li>


         


        </ul><!-- /#menu -->
      </div><!-- /#left -->

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

	  
	  
	  
	  
	  
