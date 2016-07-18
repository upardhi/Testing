

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
   <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>main.min.css">
	    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>jasny-bootstrap.min.css">
	 <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>validationEngine.jquery.min.css">

    <!-- metisMenu stylesheet -->
    <link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>metisMenu.min.css">
  </head>
  <body class="login">
    <div class="form-signin">
      <div class="text-center">
        <img src="assets/img/logo.png" alt="Metis Logo">
      </div>
      <hr>
      <div class="tab-content">
        <div id="login" class="tab-pane active">
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
					<?=form_error('firstname'); ?>
					<?=form_error('lastname'); ?>
					<?=form_error('email'); ?>
						<?php
					if(isset($error)) echo '<p class="alert alert-danger">'.$error.'</p>';
					?>
          <form action="<?php echo base_url(); ?>signup/login" method="post">
            <p class="text-muted text-center alert alert-success">
              Enter your username and password
            </p>
            <input type="text" placeholder="Email"  name="email" class="form-control top">
            <input type="password" placeholder="Password"  name="password" class="form-control bottom">

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="loginbttn"> Sign in</button>
          </form>
        </div>
        <div id="forgot" class="tab-pane">
          <form action="index.html">
            <p class="text-muted text-center">Enter your valid e-mail</p>
            <input type="email" placeholder="mail@domain.com" class="form-control">
            <br>
            <button class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
          </form>
        </div>
        <div id="signup" class="tab-pane">
          <form action="<?php echo base_url(); ?>signup/newadmin" method="post">
		    <input type="text" placeholder="First Name" name="firstname" class="form-control top validate[required]" value="<?= isset($form_data)?$form_data['firstname']:'' ?>" />
			<input type="text" placeholder="Last Name" name="lastname" class="form-control top validate[required]"  value="<?= isset($form_data)?$form_data['lastname']:'' ?>">
			<input type="text" placeholder="Mobile Number" name="mobilenumber" class="form-control top validate[required,custom[number],maxSize[10]]" value="<?= isset($form_data)?$form_data['mobilenumber']:'' ?>">
			<input type="text" placeholder="Company" name="company" class="form-control top  validate[required]"  value="<?= isset($form_data)?$form_data['company']:'' ?>">
            <input type="text" placeholder="Email" name="email" name="email" class="form-control middle validate[required,custom[email]]"  value="<?= isset($form_data)?$form_data['email']:'' ?>">
            <input type="password" placeholder="Password"  name="password" password="password" class="form-control middle validate[required]" id="pass1">
            <input type="password" placeholder="Re-password" class="form-control bottom validate[required,equals[pass1]]">
            <button class="btn btn-lg btn-success btn-block" type="submit" name="createadminbttn">Register</button>
          </form>
        </div>
      </div>
      <hr>
      <div class="text-center">
        <ul class="list-inline">
          <li> <a class="text-muted" href="#login" data-toggle="tab">Login</a>  </li>
          <li> <a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a>  </li>
          <li> <a class="text-muted" href="#signup" data-toggle="tab">Signup</a>  </li>
        </ul>
      </div>
    </div>

    <!--jQuery -->
       <script src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>

    <!--Bootstrap -->
      <!--Bootstrap -->
    <script src="<?php echo HTTP_JS_PATH; ?>bootstrap.min.js"></script>
		 <script src="<?php echo HTTP_JS_PATH; ?>jquery.validationEngine.min.js"></script>
	  <script src="<?php echo HTTP_JS_PATH; ?>jquery.validationEngine-en.min.js"></script>
	   <script src="<?php echo HTTP_JS_PATH; ?>jquery.validate.min.js"></script>
    <script type="text/javascript">
	   $(function() {
        
         $('#signup').validationEngine();
      });
      (function($) {
		  
        $(document).ready(function() {
          $('.list-inline li > a').click(function() {
            var activeForm = $(this).attr('href') + ' > form';
            //console.log(activeForm);
            $(activeForm).addClass('animated fadeIn');
            //set timer to 1 seconds, after that, unload the animate animation
            setTimeout(function() {
              $(activeForm).removeClass('animated fadeIn');
            }, 1000);
          });
        });
      })(jQuery);
    </script>
  </body>
</html>























