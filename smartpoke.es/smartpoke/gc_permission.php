<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_permission_gc';

  $operator_id = $_SESSION['operator_id'];
  $operator_user = $_SESSION['operator_user'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $client_id = $_SESSION['client_id'];
  $lang = $_SESSION['lang'];
  $currDate = date('Y-m-d H:i:s');

  $session_id = $_SESSION['id'];
  include('lang/main.php');
  
  if (isset($_POST['profile_id']))
    $profile_id = $_POST['profile_id'];
  elseif (isset($_GET['profile_id']))
    $profile_id = $_GET['profile_id'];
  else
    $profile_id = '';  

  include('library/pages_common.php');
  $chk_all_access = check_all($profile_id, 'access', 1, 0);
  $chk_all_add = check_all($profile_id, 'add_btn', 1, 0);
  $chk_all_edit = check_all($profile_id, 'edit_btn', 1, 0);
  $chk_all_delete = check_all($profile_id, 'delete_btn', 1, 0);
  $chk_all_show = check_all($profile_id, 'show_btn', 1, 0);

  $pagepath = get_file($page, $operator_profile_id);

  if (isset($_POST['menuoptionprofile_id']))
    $menuoptionprofile_id = $_POST['menuoptionprofile_id'];
  elseif (isset($_GET['menuoptionprofile_id']))
    $menuoptionprofile_id = $_GET['menuoptionprofile_id'];
  else
    $menuoptionprofile_id = '';  

  if (isset($_POST['chk_access']))
    $chk_access = $_POST['chk_access'];
  elseif (isset($_GET['chk_access']))
    $chk_access = $_GET['chk_access'];
  else
    $chk_access = check_all($profile_id, 'access', 1, 1);

  if (isset($_POST['chk_add_btn']))
    $chk_add_btn = $_POST['chk_add_btn'];
  elseif (isset($_GET['chk_add_btn']))
    $chk_add_btn = $_GET['chk_add_btn'];
  else
    $chk_add_btn = check_all($profile_id, 'add_btn', 1, 1);

  if (isset($_POST['chk_edit_btn']))
    $chk_edit_btn = $_POST['chk_edit_btn'];
  elseif (isset($_GET['chk_edit_btn']))
    $chk_edit_btn = $_GET['chk_edit_btn'];
  else
    $chk_edit_btn = check_all($profile_id, 'edit_btn', 1, 1);

  if (isset($_POST['chk_delete_btn']))
    $chk_delete_btn = $_POST['chk_delete_btn'];
  elseif (isset($_GET['chk_delete_btn']))
    $chk_delete_btn = $_GET['chk_delete_btn'];
  else
    $chk_delete_btn = check_all($profile_id, 'delete_btn', 1, 1);

  if (isset($_POST['chk_show_btn']))
    $chk_show_btn = $_POST['chk_show_btn'];
  elseif (isset($_GET['chk_show_btn']))
    $chk_show_btn = $_GET['chk_show_btn'];
  else
    $chk_show_btn = check_all($profile_id, 'show_btn', 1, 1);

  if (isset($_POST['col_check'])) 
    $col_check = $_POST['col_check'];
  elseif (isset($_GET['col_check']))
    $col_check = $_GET['col_check'];
  else
    $col_check = '';

  if (isset($_POST['btn'])) 
    $btn = $_POST['btn'];
  elseif (isset($_GET['btn']))
    $btn = $_GET['btn'];
  else
    $btn = '';

  if ($col_check == 'access') {
    if ($chk_access == 1) {
      $chk_access = update_all($profile_id, $col_check, 0);
      $chk_all_access = 0;   
    } else {
      $chk_access = update_all($profile_id, $col_check, 1);
      $chk_all_access = 'checked';
    }
  }
  if ($col_check == 'add_btn') {
    if ($chk_add_btn == 1) {
      $chk_add_btn = update_all($profile_id, $col_check, 0);
      $chk_all_add = '';   
    } else {
      $chk_access = update_all($profile_id, $col_check, 1);
      $chk_all_add = 'checked';
    }
  }
  if ($col_check == 'edit_btn') {
    if ($chk_edit_btn == 1) {
      $chk_edit_btn = update_all($profile_id, $col_check, 0);
      $chk_all_edit = '';   
    } else {
      $chk_edit_btn = update_all($profile_id, $col_check, 1);
      $chk_all_edit = 'checked';
    }
  }
  if ($col_check == 'delete_btn') {
    if ($chk_delete_btn == 1) {
      $chk_delete_btn = update_all($profile_id, $col_check, 0);
      $chk_all_delete = '';   
    } else {
      $chk_delete_btn = update_all($profile_id, $col_check, 1);
      $chk_all_delete = 'checked';
    }
  }
  if ($col_check == 'show_btn') {
    if ($chk_show_btn == 1) {
      $chk_show_btn = update_all($profile_id, $col_check, 0);
      $chk_all_show = '';   
    } else {
      $chk_show_btn = update_all($profile_id, $col_check, 1);
      $chk_all_show = 'checked';
    }
  }

  if ($menuoptionprofile_id == '') {

	  include('library/opendb.php');
    $sql_sel_section = "SELECT section, level ".
           "FROM ".$configValues['TBL_RSMENUOPTIONS']." ".
           "ORDER BY category, section, level";
		$ret_sel_section = pg_query($dbConnect, $sql_sel_section);
		if(!$ret_sel_section) {
      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
		}

    while ($row1 = pg_fetch_row($ret_sel_section)){

	    $section = $row1[0];
	    $level = $row1[1];

      $sql_sel_optprofile = "SELECT id, access, add_btn, edit_btn, delete_btn, show_btn ".
             "FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
             "WHERE profile_id = '$profile_id' AND section = '$section'";
			$ret_sel_optprofile = pg_query($dbConnect, $sql_sel_optprofile);
			if(!$ret_sel_optprofile) {
	      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
			}                          
      $chk_access = '0';
			
      if (pg_num_rows($ret_sel_optprofile) == 0) {
        if ((substr($section, -2) == '00')) 
          $chk_access = '1';
          $sql_ins_optprofile = "INSERT INTO ".$configValues['TBL_RSMENUOPTIONSPROFILES']." (profile_id, section, access, add_btn, edit_btn, delete_btn, show_btn, creationdate, creationby, updatedate, updateby) ".
                 "VALUES ('$profile_id', '$section', '$chk_access', 0, 0, 0, 0, '$currDate', '$operator_user', '$currDate', '$operator_user') ";
					$ret_ins_optprofile = pg_query($dbConnect, $sql_ins_optprofile);
					if(!$ret_ins_optprofile) {
			      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
					}
      }
    }      
  } else {    
  
    include('library/opendb.php');
    $sql_btn = "SELECT ".$btn." ".
           "FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
           "WHERE id = '$menuoptionprofile_id'";
		$ret_btn = pg_query($dbConnect, $sql_btn);
		if(!$ret_btn) {
      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
		}                          

    if (pg_num_rows($ret_btn) == 1) {
      $row = pg_fetch_row($ret_btn);
      $button = $row[0];

      if ($button == 0) 
        $button = 1;
      else 
        $button = 0;
      
      $sql_upd_optprofile = "UPDATE ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
             "SET ".$btn." = $button, updatedate = '$currDate', updateby='$operator_user' ".
             "WHERE id = '$menuoptionprofile_id'";
			$ret_upd_optprofile = pg_query($dbConnect, $sql_upd_optprofile);
			if(!$ret_upd_optprofile) {
	      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
			}
      
      switch($btn) {
        case "access":
          $chk_all_access = check_all($profile_id, $btn, 1, 0);
          break;
        case "add_btn":
          $chk_all_add = check_all($profile_id, $btn, 1, 0);
          break;
        case "edit_btn":
          $chk_all_edit = check_all($profile_id, $btn, 1, 0);
          break;
        case "delete_btn":
          $chk_all_delete = check_all($profile_id, $btn, 1, 0);
          break;
        case "show_btn":
          $chk_all_show = check_all($profile_id, $btn, 1, 0);
          break;
      }
    }
    $sql_upd_mop = "UPDATE ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
           "SET access = 1, updatedate = '$currDate', updateby='$operator_user' ".
           "WHERE profile_id = '$profile_id' AND section LIKE '%00'";
		$ret_upd_mop = pg_query($dbConnect, $sql_upd_mop);
		if(!$ret_upd_mop) {
      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
		}

    include('library/closedb.php');
  }
  
?>
  
<!DOCTYPE html>
<html lang="en">
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
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

	<body class="nav-md">
	  <div class="container body">
	    <div class="main_container">
	      <div class="col-md-3 left_col">
	        <div class="left_col scroll-view">

						<div class="navbar nav_title" style="border: 0;" align="center">
							<a href="index.php" class="site_title"><img src="images/logo_mini.png"></a>
					  </div>

					  <div class='clearfix'></div> 
							
				    <!-- menu profile quick info -->
	          <?php include('headersidebar.php');?>
				    <!-- /menu profile quick info -->
					
		        <!-- sidebar menu -->						
	          <?php include('sidebarmenu.php');?>
		        <!-- /sidebar menu -->

		      </div>
		    </div>

		    <!-- top navigation -->
		    <div class="top_nav">
		      <div class="nav_menu">
		        <nav> 
		          <div class="nav toggle">
		            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
		          </div>

		          <ul class="nav navbar-nav navbar-right">
		            <li class="">
		              <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		                <img src=<?php echo "images/".$client_id.".jpg";?> alt=""><?php echo $firstname.', '.$lastname;?>
		                <span class=" fa fa-angle-down"></span>
		              </a>
		              <ul class="dropdown-menu dropdown-usermenu pull-right">
		                <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i><?php echo $l_logout;?></a></li>
		              </ul>
		            </li>
		          </ul>
		        </nav>
		      </div>
		    </div>
		    <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
						<div class="alert alert-success alert-dismissible fade in" role="alert">
							<!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							</button> -->
              <span id="line_message"></span>
            </div>
						
            <div class="page-title">
              <div class="title_left">
                <h3>Permiso / Permission <small></small></h3>
              </div>

            </div>

            <div class='clearfix'></div>

            <div class='row'>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable_permissionsList" class="table table-striped table-bordered bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID</th>
                            <th class="column-title"><?php echo $l_menu_option;?> </th> 
                            <th class="column-title"><?php echo $l_section;?> </th> 
														<th><a href="<?php echo $pagepath.'?profile_id='.$profile_id.'&col_check=access';?>"><input type="checkbox" <?php echo $chk_all_access;?> name="chk_access" value="<?php echo $chk_access;?>">  <?php echo $l_access;?></th>
														<th><a href="<?php echo $pagepath.'?profile_id='.$profile_id.'&col_check=add_btn';?>"><input type="checkbox" <?php echo $chk_all_add;?> name="chk_add_btn" value="<?php echo $chk_add_btn;?>">  <?php echo $l_add_btn;?></th>
														<th><a href="<?php echo $pagepath.'?profile_id='.$profile_id.'&col_check=edit_btn';?>"><input type="checkbox" <?php echo $chk_all_edit;?> name="chk_edit_btn" value="<?php echo $chk_edit_btn;?>">  <?php echo $l_edit_btn;?></th>
														<th><a href="<?php echo $pagepath.'?profile_id='.$profile_id.'&col_check=delete_btn';?>"><input type="checkbox" <?php echo $chk_all_delete;?> name="chk_delete_btn" value="<?php echo $chk_delete_btn;?>">  <?php echo $l_delete_btn;?></th>
														<th><a href="<?php echo $pagepath.'?profile_id='.$profile_id.'&col_check=show_btn';?>"><input type="checkbox" <?php echo $chk_all_show;?> name="chk_show_btn" value="<?php echo $chk_show_btn;?>">  <?php echo $l_show_btn;?></th>
                          </tr>
												</thead>
                        <tbody>
                          <tr>
														<?php 

			                        include('library/opendb.php');
			                        $sql_sel_menu = "SELECT es, en, section, level ".
			                               "FROM ".$configValues['TBL_RSMENUOPTIONS']." ".
			                               "ORDER BY category, section, level";
															$ret_sel_menu = pg_query($dbConnect, $sql_sel_menu);
															if(!$ret_sel_menu) {
													      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
															}                          
		 
			                        while ($row1 = pg_fetch_row($ret_sel_menu)){

			                          $menu_option = TRIM($row1[0]);
			                          if ($_SESSION['lang'] == 'en') $menu_option = TRIM($row1[1]);
			                          $section = $row1[2];
			                          $level = $row1[3];
			                          if ($level == 1) $menu_option = "<ul>$menu_option</ul>";
			                          if ($level >= 2) $menu_option = "<ul><ul>$menu_option</ul></ul>";

			                          $sql_sel_moprofile = "SELECT id, access, add_btn, edit_btn, delete_btn, show_btn ".
			                                 "FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
			                                 "WHERE profile_id = '$profile_id' AND section = '$section'";
																$ret_sel_moprofile = pg_query($dbConnect, $sql_sel_moprofile);
																if(!$ret_sel_moprofile) {
														      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
																}
                          
			                          $chk_access = '0';
			                          $chk_add_btn = '0';
			                          $chk_edit_btn = '0';
			                          $chk_delete_btn = '0';
			                          $chk_show_btn = '0';
                          
			                          if (pg_num_rows($ret_sel_moprofile) == 1) {
			                            $row2 = pg_fetch_row($ret_sel_moprofile);
			                            $access = btn_check($row2[1]);
			                            $add_btn = btn_check($row2[2]);
			                            $edit_btn = btn_check($row2[3]);
			                            $delete_btn = btn_check($row2[4]);
			                            $show_btn = btn_check($row2[5]);
			                          }

			                          echo  "<td class=' '>$row2[0] </td>
			                                 <td class=' '>$menu_option </td>
			                                 <td class=' '>$section </td>"; 
			                          if ((substr($section, -2) != '00')) {
			                            echo "<td class='a-center '>
			                                    <a href='$pagepath?profile_id=$profile_id&menuoptionprofile_id=$row2[0]&btn=access'><input type='checkbox' $access name='access' >
			                                  </td>
			                                  <td class='a-center '>
			                                    <a href='$pagepath?profile_id=$profile_id&menuoptionprofile_id=$row2[0]&btn=add_btn'><input type='checkbox' $add_btn name='add_btn' >
			                                  </td>
			                                  <td class='a-center '>
			                                    <a href='$pagepath?profile_id=$profile_id&menuoptionprofile_id=$row2[0]&btn=edit_btn'><input type='checkbox' $edit_btn name='edit_btn' >
			                                  </td>
			                                  <td class='a-center '>
			                                    <a href='$pagepath?profile_id=$profile_id&menuoptionprofile_id=$row2[0]&btn=delete_btn'><input type='checkbox' $delete_btn name='delete_btn' >
			                                  </td>
			                                  <td class='a-center '>
			                                    <a href='$pagepath?profile_id=$profile_id&menuoptionprofile_id=$row2[0]&btn=show_btn'><input type='checkbox' $show_btn name='show_btn' >
			                                  </td>";
			                          }
			                          echo "</tr>";

			                        }  
			                        include('library/closedb.php');
														?>

		                    </tbody>												
                      </table>
                    </div>
                  </div>
                </div>
							</div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <?php echo $l_footer2;?>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
		
  </body>
</html>
