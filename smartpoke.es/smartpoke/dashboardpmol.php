<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

	$loginpath = $_SERVER['PHP_SELF'];
	include ('library/checklogin.php');
	$page = '$sb_dashboard1';

	$operator_id = $_SESSION['operator_id'];
	$operator_user = $_SESSION['operator_user'];
	$operator_profile_id = $_SESSION['operator_profile_id'];
	$firstname = $_SESSION['firstname'];
	$lastname = $_SESSION['lastname'];
	$client_id = $_SESSION['client_id'];
    $c_name = $_SESSION['c_name'];
	$lang = $_SESSION['lang'];
	$currDate = date('Y-m-d H:i:s');
	$currTime = date('H:i:s');
	
	$session_id = $_SESSION['id'];
	include('lang/main.php');

	include('library/pages_common.php');
	$show_access = opt_buttons($page, $operator_profile_id, 'show_btn');

  $datestart = date("d M Y", strtotime($currDate));
  $datestartspan = date("d M Y", strtotime($datestart));

  $timestart=$_SESSION['timestart'];
	$time_ini = (int)substr($timestart, 0, 2);

  $timeend=$currTime;
	$time_end = (int)substr($timeend, 0, 2);

  $id_client = $client_id;
  if (isset($_POST['id_client'])) {
    $id_client = $_POST['id_client'];
  }
    
  $country_id = '35';
  $state_id = '%';
	$city_id = '%';
	$location_id = '%';
  $spot_id = '%';
	$sensor_name = '%';  	
  $radio_chkgraph = '0';           
  $status_id = '%';
	$brand_list = '';
	$radio_chkin = '1';
  $chk_in_1 = 'checked';
	
  $bigdata = stats_val(0, 0);
  $bigdata_in = stats_val(0, 0);
  $bigdatavisits_in = stats_val(0, 0);

  $gdbigdata = percent_val(0,0);
  $gdbigdatavisits = percent_val(0,0);
  
  $totalacct = stats_val(0, 0);
  $in = stats_val(0, 0);
  $limit = stats_val(0, 0);
  $out = stats_val(0, 0);
	
  $gdin = percent_val(0,0);
  $gdlimit = percent_val(0,0);
  $gdout = percent_val(0,0);
	
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
                <h3>OnLine / Analytics</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_query;?></h2>                    
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="online_select_form" class="form-horizontal form-label-left" method="POST" action="<?php echo $loginpath;?>">

				              <!-- form select -->
				              <div class="col-md-6 col-sm-6 col-xs-12">

		                    <div class="form-group">
													<label class="control-label col-md-3 co-sm-3 col-xs-3"><?php echo $l_select_date;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		                          <span><?php echo $datestartspan;?></span> <b class="caret"></b>
		                        </div>
		                      </div>
	                        <input type="hidden" name="datestart" id="datestart" value="<?php echo $datestart;?>" />
		                    </div>
												<div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_hours;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <div class="col-md-4 col-sm-6 col-xs-12">
			                        <input id="timestart" type="text" name="timestart" <?php echo $show_access;?> class="form-control col-md-10" value=<?php echo $timestart;?> />
			                      </div>
			                      <div class="col-md-4 col-sm-6 col-xs-12">
			                        <input id="timeend" type="text" name="timeend" disabled class="form-control col-md-10" />
			                      </div> 
													</div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_client;?> </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selClient" disabled class="form-control" name="id_client">
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
			                      <select id="selCity" class="form-control" disabled name="city_id" onChange="showLocation()">
				                      <option value="%"> <?php echo $l_all_cities;?> </option>

		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_location;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selLocation" class="form-control" disabled name="location_id" onChange="showSpot()">
				                      <option value="%"> <?php echo $l_all_locations;?> </option>

		                        </select>
		                      </div>
		                    </div>

											  <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_spots ?></label>
													<div class="col-md-9 col-sm-9 col-xs-12">
													  <select id="selSpot" class="form-control" name="spot_id" onChange="showSensor()">
															<option value="%"><?php echo $l_all_spot ?></option>
													
													  </select>
													</div>
											  </div>				  
											  <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_sensor ?></label>
													<div class="col-md-6 col-sm-6 col-xs-12">
													  <select id="selSensor" class="form-control" <?php echo $show_access;?> name="sensor_name" onChange="showOnlinePage()">
															<option value="%"><?php echo $l_all_sensor ?></option>
													
													  </select>
													</div>
											  </div>

											</div>	
				              <!-- / select -->
				              <!-- filters -->
				              <div class="col-md-6 col-sm-6 col-xs-12">									
			                  <div class="form-group">
			                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_status;?></label>
			                    <div class="col-md-6 col-sm-6 col-xs-12">
			                      <select id= "selStatus" class="form-control" <?php echo $show_access;?> name="status_id" onChange="showOnlinePage()">
			                        <option value="%"><?php echo $l_all_select_status;?></option>
			                        <option value="IN"><?php echo $l_in;?></option>
			                        <option value="LIMIT"><?php echo $l_limit;?></option>
			                        <option value="OUT"><?php echo $l_out;?></option>
			                      </select>
			                    </div>
			                  </div>
												<div class="form-group">
												  <label class="control-label col-md-3 col-sm-3 col-xs-3"><?php echo $l_devices;?></label>
												  <div class="col-md-6 col-sm-6 col-xs-12">
														<select id="brand_list" class="select2_multiple form-control" <?php echo $show_access;?> name="brand_list[]" multiple="multiple" size="11" style="height: 100%;">

														  <?php
															include('library/opendb.php');
														  $sql_b = "SELECT DISTINCT brand FROM ".$configValues['TBL_RWBRANDS'];  
														  $ret_b = pg_query($dbConnect, $sql_b);
  
														  while ($row_b = pg_fetch_row($ret_b)) {
															$row_brand = "'".$row_b[0]."'";
															echo "<option value=$row_brand>$row_b[0]</option>";
														  }
														  include('library/closedb.php');
															?>
														</select>
												  </div>
												  <div class="col-md-3 col-sm-3 col-xs-12">
														<div class="radio">
														  <label>
															<input type="radio" value="1" <?php echo $chk_in_1;?> name="radio_chkin"><?php echo $l_all_select_status;?>
														  </label>
														  <label>
															<input type="radio" value="2" name="radio_chkin"><?php echo $l_select_in;?>
														  </label>
														</div>
												  </div>
												</div>                        
											</div>
											<!-- /filters -->
                      <div class="form-group">
                      </div>
                      <div class="ln_solid"></div>
                    </form>
                  </div>
                </div>
              </div>
              
							<!-- Big Data Graphics -->

							<div class="row">
	              <div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2><?php echo $l_titlelinebigdata;?> <small><?php echo $datestart;?></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
	                  </div>
	                  <div class="row tile_count">
	                    <div class="col-md-3 col-sm-6 col-xs-9 tile_stats_count">
	                      <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_visitors_bd;?></span>
	                      <div id="devicebd" class="count">0</div>
	                    </div>
	                    <div class="col-md-3 col-sm-6 col-xs-9 tile_stats_count">
	                    </div>
	                    <div class="col-md-3 col-sm-6 col-xs-9 tile_stats_count">
	                      <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_visitors_bd_in;?></span>
	                      <div id="devicebdin" class="count green">0</div>
	                    </div>
	                    <div class="col-md-3 col-sm-6 col-xs-9 tile_stats_count">
	                      <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_visitors_bdvisits_in;?></span>
	                      <div id="devicebdqvin" class="count green">0</div>
	                      <div><span class="count_bottom"><i class="fa fa-clock-o"></i><?php echo $l_qualifiedavgtime;?></span></div>
	                      <span id="devicebdqvtin" class="count_bottom">0</span>
	                    </div>
	                  </div>
									</div>
								</div>
							</div>
							<div class="row">
                <!-- pie chart -->
	              <div class="col-md-6 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
			                <h2>Ratio <small><?php echo $l_visitors_bd_in;?></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="bigdata" style="height:350px;"></div>
	                  </div>
	                </div>
								</div>
                <!-- pie chart -->
	              <div class="col-md-6 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
			                <h2>Ratio <small><?php echo $l_visitors_bdvisits_in;?></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="bigdatavisits" style="height:350px;"></div>
	                  </div>
	                </div>
	              </div>								
							</div>            
							<!-- /Big Data Graphics -->
							
							<!-- Qualified visits-->
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
			            <div class="x_panel">
			              <div class="x_title">
			                <h2><?php echo $l_visits;?> <small><?php echo $datestart;?></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
			              </div>

			              <div class="row tile_count">
			                <div class="col-md-9 col-sm-9 col-xs-12 tile_stats_count">
			                  <span class="count_top"><i class="fa fa-bar-chart"></i><?php echo $l_total_acct;?> </span>
			                  <div id="totalacct" class="count">0</div>
			                </div>
										</div>
										<div class="row tile_count">
			                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
			                  <span class="count_top"><i class="fa fa-download"></i><?php echo $l_in;?> </span>
			                  <div id="in" class="count green">0</div>
			                  <div><span class="count_bottom"><i class="fa fa-clock-o"></i><?php echo $l_qualifiedavgtime;?></span></div>
			                  <span id="totaltimeinvisits" class="count_bottom"></span>
			                </div>
			                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
			                  <span class="count_top"><i class="fa fa-minus"></i><?php echo $l_limit;?> </span>
			                  <div id="limit" class="count blue">0</div>
			                  <div><span class="count_bottom"><i class="fa fa-clock-o"></i><?php echo $l_qualifiedavgtime;?></span></div>
			                  <span id="totaltimelimitvisits" class="count_bottom">0</span>
			                </div>
			                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
			                  <span class="count_top"><i class="fa fa-upload"></i><?php echo $l_out;?> </span>
			                  <div id="out" class="count red">0</div>
			                  <div><span class="count_bottom"><i class="fa fa-clock-o"></i><?php echo $l_qualifiedavgtime;?></span></div>
			                  <span id="totaltimeoutvisits" class="count_bottom">0</span>
			                </div>
			              </div>
			            </div>
			          </div>
							</div>
							
              <!-- pie chart -->
							<div class="row">
	              <div class="col-md-6 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
			                <h2>Ratio <small><?php echo $l_visits;?></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="graph_status" style="height:350px;"></div>
	                  </div>
	                </div>
	              </div>								
								<!-- /pie chart -->

								<!-- Brands -->
								<div class="col-md-6 col-sm-12 col-xs-12">
				          <div class="x_panel">
			              <div class="x_title">
			                <h2><?php echo $l_brands;?> <small></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
			              </div>
			              <div class="x_content">
			                <div id="devices" style="height:350px;"></div>                  
			              </div>
				          </div>
								</div>
							</div>							
							<!-- /Brands-->											
							
							<!-- /Qualified visits -->
							
							<!-- Graphics -->
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
				          <div class="x_panel">
			              <div class="x_title">
			                <h2><?php echo $l_titlelineactivity;?> <small></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
			              </div>
			              <div class="x_content">
			                <div id="echart_activity_h" style="height:350px;"></div>                  
			              </div>
				          </div>
								</div>
							</div>							
							<!-- /Graphics-->
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
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- ECharts -->
    <script src="../vendors/echarts/dist/echarts.min.js"></script>
		
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>


		<script>
			$( window ).load(function() {
								
                showClient();
				var countryid = '<?php echo $country_id?>';

			  $('#selCountry option[value="'+countryid+'"]').prop('selected', true);
			  var evt = document.createEvent("HTMLEvents");
			  evt.initEvent("change", false, true);
			  document.getElementById('selCountry').dispatchEvent(evt);
				
			});

			$("#selCountry").change(function() {
				showState();
			});
			document.getElementById("timeend").value = '<?php echo $currTime;?>'; 
				
    </script>
		
    <script>
		  function showClient() {

			$("#selClient").empty();
			$("#selClient").append("<option value='<?php echo $id_client;?>'><?php echo $c_name;?></option>");
		  }
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
						for (var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selState").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showCity();
				showOnlinePage();
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
						for (var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selCity").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showLocation();
				showSpot();
				showSensor();
				showOnlinePage();
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
						for (var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selLocation").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showSpot();
				showOnlinePage();
		  }			
    </script>
    <!-- /showState - City - Location -->

    <!-- /showSpot - Sensor -->
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
						for (var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selSpot").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showSensor();
				showOnlinePage();
		  }	
		</script>
			
	  <script>
		  function showSensor() {
	  
				var schemaid = $("#selClient").val();
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();
				var locationid = $("#selLocation").val();
				var spotid = $("#selSpot").val();
				
				$.ajax({
				  url: 'rest-api/settings/getSensor.php',
				  type: 'POST',
					data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid},
				  dataType: 'json',
				  success:function(response) {

						var len = response.length;

						$("#selSensor").empty();
						$("#selSensor").append("<option value='%'><?php echo $l_all_sensor;?></option>");
						for (var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selSensor").append("<option value='"+id+"'>"+name+"</option>");

						}
				  }
				});
				showOnlinePage();
		  }			
    </script>
    <!-- /showSpot - Sensor -->

    <!-- theme -->
    <script>
      var theme = {
          color: [
            '#26B99A', '#34495E', '#BDC3C7', '#009999', '#006699', 
						'#008060', '#669999', '#0099cc', '#6699cc', '#b3cccc'
          ],

          title: {
            itemGap: 8,
            textStyle: {
              fontWeight: 'normal',
              color: '#116798'
            }
          },

          dataRange: {
            color: ['#1f610a', '#97b58d']
          },

          toolbox: {
            color: ['#116798', '#116798', '#116798', '#116798']
          },

          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.5)',
            axisPointer: {
              type: 'line',
              lineStyle: {
                color: '#116798',
                type: 'dashed'
              },
              crossStyle: {
                color: '#116798'
              },
              shadowStyle: {
                color: 'rgba(200,200,200,0.3)'
              }
            }
          },

          dataZoom: {
            dataBackgroundColor: '#eee',
            fillerColor: 'rgba(64,136,41,0.2)',
            handleColor: '#116798'
          },
          grid: {
            borderWidth: 0
          },

          categoryAxis: {
            axisLine: {
              lineStyle: {
                color: '#116798'
              }
            },
            splitLine: {
              lineStyle: {
                color: ['#eee']
              }
            }
          },

          valueAxis: {
            axisLine: {
              lineStyle: {
                color: '#116798'
              }
            },
            splitArea: {
              show: true,
              areaStyle: {
                color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
              }
            },
            splitLine: {
              lineStyle: {
                color: ['#eee']
              }
            }
          },
          timeline: {
            lineStyle: {
              color: '#116798'
            },
            controlStyle: {
              normal: {color: '#116798'},
              emphasis: {color: '#116798'}
            }
          },

          k: {
            itemStyle: {
              normal: {
                color: '#68a54a',
                color0: '#a9cba2',
                lineStyle: {
                  width: 1,
                  color: '#116798',
                  color0: '#86b379'
                }
              }
            }
          },
          map: {
            itemStyle: {
              normal: {
                areaStyle: {
                  color: '#ddd'
                },
                label: {
                  textStyle: {
                    color: '#c12e34'
                  }
                }
              },
              emphasis: {
                areaStyle: {
                  color: '#99d2dd'
                },
                label: {
                  textStyle: {
                    color: '#c12e34'
                  }
                }
              }
            }
          },
          force: {
            itemStyle: {
              normal: {
                linkStyle: {
                  strokeColor: '#116798'
                }
              }
            }
          },
          chord: {
            padding: 4,
            itemStyle: {
              normal: {
                lineStyle: {
                  width: 1,
                  color: 'rgba(128, 128, 128, 0.5)'
                },
                chordStyle: {
                  lineStyle: {
                    width: 1,
                    color: 'rgba(128, 128, 128, 0.5)'
                  }
                }
              },
              emphasis: {
                lineStyle: {
                  width: 1,
                  color: 'rgba(128, 128, 128, 0.5)'
                },
                chordStyle: {
                  lineStyle: {
                    width: 1,
                    color: 'rgba(128, 128, 128, 0.5)'
                  }
                }
              }
            }
          },
          gauge: {
            startAngle: 225,
            endAngle: -45,
            axisLine: {
              show: true,
              lineStyle: {
                color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#116798']],
                width: 8
              }
            },
            axisTick: {
              splitNumber: 10,
              length: 12,
              lineStyle: {
                color: 'auto'
              }
            },
            axisLabel: {
              textStyle: {
                color: 'auto'
              }
            },
            splitLine: {
              length: 18,
              lineStyle: {
                color: 'auto'
            }
          },
          pointer: {
            length: '90%',
            color: 'auto'
          },
          title: {
            textStyle: {
              color: '#333'
            }
          },
          detail: {
            textStyle: {
              color: 'auto'
            }
          }
        },
        textStyle: {
          fontFamily: 'Arial, Verdana, sans-serif'
        }
      };
    </script>  
    <!-- theme -->
		
		<!-- eChart BigData -->
		<script>
			function drawChartbigdata(bd, bdin) {
				option = {
				    tooltip: {
				        trigger: 'item',
				        formatter: "{a} <br/>{b}: {c} ({d}%)"
				    },
				    legend: {
				        orient: 'vertical',
				        x: 'left',
				        data:['<?php echo $l_visitors_bd;?>','<?php echo $l_in;?>']
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
				                {value:bdin, name:'<?php echo $l_in;?>'},
												{value:bd, name:'<?php echo $l_devices;?>'}
				            ]
				        }
				    ]
				};

				var bdchart = document.getElementById('bigdata');
				var mybdChart = echarts.init(bdchart, theme);
				mybdChart.setOption(option);
				
			}
		</script>
		
		<script>
			function drawChartbigdataqvin(bd, bdqvin) {
				option = {
				    tooltip: {
				        trigger: 'item',
				        formatter: "{a} <br/>{b}: {c} ({d}%)"
				    },
				    legend: {
				        orient: 'vertical',
				        x: 'left',
				        data:['<?php echo $l_visitors_bd;?>','<?php echo $l_in;?>']
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
												{value:bdqvin, name:'<?php echo $l_in;?>'},
												{value:bd, name:'<?php echo $l_devices;?>'}										
				            ]
				        }
				    ]
				};
				var bdinchart = document.getElementById('bigdatavisits');
				var mybdinChart = echarts.init(bdinchart, theme);
				mybdinChart.setOption(option);
			}
		</script>
		
		<script>
			function drawChartgraphstatus(d_in, d_limit, d_out) {
				var option = {
				    title : {
				        text: '',
				        subtext: '',
				        x:''
				    },
				    tooltip : {
				        trigger: 'item',
				        formatter: "{a} <br/>{b} : {c} ({d}%)"
				    },
				    legend: {
				        x : 'center',
				        y : 'bottom',
				        data:['<?php echo $l_in;?>','<?php echo $l_limit;?>','<?php echo $l_out;?>']
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
				    calculable : true,
				    series : [
				        {
				            name:'<?php echo $l_devices;?>',
				            type:'pie',
				            radius : [30, 110],
				            center : ['50%', '50%'],
				            roseType : 'area',
				            data:[
				                {value:d_in, name:'<?php echo $l_in;?>'},
				                {value:d_limit, name:'<?php echo $l_limit;?>'},
				                {value:d_out, name:'<?php echo $l_out;?>'}
				            ]
				        }
				    ]
				};
				var gschart = document.getElementById('graph_status');
				var mygsChart = echarts.init(gschart, theme);
				mygsChart.setOption(option);
			}
		</script>
		<!-- /eChadt -->
		
    <!-- Line Graph Activity HOUR -->
		<script>
			function drawLineChartgraph(l_in, l_limit, l_out) {

				var option = {
		      title: {
		        text: '<?php echo $l_checkdate_range_s." ".$l_chk_graph_hour;?>',
		        subtext: '<?php echo $datestart;?>'
		      },
		      tooltip: {
		        trigger: 'axis'
		      },
		      legend: {
		        x: 220,
		        y: 40,
		        data: ['<?php echo $l_out;?>', '<?php echo $l_limit;?>', '<?php echo $l_in;?>']
		      },
		      toolbox: {
		        show: true,
		        feature: {
		          magicType: {
		            show: true,
		            title: {
		              line: 'Line',
		              bar: 'Bar'
		            },
		            type: ['line', 'bar']
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
		      calculable: true,
		      xAxis: [{
		        type: 'category',
						name: '<?php echo $l_hours;?>',
		        boundaryGap: false,
		        data: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
		      }],
		      yAxis: [{
		        type: 'value',
						name: '<?php echo $l_devices;?>'
		      }],
		      series: [{
		        name: '<?php echo $l_in;?>',
		        type: 'line',
		        smooth: true,
		        itemStyle: {
		          normal: {
		            areaStyle: {
		              type: 'default'
		            }
		          }
		        },
		        data: [
								l_in[0],l_in[1],l_in[2],l_in[3],l_in[4],l_in[5],
								l_in[6],l_in[7],l_in[8],l_in[9],l_in[10],l_in[11],
								l_in[12],l_in[13],l_in[14],l_in[15],l_in[16],l_in[17],
								l_in[18],l_in[19],l_in[20],l_in[21],l_in[22],l_in[23]
						],
            markLine : {
                data : [
                    {type : 'average', name: 'Avg'}
                ]
            }						
		      }, {
		        name: '<?php echo $l_limit;?>',
		        type: 'line',
		        smooth: true,
		        itemStyle: {
		          normal: {
		            areaStyle: {
		              type: 'default'
		            }
		          }
		        },
		        data: [
								l_limit[0],l_limit[1],l_limit[2],l_limit[3],l_limit[4],l_limit[5],
								l_limit[6],l_limit[7],l_limit[8],l_limit[9],l_limit[10],l_limit[11],
								l_limit[12],l_limit[13],l_limit[14],l_limit[15],l_limit[16],l_limit[17],
								l_limit[18],l_limit[19],l_limit[20],l_limit[21],l_limit[22],l_limit[23]
						],
            markLine : {
                data : [
                    {type : 'average', name: 'Avg'}
                ]
            }						
		      }, {
		        name: '<?php echo $l_out;?>',
		        type: 'line',
		        smooth: true,
		        itemStyle: {
		          normal: {
		            areaStyle: {
		              type: 'default'
		            }
		          }
		        },
		        data: [
								l_out[0],l_out[1],l_out[2],l_out[3],l_out[4],l_out[5],
								l_out[6],l_out[7],l_out[8],l_out[9],l_out[10],l_out[11],
								l_out[12],l_out[13],l_out[14],l_out[15],l_out[16],l_out[17],
								l_out[18],l_out[19],l_out[20],l_out[21],l_out[22],l_out[23]
						],
            markLine : {
                data : [
                    {type : 'average', name: 'Avg'}
                ]
            }						
		      }]
		    };					
				var linechart = document.getElementById('echart_activity_h');
				var echartLine_act_h = echarts.init(linechart, theme);
		    echartLine_act_h.setOption(option);
			}
		</script>
    <!-- /Line Graph Activity HOUR -->
		
    <!-- Doughnut Chart -->
		<script>
			function drawDoughnutChartdevices(brands, q) {				
				var option = {
				    title : {
				        text: '',
				        subtext: '',
				        x:''
				    },
				    tooltip : {
				        trigger: 'item',
				        formatter: "{a} <br/>{b} : {c} ({d}%)"
				    },
				    legend: {
				        orient: '',
				        left: '',
				        data: []
				    },
			      toolbox: {
			        show: true,
			        feature: {
			          magicType: {
			            show: true,
			            title: {
									}
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
				    series : [
				        {
				            name: '<?php echo $l_brand;?>',
				            type: 'pie',
				            radius : '55%',
				            center: ['50%', '60%'],
										data:[
				                {value:q[0], name:brands[0]},
				                {value:q[1], name:brands[1]},
				                {value:q[2], name:brands[2]},
				                {value:q[3], name:brands[3]},
				                {value:q[4], name:brands[4]},
				                {value:q[5], name:brands[5]},
				                {value:q[6], name:brands[6]},
				                {value:q[7], name:brands[7]},
				                {value:q[8], name:brands[8]},
				                {value:q[9], name:brands[9]}
				            ],
				            itemStyle: {
				                emphasis: {
				                    shadowBlur: 10,
				                    shadowOffsetX: 0,
				                    shadowColor: 'rgba(0, 0, 0, 0.5)'
				                }
				            }
				        }
				    ]
				};
				var dchart = document.getElementById('devices');
				var mydChart = echarts.init(dchart, theme);
				mydChart.setOption(option);
			}
		</script>
    <!-- /Doughnut Chart -->
		
		<script>
			function showOnlinePage() {
		
				NProgress.start();

				var schemaid = $("#selClient").val();
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();
				var locationid = $("#selLocation").val();
				var spotid = $("#selSpot").val();
				var sensorname = $("#selSensor").val();
				var statusid = $("#selStatus").val();
				var radiochkin = $('input[name=radio_chkin]:checked', '#online_select_form').val();
				var date_s = $("#datestart").val();;
				var time_s = $("#timestart").val();
				var time_e = $("#timeend").val();
				var operatorid = <?php echo $operator_profile_id;?>;
				if (operatorid != 1) operatorid = <?php echo $operator_id;?>;
						
				var brandlist = 0;
				if (radiochkin != 1) {
					b_list = $('select#brand_list').val();
					var brandlist = b_list.toString();
				}	
		
				$.ajax({
				  url: 'rest-api/dashboard/getOnline.php',
				  type: 'POST',
					data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid,
					sensor_name:sensorname, idstatus:statusid, datestart:date_s, timestart:time_s, timeend:time_e, operator_id:operatorid,
					brand_list:brandlist},
				  dataType: 'json',
				  success:function(response) {

	          console.log(response);						
						var len = response.length;
						var bd = 0;
						var bdin = 0;
						var bdqvin = 0;
						var totalacct = 0;
						var total_i = 0;
						var total_l = 0;
						var total_o = 0;
						var time_i = 0;
						var time_l = 0;
						var time_o = 0;
						var marca = [];
						var cant = [];
						var g_in = [];
						var g_limit = [];
						var g_out = [];
						
						for (var z = 0; z<24; z++) {
							g_in[z] = 0;
							g_limit[z] = 0;
							g_out[z] = 0;							
						}
						
						for (var i = 0; i<len; i++) {
							
							var object = response[i];
							for (property in object) {
				        var value = object[property];
								if (value == 'bigdata') {
									bd = object['data'];
									document.getElementById('devicebd').innerHTML = Intl.NumberFormat().format(bd);
								}
								if (value == 'bigdatain') {
									bdin = object['data'];
									document.getElementById('devicebdin').innerHTML = Intl.NumberFormat().format(bdin);
									drawChartbigdata(bd, bdin);
								}
								if (value == 'bigdataqvin') {
									bdqvin = object['data'][0].total;
									document.getElementById('devicebdqvin').innerHTML = Intl.NumberFormat().format(bdqvin);
									document.getElementById('devicebdqvtin').innerHTML = object['data'][0].time;
									drawChartbigdataqvin(bd, bdqvin);
								}
								if (value == 'activity') {
									for (var x = 0; x<object['data'].length; x++) {
										var pos = object['data'][x].pos;
										switch (pos) {
											case "3":
												total_i = object['data'][x].total;
												time_i = object['data'][x].time;
												break;
											case "2":
												total_l = object['data'][x].total;
												time_l = object['data'][x].time;
												break;
											case "1":
												total_o = object['data'][x].total;
												time_o = object['data'][x].time;
												break;
										}
									}
									totalacct = parseInt(total_i) + parseInt(total_l) + parseInt(total_o);
									document.getElementById('totalacct').innerHTML = Intl.NumberFormat().format(totalacct);
									document.getElementById('in').innerHTML = Intl.NumberFormat().format(total_i);
									document.getElementById('totaltimeinvisits').innerHTML = time_i;
									document.getElementById('limit').innerHTML = Intl.NumberFormat().format(total_l);
									document.getElementById('totaltimelimitvisits').innerHTML = time_l;
									document.getElementById('out').innerHTML = Intl.NumberFormat().format(total_o);
									document.getElementById('totaltimeoutvisits').innerHTML = time_o;
									drawChartgraphstatus(total_i, total_l, total_o);
								}
								if (value == 'brand') {
									for (var x = 0; x<object['data'].length; x++) {
										marca[x] = object['data'][x].brand;
										cant[x] = object['data'][x].cant;
									}
									drawDoughnutChartdevices(marca, cant);
								}
								if (value == 'graph') {
									var day_part_ini = "";
									var pos = "";
									for (var x = 0; x<object['data'].length; x++) {
										pos = object['data'][x].pos;
										var day_part_act = object['data'][x].day_part;
										if (day_part_ini != day_part_act) {
											day_part_ini = object['data'][x].day_part;
										}
										switch (pos) {
											case "3":
												g_in[day_part_act] = object['data'][x].in;
												break;
											case "2":
												g_limit[day_part_act] = object['data'][x].limit;
												break;
											case "1":
												g_out[day_part_act] = object['data'][x].out;
												break;
										}
									}
									drawLineChartgraph(g_in, g_limit, g_out);
								}
					    }
						}
						NProgress.done();
				  }
				});
			}
	
		</script>

		<script>
			function showTimeEnd(time) {
				document.getElementById("timeend").value = time; 
			} 

			function objTimer() {

				ActualDateTime = new Date()
				Actualhour = ActualDateTime.getHours()
				Actualminute = ActualDateTime.getMinutes()
				Actualsecond = ActualDateTime.getSeconds()

				var strTime = "";
				h = '0' + Actualhour;
				m = '0' + Actualminute;
				s = '0' + Actualsecond; 
				strTime += h.substring(h.length - 2, h.length) + ':' + m.substring(m.length - 2, m.length) + ':'+ s.substring(s.length - 2, s.length); 

				var checksec = (Actualsecond / 30)
				if (checksec % 1 == 0) {
					showTimeEnd(strTime); 
					showOnlinePage();
				} 
			} 

			setInterval(objTimer, 1000);
			objTimer();
			
		</script>
  </body>
</html>
