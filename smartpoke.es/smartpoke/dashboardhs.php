<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_dashboard3';

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
	$show_access = opt_buttons($page, $operator_profile_id, 'show_btn');

  $datestart = date("Y-m-d", strtotime($currDate));
  if (isset($_POST['datestart'])) $datestart = $_POST['datestart'];
  $datestartspan = date("d M Y", strtotime($datestart));

  $dateend = date("Y-m-d", strtotime($currDate));
  if (isset($_POST['dateend'])) $dateend = $_POST['dateend'];
	$dateendspan = date("d M Y", strtotime($dateend));

  $id_client = $client_id;
  if (isset($_POST['id_client'])) {
    $id_client = $_POST['id_client'];
  }

  $country_id = '35';
  $state_id = '%';    
  if (isset($_POST['state_id'])) {
    $state_id = $_POST['state_id'];
  }
	
  $city_id = '%';
  if (isset($_POST['city_id'])) {
    $city_id = $_POST['city_id'];
  }

	$location_id = '%';
  if (isset($_POST['location_id'])) {
    $location_id = $_POST['location_id'];
  }

  $spot_id = '%';
  if (isset($_POST['hotspot_id'])) {
    $spot_id = $_POST['hotspot_id'];
  }

  $radio_chkgraph = '1';
  if (isset($_POST['radio_chkgraph'])) {
    $radio_chkgraph = $_POST['radio_chkgraph'];
  }
  switch($radio_chkgraph) {
    case "1":
      $chk_grap_1 = 'checked';
      $chk_grap_2 = '';
      $chk_grap_3 = '';
      $chk_grap_4 = '';
      $chk_grap_5 = '';
      break;
    case "2":
      $chk_grap_1 = '';
      $chk_grap_2 = 'checked';
      $chk_grap_3 = '';
      $chk_grap_4 = '';
      $chk_grap_5 = '';
      break;
    case "3":
      $chk_grap_1 = '';
      $chk_grap_2 = '';
      $chk_grap_3 = 'checked';
      $chk_grap_4 = '';
      $chk_grap_5 = '';
      break;
    case "4":
      $chk_grap_1 = '';
      $chk_grap_2 = '';
      $chk_grap_3 = '';
      $chk_grap_4 = 'checked';
      $chk_grap_5 = '';
      break;
    case "5":
      $chk_grap_1 = '';
      $chk_grap_2 = '';
      $chk_grap_3 = '';
      $chk_grap_4 = '';
      $chk_grap_5 = 'checked';
      break;    
  }

  if (isset($_POST['button'])) {
    $button = $_POST['button'];
  }
	
	if ($button == 'submit') {
		echo '<script type="text/javascript">
		showHotSpot();
		</script>';
	}
	
	if ($button == 'cancel') {

		$radio_checkdate = $_SESSION['radio_checkdate'];
		$checked_1 = 'checked';

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
		$hotspot = '%';  	
	  $radio_chkgraph = '1';
    $chk_grap_1 = 'checked';
    $chk_grap_2 = '';
    $chk_grap_3 = '';
    $chk_grap_4 = '';
    $chk_grap_5 = '';	
		$status_id = '%';
	}

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
                <h3>HotSpot / Connectivity</h3>
              </div>
						</div>

            <div class="clearfix"></div>
            <div class='row'>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_query;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="hotspot_select_form" class="form-horizontal form-label-left" method="POST" action='<?php echo $loginpath;?>'>

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
	                        <input type="hidden" name="datestart" id="datestart" value='<?php echo $datestart;?>'/>
	                        <input type="hidden" name="dateend" id="dateend" value='<?php echo $dateend;?>'/>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_clients;?> <span class="required">*</span></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <select id="selClient" class="form-control" name="id_client" required="required" onChange="showHotSpot()">
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
			                      <select id="selCity" class="form-control" disabled name="city_id" onChange="showLocation()">
				                      <option value="%"> <?php echo $l_all_cities;?> </option>

		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_location;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selLocation" class="form-control" disabled name="location_id" onChange="showHotSpot()">
				                      <option value="%"> <?php echo $l_all_locations;?> </option>

		                        </select>
		                      </div>
		                    </div>

											  <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_hotspot ?></label>
													<div class="col-md-9 col-sm-9 col-xs-12">
													  <select id="selHotSpot" class="form-control" <?php echo $show_access;?> name="hotspot_id">
															<option value="%"><?php echo $l_all_hotspot ?></option>
													
													  </select>
													</div>
											  </div>				  											  
	                      <div class="form-group">
	                        <div class="col-md-12 col-sm-12 col-xs-12">
	                          <div class="radio">
			                        <label>
				                        <input type="radio" value="1" <?php echo $chk_grap_1;?> name="radio_chkgraph"><?php echo $l_chk_graph_date ?>
			                        </label>
			                        <label>
				                        <input type="radio" value="2" <?php echo $chk_grap_2;?> name="radio_chkgraph"><?php echo $l_chk_graph_weekday ?>
			                        </label>
			                        <label>
				                        <input type="radio" value="3" <?php echo $chk_grap_3;?> name="radio_chkgraph"><?php echo $l_chk_graph_weekly ?>
			                        </label>
			                        <label>
				                        <input type="radio" value="4" <?php echo $chk_grap_4;?> name="radio_chkgraph"><?php echo $l_chk_graph_month ?>
			                        </label>
			                        <label>
				                        <input type="radio" value="5" <?php echo $chk_grap_5;?> name="radio_chkgraph"><?php echo $l_chk_graph_year ?>
			                        </label>
			                      </div>
			                    </div>
												</div>
											</div>	
				              <!-- / select -->				              
                      <div class="form-group">
                      </div>
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button id="btnCancel" type="submit" name="button" class="btn btn-primary" value="cancel" onclick="resetForm()"><?php echo $l_cancel;?></button>
                          <button id="btnSubmit" type="submit" name="button" class="btn btn-success" <?php echo $show_access;?> value="submit" ><?php echo $l_search;?></button>
                        </div>
                      </div>                      
                    </form>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>  
            <div class="row">
              <!-- top tiles -->
              <div class="row tile_count">
                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                  <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_totalusers;?></span>
                  <div id="totalusers" class="count">0</div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                  <span class="count_top"><i class="fa fa-user"></i> <?php echo $l_newusers;?> </span>
                  <div id="totalnewusers" class="count">0</div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                  <span class="count_top"><i class="fa fa-user"></i> <?php echo $l_online;?></span>
                  <div id="totalonline" class="count">0</div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count"></div>
                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                  <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_hits;?></span>
                  <div id="totalhits" class="count">0</div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                  <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_nologged;?></span>
                  <div id="totalnologged" class="count">0</div>
                </div>
              </div>
            </div>
            <div class="row">
	            <div class="col-md-12 col-sm-12 col-xs-12">
		            <div class="col-md-4 col-sm-4 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2><?php echo $l_busiestdayusers;?></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="echart_busiestday_users" style="height:200px;"></div>
	                  </div>
	                </div>
	              </div>
	              <div class="col-md-4 col-sm-4 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2><?php echo $l_busiestday_hs;?></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="echart_busiestday_hotspot" style="height:200px;"></div>
	                  </div>
	                </div>
	              </div>
	              <div class="col-md-4 col-sm-4 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2><?php echo $l_busiesttime_hs;?></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="echart_busiesttime_hotspot" style="height:200px;"></div>
	                  </div>
	                </div>
								</div>
              </div>
						</div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                  <div class="x_content">
                    <div class="row">
                      <div class="animated flipInY col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-calendar-o"></i></div>
                          <div id="bwupload" class="count">0</div>
                          <h3 id="l_weekday_bwu"></h3>
                          <p><?php echo $l_busiestday_upload;?></p>
                        </div>
                      </div>
                      <div class="animated flipInY col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-calendar-o"></i></div>
                          <div id="bwdownload" class="count">0</div>
                          <h3 id="l_weekday_bwd"></h3>
                          <p><?php echo $l_busiestday_download;?></p>
                        </div>
                      </div>
                      <div class="animated flipInY col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-calendar-o"></i></div>
                          <div id="bwtotal" class="count">0</div>
                          <h3 id="l_weekday_bwt"></h3>
                          <p><?php echo $l_busiestday_bandwidth;?></p>
                        </div>
                      </div>
                      <div class="animated flipInY col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-clock-o"></i></div>
                          <div id="bwtotaltime" class="count">0</div>
                          <h3 id="l_weekday_time"></h3>
                          <p><?php echo $l_busiesttime_bandwidth;?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /top tiles -->

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_titlelinebandwidth;?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="echart_bandwidth" style="height:350px;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
	            <div class="col-md-12 col-sm-12 col-xs-12">
		            <div class="col-md-6 col-sm-6 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2><?php echo $l_titlelineconnectivity;?></h2>
		                    <div class="clearfix"></div>
		                  </div>
		                  <div class="x_content">
		                    <div id="echart_userhits" style="height:350px;"></div>
		                  </div>
		                </div>
		              </div>
	              <div class="col-md-6 col-sm-6 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2><?php echo $l_timeconnect;?></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="echart_timeconnect" style="height:370px;"></div>
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
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
    <!-- ECharts -->
    <script src="../vendors/echarts/dist/echarts.min.js"></script>

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
				showHotSpot();
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
				showHotSpot();
		  }			
    </script>
    <!-- /showState - City - Location -->

    <!-- showHotSpot -->
    <script>
		  function showHotSpot() {
	  
				var schemaid = $("#selClient").val();
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();
				var locationid = $("#selLocation").val();

				$.ajax({
					url: 'rest-api/hotspot/getHotSpot.php',
					type: 'POST',
					data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid},
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selHotSpot").empty();
						$("#selHotSpot").append("<option value='%'><?php echo $l_all_hotspot;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selHotSpot").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
		  }	
		</script>
    <!-- /showHoSpot -->

			
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
		
		<!-- Busy Day Users -->
		<script>
			function drawBarChart_busiestday_users(l_bd_users) {
			
				var option = {
	        tooltip: {
	          trigger: 'axis'
	        },
	        legend: {
	          x: 100,
	          data: ['']
	        },
	        toolbox: {
	          show: true,
	          feature: {
	            saveAsImage: {
	              show: true,
	              title: 'Save Image'
	            }
	          }
	        },
	        calculable: true,
	        xAxis: [{
	          type: 'value',
	          boundaryGap: [0, 1]
	        }],
			    xAxis: {
			        type: 'category',
			        data: ['<?php echo $l_Mo;?>', '<?php echo $l_Tu;?>', '<?php echo $l_We;?>', 
					'<?php echo $l_Th;?>', '<?php echo $l_Fr;?>', '<?php echo $l_Sa;?>', '<?php echo $l_Su;?>']
			    },
			    yAxis: {
			        type: 'value'
			    },
			    series: [{
	          name: '<?php echo $l_users;?>',
	          type: 'bar',
		        data: [
							l_bd_users[1],l_bd_users[2],l_bd_users[3],l_bd_users[4],l_bd_users[5],l_bd_users[6],
							l_bd_users[7]
						]
			    }]
				};
				var barchart_bdu = document.getElementById('echart_busiestday_users');
				var echartBar_bdu = echarts.init(barchart_bdu, theme);
		    echartBar_bdu.setOption(option);
			}
		</script>
		<!-- /Busy Day Users -->

		<!-- Busy Day HotSpot -->
		<script>
			function drawBarChart_busiestday_hotspot(l_bd_hotspot) {
			
				var option = {
	        tooltip: {
	          trigger: 'axis'
	        },
	        legend: {
	          x: 100,
	          data: ['']
	        },
	        toolbox: {
	          show: true,
	          feature: {
	            saveAsImage: {
	              show: true,
	              title: 'Save Image'
	            }
	          }
	        },
	        calculable: true,
	        xAxis: [{
	          type: 'value',
	          boundaryGap: [0, 1]
	        }],
			    xAxis: {
			        type: 'category',
			        data: ['<?php echo $l_Mo;?>', '<?php echo $l_Tu;?>', '<?php echo $l_We;?>', 
					'<?php echo $l_Th;?>', '<?php echo $l_Fr;?>', '<?php echo $l_Sa;?>', '<?php echo $l_Su;?>']
			    },
			    yAxis: {
			        type: 'value'
			    },
			    series: [{
	          name: '<?php echo $l_connections;?>',
	          type: 'bar',
		        data: [
							l_bd_hotspot[1],l_bd_hotspot[2],l_bd_hotspot[3],l_bd_hotspot[4],l_bd_hotspot[5],l_bd_hotspot[6],
							l_bd_hotspot[7]
						]
			    }]
				};
				var barchart_bdhs = document.getElementById('echart_busiestday_hotspot');
				var echartBar_bdhs = echarts.init(barchart_bdhs);
		    echartBar_bdhs.setOption(option);
			}
		</script>
		<!-- /Busy Day HotSpot -->

		<!-- Busy Day HotSpot -->
		<script>
			function drawBarChart_busiesttime_hotspot(l_bt_hotspot) {
			
				var option = {
	        tooltip: {
	          trigger: 'axis'
	        },
	        legend: {
	          x: 100,
	          data: ['']
	        },
	        toolbox: {
	          show: true,
	          feature: {
	            saveAsImage: {
	              show: true,
	              title: 'Save Image'
	            }
	          }
	        },
	        calculable: true,
	        xAxis: [{
	          type: 'value',
	          boundaryGap: [0, 1]
	        }],
			    xAxis: {
			        type: 'category',
			        data: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
			    },
			    yAxis: {
			        type: 'value'
			    },
			    series: [{
	          name: '<?php echo $l_users;?>',
	          type: 'line',
		        data: [									
								l_bt_hotspot[0],l_bt_hotspot[1],l_bt_hotspot[2],l_bt_hotspot[3],l_bt_hotspot[4],l_bt_hotspot[5],
								l_bt_hotspot[6],l_bt_hotspot[7],l_bt_hotspot[8],l_bt_hotspot[9],l_bt_hotspot[10],l_bt_hotspot[11],
								l_bt_hotspot[12],l_bt_hotspot[13],l_bt_hotspot[14],l_bt_hotspot[15],l_bt_hotspot[16],l_bt_hotspot[17],
								l_bt_hotspot[18],l_bt_hotspot[19],l_bt_hotspot[20],l_bt_hotspot[21],l_bt_hotspot[22],l_bt_hotspot[23]
						]
			    }]
				};
				var barchart_bdhs = document.getElementById('echart_busiesttime_hotspot');
				var echartBar_bdhs = echarts.init(barchart_bdhs, theme);
		    echartBar_bdhs.setOption(option);
			}
		</script>
		<!-- /Busy Day HotSpot -->

    <!-- Line Graph Bandwidth -->
		<script>
			function drawLineChartgraph_bw(l_up, l_down, l_bandwidth) {

				var radiochkgraph = $("input[name=radio_chkgraph]:checked", "#hotspot_select_form").val();
								
				switch (radiochkgraph) {
					case "1":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_date;?>'
						var xaxis = '<?php echo $l_chk_graph_date;?>';
						var data_axis = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
						var data_up = [
									l_up[1],l_up[2],l_up[3],l_up[4],l_up[5],
									l_up[6],l_up[7],l_up[8],l_up[9],l_up[10],l_up[11],
									l_up[12],l_up[13],l_up[14],l_up[15],l_up[16],l_up[17],
									l_up[18],l_up[19],l_up[20],l_up[21],l_up[22],l_up[23],
									l_up[24],l_up[25],l_up[26],l_up[27],l_up[28],l_up[29],
									l_up[30],l_up[31]
							];
						var data_down = [
									l_down[1],l_down[2],l_down[3],l_down[4],l_down[5],
									l_down[6],l_down[7],l_down[8],l_down[9],l_down[10],l_down[11],
									l_down[12],l_down[13],l_down[14],l_down[15],l_down[16],l_down[17],
									l_down[18],l_down[19],l_down[20],l_down[21],l_down[22],l_down[23],
									l_down[24],l_down[25],l_down[26],l_down[27],l_down[28],l_down[29],
									l_down[30],l_down[31]
							];
						var data_bw = [
									l_bandwidth[1],l_bandwidth[2],l_bandwidth[3],l_bandwidth[4],l_bandwidth[5],
									l_bandwidth[6],l_bandwidth[7],l_bandwidth[8],l_bandwidth[9],l_bandwidth[10],l_bandwidth[11],
									l_bandwidth[12],l_bandwidth[13],l_bandwidth[14],l_bandwidth[15],l_bandwidth[16],l_bandwidth[17],
									l_bandwidth[18],l_bandwidth[19],l_bandwidth[20],l_bandwidth[21],l_bandwidth[22],l_bandwidth[23],
									l_bandwidth[24],l_bandwidth[25],l_bandwidth[26],l_bandwidth[27],l_bandwidth[28],l_bandwidth[29],
									l_bandwidth[30],l_bandwidth[31]
							];
						break;
					case "2":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_weekday;?>'
						var xaxis = '<?php echo $l_chk_graph_weekday;?>';
						var data_axis = ['<?php echo $l_Mo;?>', '<?php echo $l_Tu;?>', '<?php echo $l_We;?>', 
						'<?php echo $l_Th;?>', '<?php echo $l_Fr;?>', '<?php echo $l_Sa;?>', '<?php echo $l_Su;?>']
						var data_up = [
									l_up[1],l_up[2],l_up[3],l_up[4],l_up[5],l_up[6],l_up[7]
							];
						var data_down = [
									l_down[1],l_down[2],l_down[3],l_down[4],l_down[5],l_down[6],l_down[7]
							];
						var data_bw = [
									l_bandwidth[1],l_bandwidth[2],l_bandwidth[3],l_bandwidth[4],l_bandwidth[5],
									l_bandwidth[6],l_bandwidth[7]
							];
						break;
					case "3":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_weekly;?>'
						var xaxis = '<?php echo $l_chk_graph_weekly;?>';
						var data_axis = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,
							27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53];
						var data_up = [
									l_up[1],l_up[2],l_up[3],l_up[4],l_up[5],
									l_up[6],l_up[7],l_up[8],l_up[9],l_up[10],l_up[11],
									l_up[12],l_up[13],l_up[14],l_up[15],l_up[16],l_up[17],
									l_up[18],l_up[19],l_up[20],l_up[21],l_up[22],l_up[23],
									l_up[24],l_up[25],l_up[26],l_up[27],l_up[28],l_up[29],
									l_up[30],l_up[31],l_up[32],l_up[33],l_up[34],l_up[35],
									l_up[36],l_up[37],l_up[38],l_up[39],l_up[40],l_up[41],
									l_up[42],l_up[43],l_up[44],l_up[45],l_up[46],l_up[47],
									l_up[48],l_up[49],l_up[50],l_up[51],l_up[52],l_up[53]
							];
						var data_down = [
									l_down[1],l_down[2],l_down[3],l_down[4],l_down[5],
									l_down[6],l_down[7],l_down[8],l_down[9],l_down[10],l_down[11],
									l_down[12],l_down[13],l_down[14],l_down[15],l_down[16],l_down[17],
									l_down[18],l_down[19],l_down[20],l_down[21],l_down[22],l_down[23],
									l_down[24],l_down[25],l_down[26],l_down[27],l_down[28],l_down[29],
									l_down[30],l_down[31],l_down[32],l_down[33],l_down[34],l_down[35],
									l_down[36],l_down[37],l_down[38],l_down[39],l_down[40],l_down[41],
									l_down[42],l_down[43],l_down[44],l_down[45],l_down[46],l_down[47],
									l_down[48],l_down[49],l_down[50],l_down[51],l_down[52],l_down[53]
							];
						var data_bw = [
									l_bandwidth[1],l_bandwidth[2],l_bandwidth[3],l_bandwidth[4],l_bandwidth[5],
									l_bandwidth[6],l_bandwidth[7],l_bandwidth[8],l_bandwidth[9],l_bandwidth[10],l_bandwidth[11],
									l_bandwidth[12],l_bandwidth[13],l_bandwidth[14],l_bandwidth[15],l_bandwidth[16],l_bandwidth[17],
									l_bandwidth[18],l_bandwidth[19],l_bandwidth[20],l_bandwidth[21],l_bandwidth[22],l_bandwidth[23],
									l_bandwidth[24],l_bandwidth[25],l_bandwidth[26],l_bandwidth[27],l_bandwidth[28],l_bandwidth[29],
									l_bandwidth[30],l_bandwidth[31],l_bandwidth[32],l_bandwidth[33],l_bandwidth[34],l_bandwidth[35],
									l_bandwidth[36],l_bandwidth[37],l_bandwidth[38],l_bandwidth[39],l_bandwidth[40],l_bandwidth[41],
									l_bandwidth[42],l_bandwidth[43],l_bandwidth[44],l_bandwidth[45],l_bandwidth[46],l_bandwidth[47],
									l_bandwidth[48],l_bandwidth[49],l_bandwidth[50],l_bandwidth[51],l_bandwidth[52],l_bandwidth[53]
							];
						break;
					case "4":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_month;?>'
						var xaxis = '<?php echo $l_chk_graph_month;?>';
						var data_axis = ['<?php echo $l_January;?>', '<?php echo $l_February;?>', '<?php echo $l_March;?>', '<?php echo $l_April;?>', '<?php echo $l_May;?>', '<?php echo $l_June;?>', '<?php echo $l_July;?>', '<?php echo $l_August;?>', '<?php echo $l_September;?>', '<?php echo $l_October;?>', '<?php echo $l_November;?>', '<?php echo $l_December;?>' ]
						var data_up = [
									l_up[1],l_up[2],l_up[3],l_up[4],l_up[5],
									l_up[6],l_up[7],l_up[8],l_up[9],l_up[10],l_up[11],l_up[12]
							];
						var data_down = [
									l_down[1],l_down[2],l_down[3],l_down[4],l_down[5],
									l_down[6],l_down[7],l_down[8],l_down[9],l_down[10],l_down[11],l_down[12]
							];
						var data_bw = [
									l_bandwidth[1],l_bandwidth[2],l_bandwidth[3],l_bandwidth[4],l_bandwidth[5],
									l_bandwidth[6],l_bandwidth[7],l_bandwidth[8],l_bandwidth[9],l_bandwidth[10],l_bandwidth[11],
									l_bandwidth[12]
							];
						break;
					case "5":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_year;?>'
						var xaxis = '<?php echo $l_chk_graph_year;?>';
						var d = new Date();
						var n = d.getFullYear();
						var data_axis = [n+1,n,n-1,n-2];
						var data_up = [
									l_up[n+1],l_up[n],l_up[n-1],l_up[n-2]
							];
						var data_down = [
									l_down[n+1],l_down[n],l_down[n-1],l_down[n-2]
							];
						var data_bw = [
									l_bandwidth[n+1],l_bandwidth[n],l_bandwidth[n-1],l_bandwidth[n-2]
							];
						break;									
				}
				
				var option = {
			    title : {
			        text: title,
			        subtext: ''
			    },
			    tooltip : {
			        trigger: 'axis'
			    },
			    legend: {
			        data:['<?php echo $l_upload;?>', '<?php echo $l_download;?>', '<?php echo $l_bandwidth;?>']
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
			    calculable : true,
			    xAxis : [
			        {
			            type : 'category',
			            data : data_axis
			        }
			    ],
			    yAxis : [
			        {
			            type : 'value'
			        }
			    ],
			    series : [
			        {
			            name:'<?php echo $l_upload;?>',
			            type:'bar',
			            data:data_up,
			            markLine : {
			                data : [
			                    {type : 'average', name: 'Avg'}
			                ]
			            }
			        },
			        {
			            name:'<?php echo $l_download;?>',
			            type:'bar',
			            data:data_down,
			            markLine : {
			                data : [
			                    {type : 'average', name : 'Avg'}
			                ]
			            }
			        },
			        {
			            name:'<?php echo $l_bandwidth;?>',
			            type:'line',
			            data:data_bw,
			            markLine : {
			                data : [
			                    {type : 'average', name : 'Avg'}
			                ]
			            }
			        }
			    ]					
				};				
				var linechart_bw = document.getElementById('echart_bandwidth');
				var echartLine_act_bw = echarts.init(linechart_bw, theme);
		    echartLine_act_bw.setOption(option);
			}
		</script>
    <!-- /Line Graph Bandwidth -->

	  <!-- Line Graph Users Hits -->
		<script>
			function drawLineChartgraph_uh(l_users, l_connections) {

				var radiochkgraph = $("input[name=radio_chkgraph]:checked", "#hotspot_select_form").val();
				
				switch (radiochkgraph) {
					case "1":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_date;?>'
						var xaxis = '<?php echo $l_chk_graph_date;?>';
						var data_axis = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
						var data_user = [
									l_users[1],l_users[2],l_users[3],l_users[4],l_users[5],
									l_users[6],l_users[7],l_users[8],l_users[9],l_users[10],l_users[11],
									l_users[12],l_users[13],l_users[14],l_users[15],l_users[16],l_users[17],
									l_users[18],l_users[19],l_users[20],l_users[21],l_users[22],l_users[23],
									l_users[24],l_users[25],l_users[26],l_users[27],l_users[28],l_users[29],
									l_users[30],l_users[31]
							];
						var data_connect = [
									l_connections[1],l_connections[2],l_connections[3],l_connections[4],l_connections[5],
									l_connections[6],l_connections[7],l_connections[8],l_connections[9],l_connections[10],l_connections[11],
									l_connections[12],l_connections[13],l_connections[14],l_connections[15],l_connections[16],l_connections[17],
									l_connections[18],l_connections[19],l_connections[20],l_connections[21],l_connections[22],l_connections[23],
									l_connections[24],l_connections[25],l_connections[26],l_connections[27],l_connections[28],l_connections[29],
									l_connections[30],l_connections[31]
							];
						break;
					case "2":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_weekday;?>'
						var xaxis = '<?php echo $l_chk_graph_weekday;?>';
						var data_axis = ['<?php echo $l_Mo;?>', '<?php echo $l_Tu;?>', '<?php echo $l_We;?>', 
						'<?php echo $l_Th;?>', '<?php echo $l_Fr;?>', '<?php echo $l_Sa;?>', '<?php echo $l_Su;?>']
						var data_user = [
									l_users[1],l_users[2],l_users[3],l_users[4],l_users[5],l_users[6],l_users[7]
							];
						var data_connect = [
									l_connections[1],l_connections[2],l_connections[3],l_connections[4],l_connections[5],l_connections[6],l_connections[7]
							];
						break;
					case "3":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_weekly;?>'
						var xaxis = '<?php echo $l_chk_graph_weekly;?>';
						var data_axis = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,
							27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53];
						var data_user = [
									l_users[1],l_users[2],l_users[3],l_users[4],l_users[5],
									l_users[6],l_users[7],l_users[8],l_users[9],l_users[10],l_users[11],
									l_users[12],l_users[13],l_users[14],l_users[15],l_users[16],l_users[17],
									l_users[18],l_users[19],l_users[20],l_users[21],l_users[22],l_users[23],
									l_users[24],l_users[25],l_users[26],l_users[27],l_users[28],l_users[29],
									l_users[30],l_users[31],l_users[32],l_users[33],l_users[34],l_users[35],
									l_users[36],l_users[37],l_users[38],l_users[39],l_users[40],l_users[41],
									l_users[42],l_users[43],l_users[44],l_users[45],l_users[46],l_users[47],
									l_users[48],l_users[49],l_users[50],l_users[51],l_users[52],l_users[53]
							];
						var data_connect = [
									l_connections[1],l_connections[2],l_connections[3],l_connections[4],l_connections[5],
									l_connections[6],l_connections[7],l_connections[8],l_connections[9],l_connections[10],l_connections[11],
									l_connections[12],l_connections[13],l_connections[14],l_connections[15],l_connections[16],l_connections[17],
									l_connections[18],l_connections[19],l_connections[20],l_connections[21],l_connections[22],l_connections[23],
									l_connections[24],l_connections[25],l_connections[26],l_connections[27],l_connections[28],l_connections[29],
									l_connections[30],l_connections[31],l_connections[32],l_connections[33],l_connections[34],l_connections[35],
									l_connections[36],l_connections[37],l_connections[38],l_connections[39],l_connections[40],l_connections[41],
									l_connections[42],l_connections[43],l_connections[44],l_connections[45],l_connections[46],l_connections[47],
									l_connections[48],l_connections[49],l_connections[50],l_connections[51],l_connections[52],l_connections[53]
							];

						break;
					case "4":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_month;?>'
						var xaxis = '<?php echo $l_chk_graph_month;?>';
						var data_axis = ['<?php echo $l_January;?>', '<?php echo $l_February;?>', '<?php echo $l_March;?>', '<?php echo $l_April;?>', '<?php echo $l_May;?>', '<?php echo $l_June;?>', '<?php echo $l_July;?>', '<?php echo $l_August;?>', '<?php echo $l_September;?>', '<?php echo $l_October;?>', '<?php echo $l_November;?>', '<?php echo $l_December;?>' ]
						var data_user = [
									l_users[1],l_users[2],l_users[3],l_users[4],l_users[5],
									l_users[6],l_users[7],l_users[8],l_users[9],l_users[10],l_users[11],l_users[12]
							];
						var data_connect = [
									l_connections[1],l_connections[2],l_connections[3],l_connections[4],l_connections[5],
									l_connections[6],l_connections[7],l_connections[8],l_connections[9],l_connections[10],l_connections[11],l_connections[12]
							];
						break;
					case "5":
						var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_year;?>'
						var xaxis = '<?php echo $l_chk_graph_year;?>';
						var d = new Date();
						var n = d.getFullYear();
						var data_axis = [n+1,n,n-1,n-2];
						var data_user = [
									l_users[n+1],l_users[n],l_users[n-1],l_users[n-2]
							];
						var data_connect = [
									l_connections[n+1],l_connections[n],l_connections[n-1],l_connections[n-2]
							];
						break;									
				}
				
				var option = {
		      title: {
		        text: title,
		        subtext: ''
		      },

			    tooltip: {
			        trigger: 'none',
			        axisPointer: {
			            type: 'cross'
			        }
			    },
			    legend: {
			        data:['<?php echo $l_users;?>', '<?php echo $l_connections;?>']
			    },
			    grid: {
			        top: 70,
			        bottom: 50
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
			    calculable : true,
			    xAxis: [
			        {
			            type: 'category',
			            axisTick: {
			                alignWithLabel: true
			            },
			            axisLine: {
			                onZero: false,
			                lineStyle: {
			                    color: ''
			                }
			            },
			            axisPointer: {
			                label: {
			                    formatter: function (params) {
			                        return '<?php echo $l_users;?>  ' + params.value
			                            + (params.seriesData.length ? '：' + params.seriesData[0].data : '');
			                    }
			                }
			            },
			            data: data_axis
			        },			        
			        {
			            type: 'category',
			            axisTick: {
			                alignWithLabel: true
			            },
			            axisLine: {
			                onZero: false,
			                lineStyle: {
												color: ''
			                }
			            },
			            axisPointer: {
			                label: {
			                    formatter: function (params) {
			                        return '<?php echo $l_connections;?>  ' + params.value
			                            + (params.seriesData.length ? '：' + params.seriesData[0].data : '');
			                    }
			                }
			            },
			            data: data_axis
			        },			        
			    ],
			    yAxis: [
			        {
			            type: 'value'
			        }
			    ],
			    series: [
			        {
			            name:'<?php echo $l_users;?>',
			            type:'bar',
			            xAxisIndex: 1,
			            smooth: true,
			            data: data_user
			        },
			        {
			            name:'<?php echo $l_connections;?>',
			            type:'line',
			            smooth: true,
			            data: data_connect
			        }
			    ]
				};
				var linechart_uh = document.getElementById('echart_userhits');
				var echartLine_uh = echarts.init(linechart_uh, theme);
		    echartLine_uh.setOption(option);
			}
		</script>
	  <!-- /Line Graph Users Hits -->

		<!-- Time Distribution -->
		<script>
			function drawBarChartgraph_tc(l_dist) {
				
	      var option = {
	        title: {
	          text: '<?php echo $l_bargraphtimeconnect;?>',
	          subtext: '<?php echo $l_bargraph;?>'
	        },
	        tooltip: {
	          trigger: 'axis'
	        },
	        legend: {
	          x: 100,
	          data: ['']
	        },
	        toolbox: {
	          show: true,
	          feature: {
	            saveAsImage: {
	              show: true,
	              title: 'Save Image'
	            }
	          }
	        },
	        calculable: true,
	        xAxis: [{
	          type: 'value',
	          boundaryGap: [0, 1]
	        }],
	        yAxis: [{
	          type: 'category',
	          data: ['[0-5]', '[6-15]', '[16-30]', '[31-60]', '[61-120]', '[121+]']
	        }],
	        series: [{
	          name: '<?php echo $l_users;?>',
	          type: 'bar',
	          data: [l_dist[1], l_dist[2], l_dist[3], l_dist[4], l_dist[5], l_dist[6]]
	        }]
	      };
				var barchart_tc = document.getElementById('echart_timeconnect');
				var echartBar_tc = echarts.init(barchart_tc);
		    echartBar_tc.setOption(option);
			}
    </script>
    <!-- /Time Distribution -->
    
	 <!-- bootstrap-daterangepicker -->
	 <script>
	   $(document).ready(function() {

	     var datestart;
	     var dateend;

	     var cb = function(start, end, label) {
	       console.log(start.toISOString(), end.toISOString(), label);
	       $('#reportrange span').html(start.format('<?php echo $l_dateformat;?>') + ' - ' + end.format('<?php echo $l_dateformat;?>'));
	       datestart = start.format('YYYY-MM-DD');
	       dateend = end.format('YYYY-MM-DD');
	       $('#datestart').val(datestart);
	       $('#dateend').val(dateend);
	     };

	     var optionSet1 = {
	       startDate: moment(),
	       endDate: moment(),
	       minDate: '01/01/1900',
	       maxDate: '12/31/2050',
	       // dateLimit: {
	       //   days: 180
	       // },
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
	     $('#destroy').click(function() {
	       $('#reportrange').data('daterangepicker').remove();
	     });
	   });
	 </script>
	 <!-- /bootstrap-daterangepicker -->
	 
		<script type="text/javascript">
			$(document).ready(function() {
		    $('#hotspot_select_form').submit(function(e) {
	        e.preventDefault();

					NProgress.start();
					NProgress.set(0.4);

					var schemaid = $("#selClient").val();
					var countryid = $("#selCountry").val();
					var stateid = $("#selState").val();
					var cityid = $("#selCity").val();
					var locationid = $("#selLocation").val();
					var spotid = $("#selHotSpot").val();
					var radiochkgraph = $("input[name=radio_chkgraph]:checked", "#hotspot_select_form").val();
					var date_s = $("#datestart").val();
					var date_e = $("#dateend").val();
					
					var radiochkdate = $("input[name=radio_checkdate]:checked", "#hotspot_select_form").val();

					var operatorid = <?php echo $operator_profile_id;?>;
					if (operatorid != 1) operatorid = <?php echo $operator_id;?>;
					
					$.ajax({
					  url: 'rest-api/dashboard/getHotSpot.php',
					  type: 'POST',
						data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid,
						radio_chkgraph:radiochkgraph, datestart:date_s, dateend:date_e, operator_id:operatorid},
					  dataType: 'json',
					  success:function(response) {

					    console.log(response);
							var len = response.length;
							var totalusers = 0;
							var totalnewusers = 0;
							var totalonline = 0;
							var totalhits = 0;
							var totalnologged = 0;
							var bd_user =[];
							var bd_hotspot = [];
							var bt_hotspot = [];
							var l_weekday_day = '';
							var l_weekday_time = '';
							
							var bwtotal = 0;
							var bwupload = 0;
							var bwdownload = 0;
							var bwtotaltime = 0;
							var g_upload = [];
							var g_download = [];
							var g_bwtotal = [];
							var g_users = [];
							var g_hits = [];
							var g_dist = [];
							
							switch (radiochkgraph) {
								case "1":
									var val = 31;
									break;
								case "2":
									var val = 7;
									for (var z = 1; z<=val; z++) {
										bd_user[z] = 0;
										bd_hotspot[z] = 0;
									}								
									break;
								case "3":
									var val = 53;
									break;
								case "4":
									var val = 12;
									break;
								case "5":
									var val = 4;
									break;									
							}

						  for (i = 0; i<=23; i++) {
						    bt_hotspot[i] = 0;
						  }
							
						  for (i = 1; i<=6; i++) {
						    g_dist[i] = 0;
						  }

							if (radiochkgraph != "5") {
								for (var z = 1; z<=val; z++) {
									g_upload[z] = 0;
									g_download[z] = 0;
									g_bwtotal[z] = 0;
									g_users[z] = 0;
									g_hits[z] = 0;
								}
							} else {
								var d = new Date();
								var n = d.getFullYear();
								for (var z = 0; z<=val; z++) {
									g_upload[n-(z-1)] = 0;
									g_download[n-(z-1)] = 0;
									g_bwtotal[n-(z-1)] = 0;
									g_users[n-(z-1)] = 0;
									g_hits[n-(z-1)] = 0;
								}										
							}

							for (var i = 0; i<len; i++) {

								var object = response[i];
								for (property in object) {
					        var value = object[property];
									if (value == 'totalusers') {
										totalusers = object['data'];
										document.getElementById('totalusers').innerHTML = Intl.NumberFormat().format(totalusers);
									}
									if (value == 'totalnewusers') {
										totalnewusers = object['data'];
										document.getElementById('totalnewusers').innerHTML = Intl.NumberFormat().format(totalnewusers);
									}
									if (value == 'totalonline') {
										totalonline = object['data'];
										document.getElementById('totalonline').innerHTML = Intl.NumberFormat().format(totalonline);
									}
									if (value == 'totalhits') {
										totalhits = object['data'];
										document.getElementById('totalhits').innerHTML = Intl.NumberFormat().format(totalhits);
									}
									if (value == 'totalnologged') {
										totalnologged = object['data'];
										document.getElementById('totalnologged').innerHTML = Intl.NumberFormat().format(totalnologged);
									}
									if (value == 'busydayuser') {
										var day_ini = "";
										for (var x = 0; x<object['data'].length; x++) {
											var day = object['data'][x].day;
											if (day_ini != day) {
												day_ini = object['data'][x].day;
												bd_user[day] = parseInt(object['data'][x].total);
											} else bd_user[day] = bd_user[day] + parseInt(object['data'][x].total);

										}
										drawBarChart_busiestday_users(bd_user);
									}									
									if (value == 'busydayhotspot') {
										var day_ini = "";
										for (var x = 0; x<object['data'].length; x++) {
											var day = object['data'][x].day;
											if (day_ini != day) {
												day_ini = object['data'][x].day;
												bd_hotspot[day] = parseInt(object['data'][x].total);
											} else bd_hotspot[day] = bd_hotspot[day] + parseInt(object['data'][x].total);
										}
										drawBarChart_busiestday_hotspot(bd_hotspot);
									}									
									if (value == 'busydaytime') {
										var hour_ini = "";
										for (var x = 0; x<object['data'].length; x++) {
											var hour = object['data'][x].hour;
											if (hour_ini != hour) {
												hour_ini = object['data'][x].hour;
												bt_hotspot[hour] = parseInt(object['data'][x].total);
											} else bt_hotspot[hour] = bt_hotspot[hour] + parseInt(object['data'][x].total);

										}
										drawBarChart_busiesttime_hotspot(bt_hotspot);
									}
									if (value == 'maxusedday') {
										l_weekday_day = object['data'][0].day;
										bwupload = object['data'][0].bwupload;
										bwdownload = object['data'][0].bwdownload;
										bwtotal = object['data'][0].bandwidth;
										document.getElementById('bwupload').innerHTML = bwupload;
										document.getElementById('bwdownload').innerHTML = bwdownload;
										document.getElementById('bwtotal').innerHTML = bwtotal;
										document.getElementById('l_weekday_bwu').innerHTML = l_weekday_day;
										document.getElementById('l_weekday_bwd').innerHTML = l_weekday_day;
										document.getElementById('l_weekday_bwt').innerHTML = l_weekday_day;
									}																				
									if (value == 'maxusedtime') {
										l_weekday_time = object['data'][0].hour+' '+object['data'][0].day;
										bwtotaltime = object['data'][0].total;
										document.getElementById('bwtotaltime').innerHTML = bwtotaltime;
										document.getElementById('l_weekday_time').innerHTML = l_weekday_time;
									}																		
									if (value == 'bandwidth') {
										for (var x = 0; x<object['data'].length; x++) {
											var day = object['data'][x].day_part;
											g_upload[day] = object['data'][x].bwupload;
											g_download[day] = object['data'][x].bwdownload;
											g_bwtotal[day] = object['data'][x].bandwidth;
										}
										drawLineChartgraph_bw(g_upload, g_download, g_bwtotal);
									}
									if (value == 'usershits') {
										var day_ini = "";
										for (var x = 0; x<object['data'].length; x++) {
											var day = object['data'][x].day_part;
											if (day_ini != day) {
												day_ini = object['data'][x].day_part;
												g_users[day] = parseInt(object['data'][x].cant);
												g_hits[day] = parseInt(object['data'][x].hits);
											} else {
												g_users[day] = g_users[day] + parseInt(object['data'][x].cant);
												g_hits[day] = g_hits[day] + parseInt(object['data'][x].hits);
											}
										}
										drawLineChartgraph_uh(g_users, g_hits);
									}
									if (value == 'timeconnect') {
										var pos_ini = "";
										for (var x = 0; x<object['data'].length; x++) {
											var pos = object['data'][x].pos;
											if (pos_ini != pos) {
												pos_ini = object['data'][x].pos;
												g_dist[pos] = object['data'][x].cant;												
											} else g_dist[pos] = g_dist[pos] + object['data'][x].cant;
										}
										drawBarChartgraph_tc(g_dist);
									}
						    }								
							}
							NProgress.done();
					  }
					});
				});
			});
		</script>

   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			

  </body>
</html>
