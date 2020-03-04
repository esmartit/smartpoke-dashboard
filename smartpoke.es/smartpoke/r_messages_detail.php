<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

	$loginpath = $_SERVER['PHP_SELF'];
	include ('library/checklogin.php');
	$page = '$sb_dashboard4';

	$operator_id = $_SESSION['operator_id'];
	$operator_user = $_SESSION['operator_user'];
	$operator_profile_id = $_SESSION['operator_profile_id'];
	$firstname = $_SESSION['firstname'];
	$lastname = $_SESSION['lastname'];
	$client_id = $_SESSION['client_id'];
	$lang = $_SESSION['lang'];
	$currDate = date('Y-m-d H:i:s');
	$currTime = date('H:i:s');

	$session_id = $_SESSION['id'];
	include('lang/main.php');
	include('library/pages_common.php');
	$show_access = opt_buttons($page, $operator_profile_id, 'show_btn');

  $datestart = date("Y-m-d", strtotime($currDate));
  $datestartspan = date("d M Y", strtotime($datestart));

	$dateend = date("Y-m-d", strtotime($currDate));
	$dateendspan = date("d M Y", strtotime($dateend));

	$id_client = $client_id;
	$country_id = '35';
	$state_id = '%';
	$city_id = '%';
	$location_id = '%';
  $spot_id = '%';
  $message_id = '%';
	$status = '%';

  $where_client = "WHERE client = '$id_client'";
  if ($operator_profile_id == 1) {
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
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
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
                <h3>Detalle SMS / SMS Detail</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_select_message;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="message_detail_form" class="form-horizontal form-label-left" method="POST" action='<?php echo $loginpath;?>'>

				              <!-- form select -->
				              <div class="col-md-6 col-sm-6 col-xs-12">

		                    <div class="form-group">
													<label class="control-label col-md-3 co-sm-3 col-xs-3"><?php echo $l_select_date;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		                          <span><?php echo $datestartspan.' - '.$dateendspan;?></span> <b class="caret"></b>
		                        </div>
		                      </div>
	                        <input type="hidden" name="datestart" id="datestart" value=<?php echo $datestart;?>/>
	                        <input type="hidden" name="dateend" id="dateend" value=<?php echo $dateend;?>/>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_clients;?> <span class="required">*</span></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <select id="selClient" class="form-control" name="id_client" required="required" onChange="showSpot()">
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
		                    <div class="form-group" style="display: none;">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_country;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selCountry" class="form-control" <?php echo $show_access;?> name="country_id">

															<?php 
																include('library/opendb.php');
																$sql_country = "SELECT id, country_name FROM ".$configValues['TBL_RWCOUNTRY'];
																$ret_country = pg_query($dbConnect, $sql_country);
																if(!$ret_country) {
																	$line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
																}

																while ($row = pg_fetch_row($ret_country)) {

																	$row_country = $row[1];
																	echo "<option value=$row[0] >$row_country</option>";
																}
																include('library/closedb.php');
															?>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_state;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selState" class="form-control" <?php echo $show_access;?> name="state_id" onChange="showCity()">
				                      <option value="%"> <?php echo $l_all_states;?> </option>

		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_city;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selCity" class="form-control" <?php echo $show_access;?> disabled name="city_id" onChange="showLocation()">
				                      <option value="%"> <?php echo $l_all_cities;?> </option>

		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_location;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selLocation" class="form-control" <?php echo $show_access;?> disabled name="location_id" onChange="showSpot()">
				                      <option value="%"> <?php echo $l_all_locations;?> </option>

		                        </select>
		                      </div>
		                    </div>

											  <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_spots_s ?> </label>
													<div class="col-md-9 col-sm-9 col-xs-12">
													  <select id="selSpot" class="form-control" name="spot_id" onChange="showCampaign()">
															<option value="%"><?php echo $l_all_spot ?></option>
													
													  </select>
													</div>
											  </div>													
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_message;?> </label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <select id="selCampaign" class="form-control" <?php echo $show_access;?> name="message_id">
								              <option value="" selected="true" disabled="disabled"><?php echo $l_all_message;?> </option>
														
		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_status;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <select id="selStatus" class="btn btn-default" <?php echo $show_access;?> name="status">
		                          <option value="%" selected="%"><?php echo $l_all_status;?></option>
															
																<?php
			                            $message_status = $status;
			                            $arr_id = array(0, 1);
			                            $arr_des = array('OK', 'NOK');

			                            for($i=0; $i < count($arr_id); $i++) {
			                              $selected_status='';
			                              if ($message_status == $arr_id[i]) $selected_status = 'selected=$message_status';
			                              echo "<option value='$arr_id[$i]' $selected_status>$arr_des[$i]</option>";
			                            }																
																?>

		                        </select>
		                      </div>
		                    </div> 
											</div> 
											<!-- /select -->
                      <div class="form-group">
                      </div>
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button id="btnCancel" type="submit" name="btnCancel" class="btn btn-primary" value="cancel" onclick="resetForm()"><?php echo $l_cancel;?></button>
                          <button id="btnSubmit" type="submit" name="btnSubmit" class="btn btn-success" <?php echo $show_access;?> value="submit" ><?php echo $l_search;?></button>
                        </div>
                      </div>
                    </form>
                  </div>
									<div class="row">
				            <div class="col-md-9 col-sm-9 col-xs-12">
				              <div class="x_panel tile fixed_height_320">
				                <div class="x_title">
				                  <h2><?php echo $l_tot_sms.' '.$l_chk_graph_month;?></h2>
				                  <div class="clearfix"></div>
				                </div>
				                <div class="x_content">
													<div class='row tile_count'>
						                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
															<span class='count_top'><i class='fa fa-stack-overflow'></i><?php echo '  '.$l_tot_sms.' Ini.';?></span>
															<div id="total_sms_ini" class='count'></div>
													  </div>
						                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
															<span class='count_top red'><i class='fa fa-stack-overflow'></i><?php echo '  '.$l_tot_sms;?></span>
															<div id="total_sms" class='count red'></div>
													  </div>
													</div>
													<div class='row tile_count'>
						                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
															<span class='count_top blue'><i class='fa fa-paper-plane'></i><?php echo '  '.$l_tot_sms_send;?></span>
															<div id="total_sms_send" class='count blue'></div>
													  </div>
						                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
															<span class='count_top green'><i class='fa fa-thumbs-up'></i><?php echo '  '.$l_tot_sms_send_ok;?></span>
															<div id="total_sms_ok" class='count green'></div>
													  </div>
						                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
															<span class='count_top red'><i class='fa fa-thumbs-down'></i><?php echo '  '.$l_tot_sms_send_nok;?></span>
															<div id="total_sms_nok" class='count red'></div>
													  </div>
													</div>               
				                </div>
				              </div>
				            </div>
				            <div class="col-md-3 col-sm-3 col-xs-12">
			                <div id="status_messages_month" style="height:350px;"></div>
				            </div>
									</div>
									<div class="row">
				            <div class="col-md-9 col-sm-9 col-xs-12">
				              <div class="x_panel tile fixed_height_320">
				                <div class="x_title">
				                  <h2><?php echo $l_campaign;?></h2>				                  
				                  <div class="clearfix"></div>
				                </div>
				                <div class="x_content">
						              <div class="row tile_count">
						                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
						                  <span class="count_top blue"><i class="fa fa-paper-plane"></i><?php echo '  '.$l_tot_sms_send;?> </span>
						                  <div id="tot_sms_send" class="count blue"></div>
						                </div>
						                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
						                  <span class="count_top green"><i class="fa fa-thumbs-up"></i><?php echo '  '.$l_tot_sms_send_ok;?> </span>
						                  <div id="tot_sms_send_ok" class="count green"></div>
						                </div>
						                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
						                  <span class="count_top red"><i class="fa fa-thumbs-down"></i><?php echo '  '.$l_tot_sms_send_nok;?> </span>
						                  <div id="tot_sms_send_nok" class="count red"></div>
						                </div>
						              </div>
				                </div>
				              </div>
				            </div>
				            <div class="col-md-3 col-sm-3 col-xs-12">
			                <div id="status_messages_period" style="height:350px;"></div>
				            </div>
									</div>
                </div>
              </div>
            </div>  

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_messages_detail;?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable-messages" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title"><?php echo $l_spots_s;?> </th> 
                            <th class="column-title"><?php echo $l_message_name;?> </th> 
                            <th class="column-title"><?php echo $l_username;?> </th>
                            <th class="column-title"><?php echo $l_device;?> </th>
                            <th class="column-title"><?php echo $l_message_startdate;?> </th>
                            <th class="column-title"><?php echo $l_status;?> </th>
                            <th class="column-title"><?php echo $l_description;?> </th>
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
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-progressbar -->
    <script src='../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
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
    <!-- ECharts -->
    <script src='../vendors/echarts/dist/echarts.min.js'></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

		<script>
			$( window ).load(function() {
								
				var countryid = '<?php echo $country_id?>';

			  $('#selCountry option[value="'+countryid+'"]').prop('selected', true);
			  var evt = document.createEvent("HTMLEvents");
			  evt.initEvent("change", false, true);
			  document.getElementById('selCountry').dispatchEvent(evt);
				
			});

			document.getElementById('total_sms_ini').innerHTML = 0;
			document.getElementById('total_sms').innerHTML = 0;
			document.getElementById('total_sms_send').innerHTML = 0;
			document.getElementById('total_sms_ok').innerHTML = 0;
			document.getElementById('total_sms_nok').innerHTML = 0;

			document.getElementById('tot_sms_send').innerHTML = 0;
			document.getElementById('tot_sms_send_ok').innerHTML = 0;
			document.getElementById('tot_sms_send_nok').innerHTML = 0;

			$("#selCountry").change(function() {
				showState();
			});
							
    </script>
		
    <!-- /showState - City - Location -->
    <script>
		  function showState() {
	  
				var countryid = $("#selCountry").val();

				$.ajax({
					url: 'rest-api/general/getState.php',
					type: 'POST',
					data: {idcountry:countryid},
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selState").empty();
						$("#selState").append("<option value='%'><?php echo $l_all_states;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selState").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showCity();
		  }	
    </script>
			
		<script>
		  function showCity() {
	  

				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				
			  $("#selCity").prop("disabled", true);
			  $("#selLocation").prop("disabled", true);
				if (stateid != '%') $("#selCity").prop("disabled", false);
				
					$.ajax({
					url: 'rest-api/general/getCity.php',
					type: 'POST',
					data: {idcountry:countryid, idstate:stateid},
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selCity").empty();
						$("#selCity").append("<option value='%'><?php echo $l_all_cities;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selCity").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showLocation();
				showSpot();
				showCampaign();
		  }	
    </script>
		<script>
					
		  function showLocation() {
	  
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();

			  $("#selLocation").prop("disabled", true);
				if (cityid != '%') $("#selLocation").prop("disabled", false);

					$.ajax({
					url: 'rest-api/general/getLocation.php',
					type: 'POST',
					data: {idcountry:countryid, idstate:stateid, idcity:cityid},
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selLocation").empty();
						$("#selLocation").append("<option value='%'><?php echo $l_all_locations;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selLocation").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showSpot();
		  }			
    </script>
    <!-- /showState - City - Location -->

    <!-- /showSpot - Campaign -->
    <script>
		  function showSpot() {
	  
				var schemaid = $("#selClient").val();
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();
				var locationid = $("#selLocation").val();

				$.ajax({
					url: 'rest-api/settings/getSpot.php',
					type: 'POST',
					data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid},
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selSpot").empty();
						$("#selSpot").append("<option value='%'><?php echo $l_all_spot;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selSpot").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showCampaign();
		  }	
		</script>
			
	  <script>
		  function showCampaign() {
	  
				var schemaid = $("#selClient").val();
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();
				var locationid = $("#selLocation").val();
				var spotid = $("#selSpot").val();
				var typeid = "T";
				
				$.ajax({
				  url: 'rest-api/settings/getCampaign.php',
				  type: 'POST',
					data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid, type:typeid},
				  dataType: 'json',
				  success:function(response) {

						var len = response.length;

						$("#selCampaign").empty();
						$("#selCampaign").append("<option value='%'><?php echo $l_all_message;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selCampaign").append("<option value='"+id+"'>"+name+"</option>");

						}
				  }
				});
		  }			
    </script>
    <!-- /showSpot - Campaign -->
				
    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {

        var datestart;
        var dateend;
        var datestart2;
        var dateend2;
				
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('<?php echo $l_dateformat;?>') + ' - ' + end.format('<?php echo $l_dateformat;?>'));
          datestart = start.format('YYYY-MM-DD');
          dateend = end.format('YYYY-MM-DD');
          $('#datestart').val(datestart);
          $('#dateend').val(dateend);
        };

        var cb2 = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange2 span').html(start.format('<?php echo $l_dateformat;?>') + ' - ' + end.format('<?php echo $l_dateformat;?>'));
          datestart2 = start.format('YYYY-MM-DD');
          dateend2 = end.format('YYYY-MM-DD');
          $('#datestart2').val(datestart2);
          $('#dateend2').val(dateend2);

        };

        var optionSet1 = {
          startDate: moment(),
          endDate: moment(),
          minDate: '01/01/1900',
          maxDate: '12/31/2050',
          dateLimit: {
            days: 180
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: false,
          ranges: {
            '<?php echo $l_Today;?>': [moment(), moment()],
            '<?php echo $l_Yesterday;?>': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '<?php echo $l_This_Month;?>': [moment().startOf('month'), moment().endOf('month')],
            '<?php echo $l_Last_Month;?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'right',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: '<?php echo $l_Submit;?>',
            cancelLabel: '<?php echo $l_Clear;?>',
            fromLabel: '<?php echo $l_From;?>',
            toLabel: '<?php echo $l_To;?>',
            customRangeLabel: '<?php echo $l_Custom;?>',
            daysOfWeek: ['<?php echo $l_Su;?>', '<?php echo $l_Mo;?>', '<?php echo $l_Tu;?>', '<?php echo $l_We;?>', '<?php echo $l_Th;?>', '<?php echo $l_Fr;?>', '<?php echo $l_Sa;?>'],
            monthNames: ['<?php echo $l_January;?>', '<?php echo $l_February;?>', '<?php echo $l_March;?>', '<?php echo $l_April;?>', '<?php echo $l_May;?>', '<?php echo $l_June;?>', '<?php echo $l_July;?>', '<?php echo $l_August;?>', '<?php echo $l_September;?>', '<?php echo $l_October;?>', '<?php echo $l_November;?>', '<?php echo $l_December;?>'],
            firstDay: 1
          }
        };

        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log('show event fired');
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log('hide event fired');
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log('apply event fired, start/end dates are ' + picker.startDate.format('<?php echo $l_dateformat;?>') + ' to ' + picker.endDate.format('<?php echo $l_dateformat;?>'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log('cancel event fired');
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });

        $('#reportrange2').daterangepicker(optionSet1, cb2);
        $('#reportrange2').on('show.daterangepicker', function() {
          console.log('show event fired');
        });
        $('#reportrange2').on('hide.daterangepicker', function() {
          console.log('hide event fired');
        });
        $('#reportrange2').on('apply.daterangepicker', function(ev, picker) {
          console.log('apply event fired, start/end dates are ' + picker.startDate.format('<?php echo $l_dateformat;?>') + ' to ' + picker.endDate.format('<?php echo $l_dateformat;?>'));
        });
        $('#reportrange2').on('cancel.daterangepicker', function(ev, picker) {
          console.log('cancel event fired');
        });
        $('#options1').click(function() {
          $('#reportrange2').data('daterangepicker').setOptions(optionSet1, cb2);
        });
        $('#options2').click(function() {
          $('#reportrange2').data('daterangepicker').setOptions(optionSet2, cb2);
        });
        $('#destroy').click(function() {
          $('#reportrange2').data('daterangepicker').remove();					
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->


    <!-- Doughnut Chart -->
		<script>
			function drawDoughnutChartstatus_m(sms_ok, sms_nok) {
				option = {
				    tooltip: {
				        trigger: 'item',
				        formatter: "{a} <br/>{b}: {c} ({d}%)"
				    },
				    legend: {
				        orient: 'vertical',
				        x: 'left',
				        data:['SMS OK','SMS NOK']
				    },
			      toolbox: {
			        show: true,
			        feature: {
			          magicType: {
			            show: true,
			            title: {
			            },
			            type: []
			          },
			          restore: {
			            show: true,
			            title: 'Restore'
			          },
			          saveAsImage: {
			            show: true,
			            title: 'Save Image'
			          }
			        }
			      },
				    series: [
				        {
				            name:'Ratio',
				            type:'pie',
				            radius: ['50%', '70%'],
				            avoidLabelOverlap: false,
				            label: {
				                normal: {
				                    show: false,
				                    position: 'center'
				                },
				                emphasis: {
				                    show: true,
				                    textStyle: {
				                        fontSize: '25',
				                        fontWeight: 'bold'
				                    }
				                }
				            },
				            labelLine: {
				                normal: {
				                    show: false
				                }
				            },
				            data:[
				                {value:sms_nok, name:'SMS NOK'},
												{value:sms_ok, name:'SMS OK'}
				            ]
				        }
				    ]
				};

				var smschart = document.getElementById('status_messages_month');					
				var mysmsChart = echarts.init(smschart);
				mysmsChart.setOption(option);			
			}
		</script>

		<script>
			function drawDoughnutChartstatus_p(sms_ok, sms_nok) {
				option = {
				    tooltip: {
				        trigger: 'item',
				        formatter: "{a} <br/>{b}: {c} ({d}%)"
				    },
				    legend: {
				        orient: 'vertical',
				        x: 'left',
				        data:['SMS OK','SMS NOK']
				    },
			      toolbox: {
			        show: true,
			        feature: {
			          magicType: {
			            show: true,
			            title: {
			            },
			            type: []
			          },
			          restore: {
			            show: true,
			            title: 'Restore'
			          },
			          saveAsImage: {
			            show: true,
			            title: 'Save Image'
			          }
			        }
			      },
				    series: [
				        {
				            name:'Ratio',
				            type:'pie',
				            radius: ['50%', '70%'],
				            avoidLabelOverlap: false,
				            label: {
				                normal: {
				                    show: false,
				                    position: 'center'
				                },
				                emphasis: {
				                    show: true,
				                    textStyle: {
				                        fontSize: '25',
				                        fontWeight: 'bold'
				                    }
				                }
				            },
				            labelLine: {
				                normal: {
				                    show: false
				                }
				            },
				            data:[
				                {value:sms_nok, name:'SMS NOK'},
												{value:sms_ok, name:'SMS OK'}
				            ]
				        }
				    ]
				};

				var smschart = document.getElementById('status_messages_period');					
				var mysmsChart = echarts.init(smschart);
				mysmsChart.setOption(option);			
			}
		</script>
    <!-- /Doughnut Chart -->

    <!-- Datatables -->
    <script>
      $(document).ready(function() {

		    $('#btnSubmit').on('click', function(e) {
	        e.preventDefault();
					
					NProgress.start();
					NProgress.set(0,4);

					var date_s1 = $("#datestart").val();
					var date_e1 = $("#dateend").val();
					var schemaid = $("#selClient").val();
					var countryid = $("#selCountry").val();
					var stateid = $("#selState").val();
					var cityid = $("#selCity").val();
					var locationid = $("#selLocation").val();
					var spotid = $("#selSpot").val();
					var messageid = $("#selCampaign").val();
					var statusid = $("#selStatus").val();

					var operatorid = <?php echo $operator_profile_id;?>;
					if (operatorid != 1) operatorid =  <?php echo $operator_id;?>;
					// alert("schema: "+schemaid+", idcountry: "+countryid+", idstate: "+stateid+", idcity: "+cityid+",idlocation: "+locationid+", idspot: "+spotid+", datestart: "+date_s1+", dateend: "+date_e1+", operator_id: "+operatorid+", message_id: "+messageid+", status: "+statusid),

					$.ajax({
					  url: 'rest-api/smartpoke/getMessageDetail.php',
					  type: 'POST',
						data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid,
						datestart:date_s1, dateend:date_e1, operator_id:operatorid, message_id:messageid, status:statusid},
					  dataType: 'json',
					  success:function(response) {
					    console.log(response);
							
							var len = response.length;
							total_sms_ini = 0;
							total_sms = 0;
							total_sms_ok = 0;
							total_sms_nok = 0;
							total_sms_send = 0;
							tot_sms_send_ok = 0;
							tot_sms_send_nok = 0;
							tot_sms_send = 0;
							var status = [];
							var cant = [];
							
							for (var i = 0; i<len; i++) {

								var object = response[i];								
								for (property in object) {
					        var value = object[property];
									if (value == 'month') {
										total_sms_ini = object['data'][0].total_sms;
										total_sms = object['data'][0].balance;
										total_sms_ok = object['data'][0].ok;
										total_sms_nok = object['data'][0].nok;
										total_sms_send = total_sms_ok + total_sms_nok;
										document.getElementById('total_sms_ini').innerHTML = Intl.NumberFormat().format(total_sms_ini);
										document.getElementById('total_sms').innerHTML = Intl.NumberFormat().format(total_sms);
										document.getElementById('total_sms_send').innerHTML = Intl.NumberFormat().format(total_sms_send);
										document.getElementById('total_sms_ok').innerHTML = Intl.NumberFormat().format(total_sms_ok);
										document.getElementById('total_sms_nok').innerHTML = Intl.NumberFormat().format(total_sms_nok);
										drawDoughnutChartstatus_m(total_sms_ok, total_sms_nok);
									}
									if (value == 'period') {
										tot_sms_send = object['data'][0].total_send;
										tot_sms_send_ok = object['data'][0].ok;
										tot_sms_send_nok = object['data'][0].nok;
										document.getElementById('tot_sms_send').innerHTML = Intl.NumberFormat().format(tot_sms_send);
										document.getElementById('tot_sms_send_ok').innerHTML = Intl.NumberFormat().format(tot_sms_send_ok);
										document.getElementById('tot_sms_send_nok').innerHTML = Intl.NumberFormat().format(tot_sms_send_nok);
										drawDoughnutChartstatus_p(tot_sms_send_ok, tot_sms_send_nok);
									}
									
									// if (value == 'status') {
									// 	for (var x = 0; x<object['data'].length; x++) {
									// 		status[x] = object['data'][x].description;
									// 		cant[x] = object['data'][x].total;
									// 	}
									// 	drawDoughnutChartstatus(status, cant);
									// }
									if (value == 'table') {
										var result = object['data'];
										show_datatable_messages(result);
									}
								}
							}
							NProgress.done();
						}						
					});
				});

				function show_datatable_messages(data) {

					NProgress.start();
					NProgress.set(0.4);

					var table_dtime = $('#datatable-messages').DataTable({
						destroy: true,
						data: data,
            columns: [
              { data: 'spot_id'},
              { data: 'campaign_name'},
              { data: 'username'},
              { data: 'device'},
              { data: 'date'},
							{ data: 'status'},
							{ data: 'description'}
						],
            dom: 'Bfrtip',
            buttons: [
              {
                extend: 'copy',
                className: 'btn-sm'
              },
              {
                extend: 'csv',
                className: 'btn-sm'
              },
              {
                extend: 'excel',
                className: 'btn-sm'
              },
              {
                extend: 'pdfHtml5',
                className: 'btn-sm'
              },
              {
                extend: 'print',
                className: 'btn-sm'
              },
            ],
            responsive: true						
					});
					NProgress.done();
				}
				
			});
		</script>
		<!-- /Datatablea -->
				
   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			
  </body>
</html>
