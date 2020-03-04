<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_limitations_hs';

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
  
  if ($edit_access == 'enabled') {
    $icon_print = 'fa fa-print';
    $icon_preview = 'fa fa-eye';
  }
  if ($delete_access == 'enabled') $icon_delete = 'fa fa-trash';

  $id_client = $client_id;
  $country_id = '35';
  $state_id = '%';    
  $city_id = '%';
	$location_id = '%';
	$spot_id = '%';  	
  $limit_name = '';
  $limit_upload = '';
  $value_upload = '';
  $limit_download = '';
  $value_download = '';
  $limit_traffic = '';
  $value_traffic = '';
  $redirect = '';
  $access_period = '';
  $value_access_period = '';
  $daily_session = '';
  $value_daily_session = '';
	
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
                <h3>Limitaciones / Limitations<small></small></h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_limitations;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="limitation_form" enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">
											
											<!-- form Limitations -->
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
													  <select id="selSpot" class="form-control" name="hotspot_id" required="required" onChange="showLimitationsList('')">
															<option value="%"><?php echo $l_select_spot ?></option>
													
													  </select>
													</div>
											  </div>				  											  
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_limit_name;?> <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="limit_id" type="hidden" class="form-control" name="limit_id">
	                          <input id="limit_name" type="text" class="form-control" <?php echo $btn_access;?> name="limit_name" required="required">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_limit_upload;?> <span class="required">*</span></label>
	                        <div class="col-md-4 col-sm-4 col-xs-12">
	                          <input id="limit_upload" type="text" class="form-control" <?php echo $btn_access;?> name="limit_upload" required="required">
	                        </div>
	                        <div class="col-md-3 col-sm-3 col-xs-12">
		                        <select id="selValueUp" class="btn btn-default" <?php echo $show_access;?> name="value_upload">
		                          <option value="1024" selected="true">kbps</option>
		                          <option value="1048576">mbps</option>
		                          <option value="1073741824">gbps</option>
		                        </select>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_limit_download;?> <span class="required">*</span></label>
	                        <div class="col-md-4 col-sm-4 col-xs-12">
	                          <input id="limit_download" type="text" class="form-control" <?php echo $btn_access;?> name="limit_download" required="required">
	                        </div>
	                        <div class="col-md-3 col-sm-3 col-xs-12">
		                        <select id="selValueDown" class="btn btn-default" <?php echo $show_access;?> name="value_download">
		                          <option value="1024" selected="true">kbps</option>
		                          <option value="1048576">mbps</option>
		                          <option value="1073741824">gbps</option>
		                        </select>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_limit_traffic;?></label>
	                        <div class="col-md-4 col-sm-4 col-xs-12">
	                          <input id="limit_traffic" type="text" class="form-control" <?php echo $btn_access;?> name="limit_traffic">
	                        </div>
	                        <div class="col-md-3 col-sm-3 col-xs-12">
		                        <select id="selTraffic" class="btn btn-default" <?php echo $show_access;?> name="value_traffic">
		                          <option value="1024" selected="true"> KB </option>
		                          <option value="1048576"> MB </option>
		                          <option value="1073741824"> GB </option>
		                        </select>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_redirect;?></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <input id="redirect" type="text" class="form-control" <?php echo $btn_access;?> name="redirect">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_access_period;?></label>
	                        <div class="col-md-4 col-sm-4 col-xs-12">
	                          <input id="access_period" type="text" class="form-control" <?php echo $btn_access;?> name="access_period">
	                        </div>
	                        <div class="col-md-3 col-sm-3 col-xs-12">
		                        <select id="selAccessPeriod" class="btn btn-default" <?php echo $show_access;?> name="value_access_period">
	                            <option value="60" selected="true"><?php echo $l_minutes;?></option>
	                            <option value="3600"><?php echo $l_hours;?></option>
	                            <option value="86400"><?php echo $l_days;?></option>
		                        </select>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_daily_session;?></label>
	                        <div class="col-md-4 col-sm-4 col-xs-12">
	                          <input id="daily_session" type="text" class="form-control" <?php echo $btn_access;?> name="daily_session">
	                        </div>
	                        <div class="col-md-3 col-sm-3 col-xs-12">
		                        <select id="selDailySession" class="btn btn-default" <?php echo $show_access;?> name="value_daily_session">
	                            <option value="60" selected="true"><?php echo $l_minutes;?></option>
	                            <option value="3600"><?php echo $l_hours;?></option>
		                        </select>
	                        </div>
	                      </div>												
                      </div> 
											<!-- /form Limitations -->

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
                    <h2><?php echo $l_limitations;?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable_limitationsList" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class='column-title'>ID </th> 
                            <th class='column-title'><?php echo $l_spot;?> </th> 
                            <th class='column-title'><?php echo $l_groupname_name;?> </th> 
                            <th class='column-title'><?php echo $l_users;?> </th> 
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
    <script src='../vendors/jquery/dist/jquery.min.js'></script>
    <!-- Bootstrap -->
    <script src='../vendors/bootstrap/dist/js/bootstrap.min.js'></script>
    <!-- Datatables -->
    <script src='../vendors/datatables.net/js/jquery.dataTables.min.js'></script>
    <script src='../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'></script>
    <script src='../vendors/datatables.net-buttons/js/dataTables.buttons.min.js'></script>
    <script src='../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'></script>
    <script src='../vendors/datatables.net-buttons/js/buttons.flash.min.js'></script>
    <script src='../vendors/datatables.net-buttons/js/buttons.html5.min.js'></script>
    <script src='../vendors/datatables.net-buttons/js/buttons.print.min.js'></script>
    <script src='../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js'></script>
    <script src='../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js'></script>
    <script src='../vendors/datatables.net-responsive/js/dataTables.responsive.min.js'></script>
    <script src='../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js'></script>
    <script src='../vendors/datatables.net-scroller/js/dataTables.scroller.min.js'></script>
    <script src='../vendors/jszip/dist/jszip.min.js'></script>
    <script src='../vendors/pdfmake/build/pdfmake.min.js'></script>
    <script src='../vendors/pdfmake/build/vfs_fonts.js'></script>


    <!-- Custom Theme Scripts -->
    <script src='../build/js/custom.min.js'></script>

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
		
    <!-- showLimitationsList -->
    <script>
		  function showLimitationsList(id) {
	  
				var schemaid = $("#selClient").val();
				var spotid = $('#selSpot').val();

				$.ajax({
					url: 'rest-api/hotspot/getLimitationsList.php',
					type: 'GET',
					data: {schema:schemaid, idspot:spotid, limit_id:id},
					dataType: 'json',
					success:function(response) {

						result = response;
						if (id == '') {
							showLimitationTable(result);							
						} else {
							showLimitation(result);														
						}
					}
				});
		  }	
		</script>
    <!-- /showLimitationsList -->

		<!-- showLimitationTable -->
		<script>
			function showLimitationTable(data) {
				$('#datatable_limitationsList').DataTable({
					destroy: true,
					data: data,
					columns: [
	          { data: "id" },
	          { data: "spot_id" },
	          { data: "groupname" },
	          { data: "cant" },
						{ 
							data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
								return '<button id="btn" class="btn btn-success btn-xs" onclick="editLimit('+data.id+')"><i class="fa fa-edit"></i></button> <button id="btn" class="btn btn-primary btn-xs" onclick="deleteLimit('+data.id+')"><i class="fa fa-trash"></i></button>';
	            } 
						}
		      ],
          responsive: true						
				});
			}
		</script>
		<!-- /showLimitationTable -->		

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
				showLimitationsList('');						
				$('#datatable_limitationsList').DataTable();

		    $('#limitation_form').submit(function(e) {
	        e.preventDefault();

					var schemaid = $("#selClient").val();
					var spotid = $("#selSpot").val();
					var id = $("#limit_id").val();
					var name = $("#limit_name").val();
					var limitup = $("#limit_upload").val();
					var valup = $("#selValueUp").val();
					var limitdown = $("#limit_download").val();
					var valdown = $("#selValueDown").val();
					var limittraffic = $("#limit_traffic").val();
					var valtraffic = $("#selTraffic").val();
					var redirect = $("#redirect").val();
					var access = $("#access_period").val();
					var valaccess = $("#selAccessPeriod").val();
					var daily = $("#daily_session").val();
					var valdaily = $("#selDailySession").val();
					var type = 'I';
					if (id != '') type = 'U';
					
					$.ajax({
					  url: 'rest-api/hotspot/crudLimitation.php',
					  type: 'POST',
						data: {schema:schemaid, idspot:spotid, limit_name:name, limit_upload:limitup, value_upload:valup, limit_download:limitdown, value_download:valdown, limit_traffic:limittraffic, value_traffic:valtraffic, redirect:redirect, access_period:access, value_access_period:valaccess, daily_session:daily, value_daily_session:valdaily, action:type},
					  dataType: 'json',
					  success:function(response) {
					    console.log(response);
							
							document.getElementById('line_message').innerHTML = response.message;	
							showLimitationsList('');						
						}
					});
				}); 
      });
    </script>
    <!-- /Datatables -->

    <!-- showRadGroup -->
    <script>
		  function showRadGroup(name) {
	  
				var schemaid = $("#selClient").val();
				var spotid = $('#selSpot').val();

				$.ajax({
					url: 'rest-api/hotspot/getRadGroup.php',
					type: 'POST',
					data: {schema:schemaid, idspot:spotid, limit_name:name},
					dataType: 'json',
					success:function(response) {
				    console.log(response);
						
						var len = response.length;
						for (var i = 0; i<len; i++) {
							
							var object = response[i];
							
							var attribute = object['attribute'];
							var value = object['value'];
							var radgroup = object['rad'];
							
							switch (attribute) {
				        case 'WISPr-Bandwidth-Max-Up':
									document.getElementById("limit_upload").value = value;
				          break;
				        case 'WISPr-Bandwidth-Max-Down':
									document.getElementById("limit_download").value = value;
				          break;
				        case 'Max-Daily-Octets':
									document.getElementById("limit_traffic").value = value;
				          break;
				        case 'WISPr-Redirection-URL':
									document.getElementById("redirect").value = value;
				          break;
				        case 'Access-Period':
									document.getElementById("access_period").value = value;
				          break;
				        case 'Max-Daily-Session':
									document.getElementById("daily_session").value = value;
				          break;
							}
						}
					}
				});
		  }	
		</script>
    <!-- /showRadGroup -->
		
   <!-- Edit Limitation -->
	 <script>
		function editLimit(id) {
			var table = document.getElementById("datatable_limitationsList");
			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {
						showLimitationsList(id);						
			    };
			  }
			}
			document.getElementById("selClient").disabled = true;
			document.getElementById("selSpot").disabled = true;
			document.getElementById("limit_name").disabled = true;
		};

	 </script>
   <!-- /Edit Limitation -->	

   <!-- Show Limitation -->
	 <script>
		function showLimitation(data) {
			var limitname = data[0].groupname;
			document.getElementById("limit_id").value = data[0].id;
			document.getElementById("limit_name").value = limitname;
			showRadGroup(limitname);
		};

	 </script>
   <!-- /Show Limitation -->	

   <!-- Delete Limitation -->
	 <script>
		function deleteLimit(id) {				
			var table = document.getElementById("datatable_limitationsList");
			var schemaid = $("#selClient").val();
			var spotid = $("#selSpot").val();

			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {

						showLimitationsList(id);						
						if (confirm('<?php echo $l_message_delete;?>'+'<?php echo $l_limitations;?>')) {
							var name = $("#limit_name").val();
							var type = 'D';

							$.ajax({
							  url: 'rest-api/hotspot/crudLimitation.php',
							  type: 'POST',
								data: {schema:schemaid, idspot:spotid, limit_name:name, action:type},
							  dataType: 'json',
							  success:function(response) {
							    console.log(response);
							
									document.getElementById('line_message').innerHTML = response.message;	
								}
							});							
							showLimitationsList('');						
						}
						document.getElementById("selClient").disabled = true;
						document.getElementById("selSpot").disabled = true;
						document.getElementById("limit_name").disabled = true;
			    };
			  }
			}
		};
	 </script>
   <!-- /Delete Limitation -->	
	 
   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->	
	 		
	</body>
</html>

