<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_users_hs';

  $operator_id = $_SESSION['operator_id'];
  $operator_user = $_SESSION['operator_user'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $client_id = $_SESSION['client_id'];
    $c_name = $_SESSION['c_name'];
  $lang = $_SESSION['lang'];
  $currDate = date('Y-m-d H:i:s');

  $session_id = $_SESSION['id'];
  include('lang/main.php');

  include('library/pages_common.php');
  $add_access = opt_buttons($page, $operator_profile_id, 'add_btn');
  $edit_access = opt_buttons($page, $operator_profile_id, 'edit_btn');
  $delete_access = opt_buttons($page, $operator_profile_id, 'delete_btn');
  
  $btn_accesss = 0;
  if (($add_access == 1) || ($edit_access == 1)) {
    $btn_accesss = 1;
  }
  
  $icon_edit = '';
  $icon_delete = '';
  
  if ($edit_access == 'enabled') $icon_edit = 'fa fa-edit';
  if ($delete_access == 'enabled') $icon_delete = 'fa fa-trash';

  $id_client = $client_id;
  $country_id = '35';
  $state_id = '%';    
  $city_id = '%';
	$location_id = '%';
	$hotspot = '%';  	
	$user_name = '';
  $user_firstname = '';
  $user_lastname = '';
  $user_email = '';
  $user_mobilephone = '';
	$user_birthdate = date("Y-m-d", strtotime($currDate));
	$user_gender = '';
	$zip_code = '';
	$flag_sms = '0';
	
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
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

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
                <h3>Usuario / Users</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_user;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="user_form" enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">

											<!-- form User -->
				              <div class="col-md-6 col-sm-6 col-xs-12">
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client;?> </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selClient" disabled class="form-control" name="id_client">
								            </select>
		                      </div>
		                    </div>
											  <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_hotspot ?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
													  <select id="selHotSpot" class="form-control" name="hotspot_id" required="required" onChange="showUsersList('')">
															<option value="%"><?php echo $l_select_hotspot ?></option>
													
													  </select>
													</div>
											  </div>				  											  
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_user_name;?></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="user_id" type="hidden" class="form-control" name="user_id">
	                          <input id="user_name" type="text" class="form-control" <?php echo $show_access;?> name="user_name">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_user_firstname;?></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="user_firstname" type="text" class="form-control" <?php echo $add_access;?> name="user_firstname" value="">
	                        </div>
	                      </div> 
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_user_lastname;?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="user_lastname" type="text" class="form-control" <?php echo $add_access;?> name="user_lastname" value="" required="required">
	                        </div>
	                      </div> 
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_user_email;?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="user_email" type="text" class="form-control" <?php echo $add_access;?> name="user_email" value="" required="required">
	                        </div>
	                      </div> 
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_user_mobilephone;?></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="user_mobilephone" type="text" class="form-control" <?php echo $add_access;?> name="user_mobilephone" value="">
	                        </div>
	                      </div> 
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_user_birthdate;?></label>
	                        <div class="col-md-4 col-sm-4 col-xs-12">
	                          <div class="input-group date">
	                            <input id="user_birthdate" type="text" class="form-control" <?php echo $add_access;?> name="user_birthdate" value='<?php echo $user_birthdate;?>'>
	                            <span class="input-group-addon">
	                              <span class="glyphicon glyphicon-calendar"></span>
	                            </span>
	                          </div>
	                        </div>   
	                      </div> 
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_user_gender;?></label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selGender" class="btn btn-default" <?php echo $add_access;?> name="status">
		                          <option value="M" selected="true"><?php echo $l_woman;?></option>
		                          <option value="H"><?php echo $l_man;?></option>
		                          <option value="X">No</option>
		                        </select>
	                        </div>
	                      </div>
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12' ><?php echo $l_zip_code;?></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id='zip_code' type='text' name='zip_code' <?php echo $add_access;?> class='form-control' value='<?php echo $zip_code;?>'>
	                        </div>
	                      </div> 
	                      <div class="form-group">
	                        <label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $l_flag_sms;?></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <div class="checkbox">
	                            <label>
	                              <input id="flag_sms" type="checkbox" class="iCheck">
	                            </label>
	                          </div>
													</div>
												</div>
											</div>	
											<!-- /form User -->

                      <div class="form-group">
                      </div>
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button id="btnCancel" type="submit" name="button" class="btn btn-primary" value="cancel" onclick="resetForm()"><?php echo $l_cancel;?></button>
                          <button id="btnSubmit" type="submit" name="button" class="btn btn-success" <?php echo $add_access;?> value="submit" ><?php echo $l_save;?></button>
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
                    <h2><?php echo $l_users;?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable_usersList" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID</th> 
                            <th class='column-title'><?php echo $l_spot;?> </th> 
                            <th class='column-title'><?php echo $l_user_firstname;?> </th> 
                            <th class='column-title'><?php echo $l_user_lastname;?> </th>
                            <th class='column-title'><?php echo $l_user_name;?> </th>
                            <th class='column-title'><?php echo $l_user_email;?> </th>
                            <th class='column-title'><?php echo $l_user_mobilephone;?> </th>
                            <th class='column-title'><?php echo $l_user_birthdate;?> </th>
                            <th class='column-title'><?php echo $l_user_gender;?> </th>
                            <th class='column-title'><?php echo $l_zip_code;?> </th>
                            <th class='column-title'><?php echo $l_flag_sms;?> </th>
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
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
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
                showClient();
                showHotSpot();
				document.getElementById("btnSubmit").disabled = true;
			});
							
    </script>

    <script>
		  function showClient() {

			$("#selClient").empty();
			$("#selClient").append("<option value='<?php echo $id_client;?>'><?php echo $c_name;?></option>");
		  }
    </script>


		<!-- showHotSpot -->
		<script>
			function showHotSpot() {

				var schemaid = $("#selClient").val();
				var countryid = 35;
				var stateid = '%';
				var cityid = '%';
				var locationid = '%';

				$.ajax({
					url: 'rest-api/hotspot/getHotSpot.php',
					type: 'POST',
					data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid},
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selHotSpot").empty();
						$("#selHotSpot").append("<option value='%' selected='true' disabled='disabled'><?php echo $l_select_hotspot;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selHotSpot").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showUsersList('');
			}	
		</script>
		<!-- /showHoSpot -->
		
    <!-- Initialize datetimepicker -->
    <script>
      $('#user_birthdate').datetimepicker({
        format: 'YYYY-MM-DD'
      });    
    </script>
    <!-- /Initialize datetimepicker -->

    <!-- showUsersList -->
    <script>
		  function showUsersList(id) {
	  
				var schemaid = $("#selClient").val();
				var spotid = $('#selHotSpot').val();

				$.ajax({
					url: 'rest-api/hotspot/getUsersList.php',
					type: 'GET',
					data: {schema:schemaid, idspot:spotid, user_id:id},
					dataType: 'json',
					success:function(response) {

						result = response;
						if (id == '') {
							showUserTable(result);							
						} else {
							showUser(result);														
						}
					}
				});
		  }	
		</script>
    <!-- /showUsersList -->

		<!-- showUserTable -->
		<script>
			function showUserTable(data) {
				$('#datatable_usersList').DataTable({
					destroy: true,
					data: data,
					columns: [
	          { data: "id" },
	          { data: "spot_name" },
	          { data: "firstname" },
	          { data: "lastname" },
	          { data: "username" },
	          { data: "email" },
	          { data: "mobilephone" },
	          { data: "birthdate" },
	          { data: "gender" },
	          { data: "zip" },
			      {
			        data: "flag_sms",
			        render: function(data, type, row) {
			          if (data === '1') {
			            return '<i class="fa fa-check">';
			          } else {
			            return '<i class="fa fa-close">';
			          }
			          return data;
			        },
			        className: "dt-body-center text-center"
			      },
						{ 
								data: null, render: function ( data, type, row ) {
	                // Combine the first and last names into a single table field
									return '<button id="btn" class="btn btn-success btn-xs" onclick="editUser('+data.id+')"><i class="fa fa-edit"></i></button>';
		            } 
							}
		      ],
          responsive: true						
				});
			}
		</script>
		<!-- /showUserTable -->		

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
//				showUsersList('');
				$('#datatable_usersList').DataTable();

		    $('#user_form').submit(function(e) {
	        e.preventDefault();

					var schemaid = $("#selClient").val();
					var spotid = $("#selHotSpot").val();
					var id = $("#user_id").val();
					var user = $("#user_name").val();
					var firstname = $("#user_firstname").val();
					var lastname = $("#user_lastname").val();
					var email = $("#user_email").val();
					var mobile = $("#user_mobilephone").val();
					var birthdate = $("#user_birthdate").val();
					var gender = $("#selGender").val();
					var zipcode = $("#zip_code").val();
					var flag = document.getElementById("flag_sms").checked;
					var type = 'I';
					if (id != '') type = 'U';
					
					var flagsms = 0;
					if (flag) flagsms = 1;
					
					$.ajax({
					  url: 'rest-api/hotspot/crudUser.php',
					  type: 'POST',
						data: {schema:schemaid, idspot:spotid, user_name:user, user_lastname:lastname, user_email:email, user_birthdate:birthdate, gender:gender, zip_code:zipcode, flag_sms:flagsms, action:type},
					  dataType: 'json',
					  success:function(response) {
					    console.log(response);
							
							document.getElementById('line_message').innerHTML = response.message;	
							showUsersList('');						
						}
					});
				}); 
      });
    </script>
    <!-- /Datatables -->
		
   <!-- Edit User -->
	 <script>
		function editUser(id) {
			var table = document.getElementById("datatable_usersList");
			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {
						showUsersList(id);						
			    };
			  }
			}
			document.getElementById("selClient").disabled = true;
			document.getElementById("selHotSpot").disabled = true;
			document.getElementById("user_name").disabled = true;
			document.getElementById("user_firstname").disabled = true;
			document.getElementById("user_mobilephone").disabled = true;
			document.getElementById("btnSubmit").disabled = false;
		};

	 </script>
   <!-- /Edit Option -->	

   <!-- Show Option -->
	 <script>
		function showUser(data) {
			var flag = data[0].flag_sms;
			document.getElementById("user_id").value = data[0].id;
			document.getElementById("user_name").value = data[0].username;
			document.getElementById("user_firstname").value = data[0].firstname;
			document.getElementById("user_lastname").value = data[0].lastname;
			document.getElementById("user_email").value = data[0].email;
			document.getElementById("user_mobilephone").value = data[0].mobilephone;
			document.getElementById("user_birthdate").value = data[0].birthdate;
			document.getElementById("selGender").value = data[0].gender;
			document.getElementById("zip_code").value = data[0].zip;
			document.getElementById("flag_sms").checked = false;				
			if (flag == '1') {
				document.getElementById("flag_sms").checked = true;				
			}
		};

	 </script>
   <!-- /Show Option -->	

   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			

  </body>
</html>