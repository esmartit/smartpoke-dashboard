<?php

  include('library/config_read.php');

  $lang = $configValues['LANG'];
  if (isset($_POST['lang']))
    $lang = $_POST['lang'];
	elseif (isset($_GET['lang']))
    $lang = $_GET['lang'];

  $loginpath = $_SERVER['PHP_SELF'];
  include('lang/main.php');

  if (isset($_POST['error']))
    $err = $_POST['error'];
  elseif (isset($_GET['error']))
    $err = $_GET['error'];
  else
    $err = 1;

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	 	<link rel="icon" href="images/favicon.png" type="image/ico" />

    <title><?php echo $l_title ?></title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->	
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="bg-white">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <img src="images/logo.jpg">
            <form name="login_form" method="POST" action="dologin.php">
              <h1><?php echo $l_titleform ?></h1>
              <div class="x_content" align="right">
							  <select id="selLang" class="btn btn-default" name="lang" onChange="changeLang()">
                  <option value="<?php echo $lang ?>"><?php echo $language ?></option>
                  <option value="es">Espa&ntildeol</option>
                  <option value="en">English</option>
                </select>
              </div>
              <br>
              <br>
              <br>
              <div>
                <input type="text" class="form-control" placeholder="<?php echo $l_username ?>" name="operator_user" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="<?php echo $l_password ?>" name="operator_pass" />
              </div>
							<div>
								<?php
								  if ( $err == 0 ) {
		                echo "<div class='alert alert-danger' role='alert'> 
		                    <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
		                    <span class='sr-only'></span>
		                    <i>$l_err_message</i>
		                </div>";								  	
								  }									
								?>
              </div>
							<div>
                <input type="submit" class="btn btn-default submit" name="button" value="<?php echo $l_login ?>" />
              </div>

              <div class="clearfix"></div>

			        <!-- footer content -->
		          <div>
                <p><?php echo $l_footer;?></p>
		          </div>
		          <div class="clearfix"></div>
			        <!-- /footer content -->
            </form>
          </section>
        </div>
      </div>
    </div>

   <!-- Reset Form -->
	 <script>
		function changeLang() {
			var opc_lang = document.getElementById("selLang").value;

			window.location="<?php echo $loginpath;?>"+"?lang="+opc_lang;			
		};
	 </script>
   <!-- /Reset Form -->			

  </body>
</html>
