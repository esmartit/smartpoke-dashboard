<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_profiles_gc';
  $page_2 = '$sb_permission_gc';

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

  include('library/pages_common.php');
  $add_access = opt_buttons($page, $operator_profile_id, 'add_btn');
  $edit_access = opt_buttons($page, $operator_profile_id, 'edit_btn');
  $delete_access = opt_buttons($page, $operator_profile_id, 'delete_btn');
  $show_access = opt_buttons($page_2, $operator_profile_id, 'show_btn'); //Enable o disable permission bth

  $permission = get_file($page_2, $operator_profile_id);
  
  $btn_accesss = 0;
  if (($add_access == 1) || ($edit_access == 1)) {
    $btn_accesss = 1;
  }
  
  $icon_edit = '';
  $icon_delete = '';
  
  if ($edit_access == 'enabled') $icon_edit = 'fa fa-edit';
  if ($delete_access == 'enabled') $icon_delete = 'fa fa-trash';

  $profile_id = '';
	$profile = '';
  $profile_name = '';

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
                <h3>Perfile / Profile</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_profile;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="profile_form" enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">

											<!-- form Profile -->
				              <div class="col-md-6 col-sm-6 col-xs-12">
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_profile;?> <span class="required">*</span></label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="id" type="hidden" name="id" class="form-control" value="">
	                          <input id="profile" type="text" name="profile" <?php echo $btn_accesss;?> class="form-control" value='<?php echo $profile;?>' required="required">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_name;?> <span class="required">*</span></label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="profile_name" type="text" name="profile_name" <?php echo $btn_accesss;?> class="form-control" value='<?php echo $profile_name;?>' required="required">
	                        </div>
	                      </div>											
											</div>
											<!-- /form Profile -->

                      <div class="form-group">
                      </div>
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button id="btnCancel" type="submit" name="btnCancel" class="btn btn-primary" onclick="resetForm()"><?php echo $l_cancel;?></button>
                          <input id="btnPermission" type="button" name="btnPermission" class="btn btn-info" <?php echo $show_access;?> value='<?php echo $l_permission;?>'></input>
                          <input id="btnSubmit" type="button" name="btnSubmit" class="btn btn-success" <?php echo $show_access;?> value='<?php echo $l_save;?>' ></input>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_profiles;?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable_profilesList" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID</th>
                            <th class="column-title"><?php echo $l_profile;?> </th> 
                            <th class="column-title"><?php echo $l_profile_name;?> </th> 
                            <th class="column-title no-link last"><span class="nobr"><?php echo $l_action;?></span> </th>
													</tr>
												</thead>
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
		
		<script>
			$( window ).load(function() {								
				var id = $("#id").val();
				showProfilesList(id);
				document.getElementById("btnPermission").disabled = true;
			});
							
    </script>

    <!-- showProfilesList -->
    <script>
		  function showProfilesList(id) {
	  
				$.ajax({
					url: 'rest-api/general/getProfilesList.php',
					type: 'GET',
					data: {profile_id:id},
					dataType: 'json',
					success:function(response) {

						result = response;
						if (id == '') {
							showProfileTable(result);							
						} else {
							showProfile(result);														
						}
					}
				});
		  }	
		</script>
    <!-- /showProfilesList -->

		<!-- showProfileTable -->
		<script>
			function showProfileTable(data) {
				$('#datatable_profilesList').DataTable({
					destroy: true,
					data: data,
					columns: [
	          { data: "id" },
	          { data: "profile" },
	          { data: "profile_name" },
						{ 
								data: null, render: function ( data, type, row ) {
	                // Combine the first and last names into a single table field
									return '<button id="btn" class="btn btn-success btn-xs" onclick="editProfile('+data.id+')"><i class="fa fa-edit"></i></button> <button id="btn" class="btn btn-primary btn-xs" onclick="deleteProfile('+data.id+')"><i class="fa fa-trash"></i></button>';
		            } 
							}
		      ],
          responsive: true						
				});
			}
		</script>
		<!-- /showProfileTable -->		

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
				showProfilesList('');						
				$('#datatable_profilesList').DataTable();

		    $('#btnSubmit').click(function() {

					var id = $("#id").val();
					var profile = $("#profile").val();
					var  name = $("#profile_name").val();
					var type = 'I';
					if (id != '') type = 'U';

					$.ajax({
					  url: 'rest-api/general/crudProfile.php',
					  type: 'POST',
						data: {profile_id:id, profile:profile, profile_name:name, action:type},
					  dataType: 'json',
					  success:function(response) {
					    console.log(response);
							
							document.getElementById('line_message').innerHTML = response.message;	
							showProfilesList('');						
						}
					});
				});
 
		    $('#btnPermission').click(function() {
					var id = $("#id").val();
					window.location="<?php echo $permission;?>"+"?profile_id="+id;
				}); 
      });
    </script>
    <!-- /Datatables -->
		
   <!-- Edit Profile -->
	 <script>
		function editProfile(id) {
			var table = document.getElementById("datatable_profilesList");
			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {
						showProfilesList(id);						
			    };
			  }
			}
		};

	 </script>
   <!-- /Edit Profile -->	
	 
   <!-- Show Profile -->
	 <script>
		function showProfile(data) {
			document.getElementById("id").value = data[0].id;
			document.getElementById("profile").value = data[0].profile;
			document.getElementById("profile_name").value = data[0].profile_name;
			document.getElementById("btnPermission").disabled = false;
		};

	 </script>
   <!-- /Show Profile -->	

   <!-- Delete Profile -->
	 <script>
		function deleteProfile(id) {				
			var table = document.getElementById("datatable_profilesList");

			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {

						showProfilesList(id);						
						var type = 'D';

						if (confirm('<?php echo $l_message_delete;?>'+'<?php echo $l_profile;?>')) {
							var profile = $("#profile").val();
							var name = $("#profile_name").val();
							
							$.ajax({
							  url: 'rest-api/general/crudProfile.php',
							  type: 'POST',
								data: {profile_id:id, profile:profile, profile_name:name, action:type},
							  dataType: 'json',
							  success:function(response) {
							    console.log(response);
							
									document.getElementById('line_message').innerHTML = response.message;	
								}
							});
							showProfilesList('');						
						}
						document.getElementById("btnPermission").disabled = false;
			    };
			  }
			}
		};
	 </script>
   <!-- /Delete Profile -->			

   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			

  </body>
</html>


