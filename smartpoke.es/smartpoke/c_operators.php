<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_operators';
  $page_2 = '$sb_access';

  $operator_id = $_SESSION['operator_id'];
  $operator_user = $_SESSION['operator_user'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $client_id = $_SESSION['client_id'];
  $c_name = $_SESSION['c_name'];
  $lang = $_SESSION['lang'];
  $currDate = date('Y-m-d H:i:s');
  
  $profileid = 'WHERE id > 1';
  if ($operator_profile_id == 1) 
    $profileid = '';
  
  $session_id = $_SESSION['id'];
  include('lang/main.php');

  include('library/pages_common.php');
  $add_access = opt_buttons($page, $operator_profile_id, 'add_btn');
  $edit_access = opt_buttons($page, $operator_profile_id, 'edit_btn');
  $delete_access = opt_buttons($page, $operator_profile_id, 'delete_btn');
  $show_access = opt_buttons($page_2, $operator_profile_id, 'show_btn'); //Enable o disable permission bth

  $opt_access = get_file($page_2, $operator_profile_id);
  
  $btn_accesss = 0;
  if (($add_access == 1) || ($edit_access == 1)) {
    $btn_accesss = 1;
  }
  
  $icon_edit = '';
  $icon_delete = '';
  
  if ($edit_access == 'enabled') $icon_edit = 'fa fa-edit';
  if ($delete_access == 'enabled') $icon_delete = 'fa fa-trash';

	$id_client = $client_id;
  $username = '';
  $password = '';
  $confirmpassword = '';
  $opefirstname = '';
  $opelastname = '';
  $profile_id = '';
	
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
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
                <h3>Operadores / Operators</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_operator;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="operator_form" enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">

				              <!-- form Spot -->
				              <div class="col-md-6 col-sm-6 col-xs-12">
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client;?> </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selClient" disabled class="form-control" name="id_client">
								            </select>
		                      </div>
		                    </div>
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_username;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id="operator_id" type="hidden" name="operator_id" class="form-control" value="">
	                          <input id='username' type='text' name='username' class='form-control' required="required">
	                        </div>
	                      </div> 
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_password;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id='password' type='password' name='password' class='form-control' required="required">
	                        </div>
	                      </div> 
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_confirmpassword;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id='checkpassword' type='password' name='checkpassword' class='form-control' required="required">
	                        </div>
	                      </div> 
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_firstname;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id='firstname' type='text' name='firstname' class='form-control' required="required">
	                        </div>
	                      </div> 
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_lastname;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id='lastname' type='text' name='lastname' class='form-control' required="required">
	                        </div>
	                      </div> 
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_profile;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <select id='selProfile' class='form-control' name='profile_id'>
	                            <option value='%' selected="true" disabled="disabled"><?php echo $l_select_profile;?></option></select>
	                        </div>
	                      </div>												

											</div>
											<!-- /form Spot -->

                      <div class="form-group">
                      </div>
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button id="btnCancel" type="submit" name="btnCancel" class="btn btn-primary" onclick="resetForm()"><?php echo $l_cancel;?></button>
                          <input id="btnAccess" type="button" name="btnAccess" class="btn btn-info" <?php echo $show_access;?> value='<?php echo $l_access;?>'></input>
                          <input id="btnSubmit" type="button" name="btnSubmit" class="btn btn-success" <?php echo $add_access;?> value='<?php echo $l_save;?>' ></input>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
						</div>
            <div class="clearfix"></div>

            <div class="row">  
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_operators;?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable_operatorsList" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID </th> 
                            <th class="column-title"><?php echo $l_username;?></th> 
                            <th class="column-title"><?php echo $l_password;?></th> 
                            <th class='column-title'><?php echo $l_firstname;?></th> 
                            <th class='column-title'><?php echo $l_lastname;?></th>
                            <th class="column-title"><?php echo $l_profile;?></th> 
                            <!--<th class="column-title"><?php echo $l_client;?></th>-->
                            <th class="column-title no-link last"><span class="nobr"><?php echo $l_action;?></span>
                            </th>
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
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
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
				showProfile();
                showOperatorsList('');
			});							
    </script>

    <script>
		  function showClient() {

			$("#selClient").empty();
			$("#selClient").append("<option value='<?php echo $id_client;?>'><?php echo $c_name;?></option>");
		  }
    </script>

    <!-- showProfile -->
		<script>	
		  function showProfile() {
	  
					$.ajax({
					url: 'rest-api/general/getProfile.php',
					type: 'POST',
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selProfile").empty();
						$("#selProfile").append("<option value='%' selected='true' disabled='disabled'><?php echo $l_select_profile;?></option>");
						for (var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selProfile").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
		  }			
    </script>
    <!-- /showProfile -->
			
    <!-- showOperatorsList -->
    <script>
		  function showOperatorsList(opeid) {
				var schemaid = $("#selClient").val();
	  
				if (opeid == '') {
					document.getElementById("username").value = '<?php echo $username;?>';
					document.getElementById("username").value = '<?php echo $username;?>';
					document.getElementById("password").value = '<?php echo $password;?>';
					document.getElementById("checkpassword").value = '<?php echo $confirmpassword;?>';
					document.getElementById("firstname").value = '<?php echo $opefirstname;?>';
					document.getElementById("lastname").value = '<?php echo $opelastname;?>';
					document.getElementById("selProfile").value = '<?php echo $profile_id;?>';
				}
				
				$.ajax({
					url: 'rest-api/settings/getOperatorsList.php',
					type: 'GET',
					data: {schema:schemaid, ope_id:opeid},
					dataType: 'json',
					success:function(response) {

						result = response;
						if (opeid == '') {
							showOperatorTable(result);							
						} else {
							showOperator(result);														
						}
					}
				});
		  }	
		</script>
    <!-- /showOperatorsList -->

		<!-- showOperatorTable -->
		<script>
			function showOperatorTable(data) {
				$('#datatable_operatorsList').DataTable({
					destroy: true,
					data: data,
					columns: [
		          { data: "id" },
		          { data: "username" },
							{
				        data: "password",
				        render: function(data, type, row) {									
									return '<input type="password" disabled class="form-control" value='+data+' size="5"></input>';
				        },
				        className: "dt-body-center text-center"
				      },
		          { data: "firstname" },
		          { data: "lastname" },
		          { data: "profile_name" },
		          <!--{ data: "client" },-->
						{ 
								data: null, render: function ( data, type, row ) {
	                // Combine the first and last names into a single table field
									return '<button id="btn" class="btn btn-success btn-xs" onclick="editOperator('+data.id+')"><i class="fa fa-edit"></i></button> <button id="btn" class="btn btn-primary btn-xs" onclick="deleteOperator('+data.id+')"><i class="fa fa-trash"></i></button>';
		            } 
							}
		      ],
          responsive: true						
				});
			}
		</script>
		<!-- /showOperatorTable -->		

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
				$('#datatable_operatorsList').DataTable();

		    $('#btnSubmit').click(function() {

					var id = $("#operator_id").val();
					var schemaid = $("#selClient").val();
					var opename = $("#username").val();
					var pswd = $("#password").val();
					var cpswd = $("#checkpassword").val();
					var firstname = $("#firstname").val();
					var lastname = $("#lastname").val();
					var profile = $("#selProfile").val();
					var type = 'I';
					if (id != '') type = 'U';

					$.ajax({
					  url: 'rest-api/settings/crudOperator.php',
					  type: 'POST',
						data: {schema:schemaid, ope_id:id, username:opename, password:pswd, confirmpassword:cpswd, firstname:firstname, lastname:lastname, profile_id:profile, action:type},
					  dataType: 'json',
					  success:function(response) {
					    console.log(response);
							
							document.getElementById('line_message').innerHTML = response.message+' '+opename+' '+firstname;	
							showOperatorsList('');						
						}
					});
				});
				
		    $('#btnAccess').click(function() {
					var id = $("#operator_id").val();
					var schemaid = $("#selClient").val();
					window.location="<?php echo $opt_access;?>"+"?schema="+schemaid+"&ope_id="+id;
				}); 
				
      });
    </script>
    <!-- /Datatables -->
		
   <!-- Edit Operator -->
	 <script>
		function editOperator(id) {
			var table = document.getElementById("datatable_operatorsList");
			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {
						showOperatorsList(id);						
			    };
			  }
			}
			document.getElementById("selClient").disabled = true;
			document.getElementById("username").disabled = true;
			document.getElementById("selProfile").disabled = true;
		};

	 </script>
   <!-- /Edit Operator -->	

   <!-- Show Operator -->
	 <script>
		function showOperator(data) {
			document.getElementById("operator_id").value = data[0].id;
			document.getElementById("username").value = data[0].username;
			document.getElementById("password").value = data[0].password;
			document.getElementById("checkpassword").value = data[0].password;
			document.getElementById("firstname").value = data[0].firstname;
			document.getElementById("lastname").value = data[0].lastname;
			document.getElementById("selProfile").value = data[0].profile_id;
		};

	 </script>
   <!-- /Show Operator -->	

   <!-- Delete Operator -->
	 <script>
		function deleteOperator(id) {				
			var table = document.getElementById("datatable_operatorsList");

			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {

						showOperatorsList(id);						
						var type = 'D';

						if (confirm('<?php echo $l_message_delete;?>'+'<?php echo $l_operator;?>')) {
							var id = $("#operator_id").val();
							var schemaid = $("#selClient").val();
							var opename = $("#username").val();
							var pswd = $("#password").val();
							var cpswd = $("#checkpassword").val();
							var firstname = $("#firstname").val();
							var lastname = $("#lastname").val();
							var profile = $("#selProfile").val();
							
							$.ajax({
							  url: 'rest-api/settings/crudOperator.php',
							  type: 'POST',
								data: {schema:schemaid, ope_id:id, action:type},
							  dataType: 'json',
							  success:function(response) {
							    console.log(response);
							
									document.getElementById('line_message').innerHTML = response.message;	
								}
							});
							showOperatorsList('');						
						}
			    };
			  }
			}
		};
	 </script>
   <!-- /Delete Operator -->	

   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			


  </body>
</html>