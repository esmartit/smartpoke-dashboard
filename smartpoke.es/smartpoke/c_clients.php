<?php

	// ini_set('display_errors','On');
	// error_reporting(E_ALL);

	$loginpath = $_SERVER['PHP_SELF'];
	include ('library/checklogin.php');
	$page = '$sb_clients';

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

	$btn_accesss = 0;
	if (($add_access == 1) || ($edit_access == 1)) {
	  $btn_accesss = 1;
	}

	$icon_edit = '';
	$icon_delete = '';

	if ($edit_access == 'enabled') $icon_edit = 'fa fa-edit';
	if ($delete_access == 'enabled') $icon_delete = 'fa fa-trash';

	$id_client = '';
	$client_esquema = '';
	$client_status = 'ACT';
	$client_name = '';
	$client_address = '';
	$client_company = '';
	$client_phone1 = '';
	$client_phone2 = '';

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
                <h3>Clientes / Clients</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_client;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="client_form" enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">

											<!-- form Client -->
				              <div class="col-md-6 col-sm-6 col-xs-12">
	                      <div class="form-group">
	                        <!--<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client_id;?> <span class="required">*</span></label>-->
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="id" type="hidden" name="id" class="form-control" value="">
	                          <input id="id_client" type="hidden" name="id_client" <?php echo $add_access;?> class="form-control" value='<?php echo $id_client;?>' required="required">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client_name;?> <span class="required">*</span></label>
	                        <div class="col-md-9 col-sm-9 col-xs-12">
	                          <input id="client_name" type="text" name="client_name" class="form-control" required="required">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client_company;?></label>
	                        <div class="col-md-9 col-sm-9 col-xs-12">
	                          <input id="client_company" type="text" name="client_company" class="form-control">
													</div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client_address;?></label>
	                        <div class="col-md-9 col-sm-9 col-xs-12">
	                          <input id="client_address" type="text" name="client_address" class="form-control">
													</div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client_phone1;?></label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="client_phone1" type="text" name="client_phone1" class="form-control">
													</div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client_phone2;?></label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="client_phone2" type="text" name="client_phone2" class="form-control">
													</div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client_esquema;?> <span class="required">*</span></label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="client_esquema" type="text" disabled name="client_esquema" <?php echo $add_access;?> class="form-control" required="required">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client_status;?></label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                          <select id="selStatus" class="btn btn-default" <?php echo $add_access;?> name="client_status">
	                            <option value="ACT" selected="true">ACT</option>
	                            <option value="NO ACT">NO ACT</option>
	                          </select>
	                        </div>
	                      </div>
											</div>
											<!-- /form Client -->

                      <div class="form-group">
                      </div>
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button id="btnCancel" type="submit" name="button" class="btn btn-primary" value="cancel" onclick="resetForm()"><?php echo $l_cancel;?></button>
                          <button id="btnSubmit" type="submit" name="button" class="btn btn-success" <?php echo $show_access;?> value="submit" ><?php echo $l_save;?></button>
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
                    <h2><?php echo $l_clients;?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable_clientsList" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class='column-title'>ID</th>
                            <!--<th class='column-title'><?php echo $l_client_id;?> </th>-->
                            <th class='column-title'><?php echo $l_client_name;?> </th>
                            <th class='column-title'><?php echo $l_client_company;?> </th>
                            <th class='column-title'><?php echo $l_client_address;?> </th>
                            <th class='column-title'><?php echo $l_client_phone1;?> </th>
                            <th class='column-title'><?php echo $l_client_phone2;?> </th>
                            <th class='column-title'><?php echo $l_client_esquema;?> </th>
                            <th class='column-title'><?php echo $l_client_status;?> </th>
                            <th class="column-title no-link last"><span class="nobr"><?php echo $l_action;?></span> </th>
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
		
    <!-- showClientsList -->
    <script>
		  function showClientsList(clientid) {
	  
				if (clientid == '') {					
					document.getElementById("id_client").value = '<?php echo $id_client;?>';
					document.getElementById("client_name").value = '<?php echo $client_name;?>';
					document.getElementById("client_company").value = '<?php echo $client_company;?>';
					document.getElementById("client_address").value = '<?php echo $client_address;?>';
					document.getElementById("client_phone1").value = '<?php echo $client_phone1;?>';
					document.getElementById("client_phone2").value = '<?php echo $client_phone2;?>';
					document.getElementById("client_esquema").value = '<?php echo $client_esquema;?>';
					document.getElementById("selStatus").value = '<?php echo $client_status;?>';
				}
				
				$.ajax({
					url: 'rest-api/settings/getClientsList.php',
					type: 'GET',
					data: {client:clientid},
					dataType: 'json',
					success:function(response) {

						result = response;
						showClientTable(result);							
						if (clientid != '') {
							showClient(result);														
						}
					}
				});
		  }	
		</script>
    <!-- /showClientsList -->

		<!-- showClientTable -->
		<script>
			function showClientTable(data) {
				$('#datatable_clientsList').DataTable({
					destroy: true,
					data: data,
					columns: [
		          { data: "id" },
		          <!--{ data: "client" },-->
		          { data: "name" },
		          { data: "company" },
		          { data: "address" },
		          { data: "phone1" },
		          { data: "phone2" },
		          { data: "esquema" },
		          { data: "status" },
	            { 
								data: null, render: function ( data, type, row ) {
	                // Combine the first and last names into a single table field
									return '<button id="btn" class="btn btn-success btn-xs" onclick="editClient('+data.id+')"><i class="fa fa-edit"></i></button>';
		            } 
							}
		      ],
          responsive: true						
				});
			}
		</script>
		<!-- /showClientTable -->		

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
				var operatorid = <?php echo $operator_profile_id;?>;
				var cli = '<?php echo $client_id;?>';
				if (operatorid == 1) showClientsList('');
				else showClientsList(cli);
				$('#datatable_clientsList').DataTable();

		    $('#client_form').submit(function(e) {
	        e.preventDefault();

					var id = $("#id").val();
					var client = $("#id_client").val();
					var name = $("#client_name").val();
					var company = $("#client_company").val();
					var address = $("#client_address").val();
					var phone1 = $("#client_phone1").val();
					var phone2 = $("#client_phone2").val();
					var esquema = $("#client_esquema").val();
					var status = $("#selStatus").val();
					var type = 'I';
					if (id != '') type = 'U';

					$.ajax({
					  url: 'rest-api/settings/crudClient.php',
					  type: 'POST',
						data: {client:client, client_name:name, client_company:company, client_address:address, client_phone1:phone1, client_phone2:phone2, client_esquema:esquema, client_status:status, action:type},
					  dataType: 'json',
					  success:function(response) {
					    console.log(response);
							
							document.getElementById('line_message').innerHTML = response.message+' '+client+' '+name;	
							if (operatorid == 1) showClientsList('');
							else showClientsList(cli);
						}
					});
				});
      });
    </script>
    <!-- /Datatables -->
		
   <!-- Edit Client -->
	 <script>
		function editClient(clientid) {
			var table = document.getElementById("datatable_clientsList");
			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {
						showClientsList(clientid);						
			    };
			  }
			}
		};

	 </script>
   <!-- /Edit Client -->	
	 
   <!-- Show Client -->
	 <script>
		function showClient(data) {
			document.getElementById("id").value = data[0].id;
			document.getElementById("id_client").value = data[0].client;
			document.getElementById("client_name").value = data[0].name;
			document.getElementById("client_company").value = data[0].company;
			document.getElementById("client_address").value = data[0].address;
			document.getElementById("client_phone1").value = data[0].phone1;
			document.getElementById("client_phone2").value = data[0].phone2;
			document.getElementById("client_esquema").value = data[0].esquema;
			document.getElementById("selStatus").value = data[0].status;
		};

	 </script>
   <!-- /Show Client -->	

   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			

  </body>
</html>