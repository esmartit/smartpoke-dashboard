<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_gateways_hs';

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

  $id_client = $client_id;
  $country_id = '35';
  $state_id = '%';    
  $city_id = '%';
	$location_id = '%';
	$hotspot = '%';  	
	$nas_ip_host = '';
  $nas_secret = '';
  $nas_type = '';
  $nas_shortname = '';
	
  $enabled_cli = "Disabled";
  $where_client = "WHERE client = '$id_client'";
  if ($operator_profile_id == 1) {
    $enabled_cli='';
	  $where_client = '';
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
                <h3>Puerta de Enlace / Gateway</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_nas;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="gateway_form" enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">

											<!-- form Gateway -->
				              <div class="col-md-6 col-sm-6 col-xs-12">
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_clients;?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selClient" class="form-control" <?php echo $enabled_cli ;?> name="id_client" required="required" onChange="showSpot()">
				                      <option value="" selected="true" disabled="disabled"> <?php echo $l_select_client;?> </option>

															<?php 
																include('library/opendb.php');
															  $sql_sel_schema = "SELECT client, esquema, name FROM ".$configValues['TBL_RWCLIENT']." ".$where_client;
																$ret_sel_schema = pg_query($dbConnect, $sql_sel_schema);
																if(!$ret_sel_schema) {
																	$line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
																}

																while ($row = pg_fetch_row($ret_sel_schema)) {

																	$row_client = $row[2];
																	echo "<option value=$row[1]>$row_client</option>";
																}
																include('library/closedb.php');
															?>
								            </select>
		                      </div>
		                    </div>
											  <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_spot ?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
													  <select id="selSpot" class="form-control" name="hotspot_id" required="required" onChange="showGatewaysList('')">
															<option value="%"><?php echo $l_select_spot ?></option>
													
													  </select>
													</div>
											  </div>				  											  
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_nas_ip_host;?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="nas_id" type="hidden" class="form-control" name="nas_id">
	                          <input id="nas_ip_host" type="text" class="form-control" <?php echo $btn_access;?> name="nas_ip_host" required="required">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_nas_secret;?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="nas_secret" type="text" class="form-control" <?php echo $btn_access;?> name="nas_secret" value="" required="required">
	                        </div>
	                      </div> 
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_nas_type;?> <span class="required">*</span></label>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selNasType" class="btn btn-default" <?php echo $show_access;?> name="nas_type"  required="required">
		                          <option value="other" selected="true">OTHER</option>
		                          <option value="cisco">CISCO</option>
		                          <option value="meraki">MERAKI</option>
		                        </select>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_nas_shortname;?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="nas_shortname" type="text" class="form-control" <?php echo $btn_access;?> name="nas_shortname" value="" required="required">
	                        </div>
	                      </div> 
											</div>	
											<!-- /form Gateway -->

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
                    <h2><?php echo $l_nas;?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable_gatewaysList" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID</th> 
                            <th class='column-title'><?php echo $l_spot;?> </th> 
                            <th class='column-title'><?php echo $l_nas_ip_host;?> </th> 
                            <th class='column-title'><?php echo $l_nas_secret;?> </th>
                            <th class='column-title'><?php echo $l_nas_type;?> </th>
                            <th class='column-title'><?php echo $l_nas_shortname;?> </th>
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

		<!-- showSpot -->
		<script>
			function showSpot() {

				var schemaid = $("#selClient").val();
				var countryid = 35;
				var stateid = '%';
				var cityid = '%';
				var locationid = '%';

				$.ajax({
					url: 'rest-api/settings/getSpot.php',
					type: 'POST',
					data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid},
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selSpot").empty();
						$("#selSpot").append("<option value='%' selected='true' disabled='disabled'><?php echo $l_select_spot;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selSpot").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
			}	
		</script>
		<!-- /showHoSpot -->
		
    <!-- showGatewaysList -->
    <script>
		  function showGatewaysList(id) {
	  
				var schemaid = $("#selClient").val();
				var spotid = $('#selSpot').val();

				$.ajax({
					url: 'rest-api/hotspot/getGatewaysList.php',
					type: 'GET',
					data: {schema:schemaid, idspot:spotid, nas_id:id},
					dataType: 'json',
					success:function(response) {

						result = response;
						if (id == '') {
							showGatewayTable(result);							
						} else {
							showGateway(result);														
						}
					}
				});
		  }	
		</script>
    <!-- /showGatewaysList -->

		<!-- showGatewayTable -->
		<script>
			function showGatewayTable(data) {
				$('#datatable_gatewaysList').DataTable({
					destroy: true,
					data: data,
					columns: [
	          { data: "id" },
	          { data: "spot_name" },
	          { data: "nasname" },
	          { data: "secret" },
	          { data: "type" },
	          { data: "shortname" },
						{ 
								data: null, render: function ( data, type, row ) {
	                // Combine the first and last names into a single table field
									return '<button id="btn" class="btn btn-success btn-xs" onclick="editGateway('+data.id+')"><i class="fa fa-edit"></i></button> <button id="btn" class="btn btn-primary btn-xs" onclick="deleteGateway('+data.id+')"><i class="fa fa-trash"></i></button>';
		            } 
							}
		      ],
          responsive: true						
				});
			}
		</script>
		<!-- /showGatewayTable -->		

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
				showGatewaysList('');						
				$('#datatable_gatewaysList').DataTable();

		    $('#gateway_form').submit(function(e) {
	        e.preventDefault();

					var schemaid = $("#selClient").val();
					var spotid = $("#selSpot").val();
					var id = $("#nas_id").val();
					var iphost = $("#nas_ip_host").val();
					var secret = $("#nas_secret").val();
					var nastype = $("#selNasType").val();
					var shortname = $("#nas_shortname").val();
					var type = 'I';
					if (id != '') type = 'U';
					
					$.ajax({
					  url: 'rest-api/hotspot/crudGateway.php',
					  type: 'POST',
						data: {schema:schemaid, idspot:spotid, nas_id:id, nas_ip_host:iphost, nas_secret:secret, nas_type:nastype, nas_shortname:shortname, action:type},
					  dataType: 'json',
					  success:function(response) {
					    console.log(response);
							
							document.getElementById('line_message').innerHTML = response.message;	
							showGatewaysList('');						
						}
					});
				}); 
      });
    </script>
    <!-- /Datatables -->
		
   <!-- Edit Gateway -->
	 <script>
		function editGateway(id) {
			var table = document.getElementById("datatable_gatewaysList");
			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {
						showGatewaysList(id);						
			    };
			  }
			}
			document.getElementById("selClient").disabled = true;
			document.getElementById("selSpot").disabled = true;
			document.getElementById("btnSubmit").disabled = false;
		};

	 </script>
   <!-- /Edit Gateway -->	

   <!-- Show Gateway -->
	 <script>
		function showGateway(data) {
			document.getElementById("nas_id").value = data[0].id;
			document.getElementById("nas_ip_host").value = data[0].nasname;
			document.getElementById("nas_secret").value = data[0].secret;
			document.getElementById("selNasType").value = data[0].type;
			document.getElementById("nas_shortname").value = data[0].shortname;
		};

	 </script>
   <!-- /Show Gateway -->	

   <!-- Delete Gateway -->
	 <script>
		function deleteGateway(id) {				
			var table = document.getElementById("datatable_gatewaysList");
			var schemaid = $("#selClient").val();
			var spotid = $("#selSpot").val();

			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {

						showGatewaysList(id);						
						if (confirm('<?php echo $l_message_delete;?>'+'<?php echo $l_nas;?>')) {
							var shortname = $("#nas_shortname").val();
							var type = 'D';

							$.ajax({
							  url: 'rest-api/hotspot/crudGateway.php',
							  type: 'POST',
								data: {schema:schemaid, idspot:spotid, nas_id:id, nas_shortname:shortname, action:type},
							  dataType: 'json',
							  success:function(response) {
							    console.log(response);
							
									document.getElementById('line_message').innerHTML = response.message;	
								}
							});							
							showGatewaysList('');						
						}
						document.getElementById("selClient").disabled = true;
						document.getElementById("selSpot").disabled = true;
						document.getElementById("btnSubmit").disabled = false;
			    };
			  }
			}
		};
	 </script>
   <!-- /Delete Gateway -->	
	 
   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			

  </body>
</html>