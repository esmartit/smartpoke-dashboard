<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

	$loginpath = $_SERVER['PHP_SELF'];
	include ('library/checklogin.php');
	$page = '$sb_dashboard2';

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
	$show_access = opt_buttons($page, $operator_profile_id, 'show_btn');

	$radio_checkdate = $_SESSION['radio_checkdate'];
	$checked_1 = 'checked';

	$datestart = date("Y-m-d", strtotime("-1 day", strtotime($currDate)));
	$datestartspan = date("d M Y", strtotime($datestart));

	$dateend = date("Y-m-d", strtotime("-1 day", strtotime($currDate)));
	$dateendspan = date("d M Y", strtotime($dateend));

	$datestart2 = date("Y-m-d", strtotime("-8 day", strtotime($currDate)));
	$datestartspan2 = date("d M Y", strtotime($datestart2));

	$dateend2 = date("Y-m-d", strtotime("-8 day", strtotime($currDate)));
	$dateendspan2 = date("d M Y", strtotime($dateend2));

	$timestart=$_SESSION['timestart'];
	$time_ini = (int)substr($timestart, 0, 2);

	$timeend=$_SESSION['timeend'];
	$time_end = (int)substr($timeend, 0, 2);

	$id_client = $client_id;
	$country_id = '35';
	$state_id = '%';
	$city_id = '%';
	$location_id = '%';
	$spot_id = '%';
	$sensor_name = '%';
	$sel_timegroup = 'time_hour';
	$selected_0 = "selected = '".$sel_timegroup."'";
	$radio_chkgraph = '0';
	$chk_grap_0 = 'checked';
	$status_id = '%';
	$selected_all="selected = '".$status_id."'";
	$selected_in='';
	$selected_limit='';
	$selected_out='';
	$timefilter_min = '';
	$sel_timefilter_min = '1';
	$timefilter_max = '';
	$sel_timefilter_max = '1';
	$selected_s = "selected = '".$timefilter_min."'";
	$presence = '1';
	$brand_list = '';
	$radio_chkin = '1';
	$chk_in_1 = 'checked';

  $bigdata = stats_val(0, 0);
  $bigdata_o = stats_val(0, 0);
  $bigdata_in = stats_val(0, 0);
  $bigdata_in_o = stats_val(0, 0);
  $bigdatavisits_in = stats_val(0, 0);
  $bigdatavisits_in_o = stats_val(0, 0);

  $gdbigdata = percent_val(0,0);
  $gdbigdata_o = percent_val(0,0);
  $gdbigdatavisits = percent_val(0,0);
  $gdbigdatavisits_o = percent_val(0,0);
  
  $totalacct = stats_val(0, 0);
  $totalacct_o = stats_val(0, 0);
  $in = stats_val(0, 0);
  $in_o = stats_val(0, 0);
  $limit = stats_val(0, 0);
  $limit_o = stats_val(0, 0);
  $out = stats_val(0, 0);
  $out_o = stats_val(0, 0);
	
  $gdin = percent_val(0,0);
  $gdin_o = percent_val(0,0);
  $gdlimit = percent_val(0,0);
  $gdlimit_o = percent_val(0,0);
  $gdout = percent_val(0,0);
  $gdout_o = percent_val(0,0);

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
                <h3>BigData / Analytics</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_query;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="bigdata_select_form" class="form-horizontal form-label-left"  method="POST" action='<?php echo $loginpath;?>'>

				              <!-- form select -->
				              <div class="col-md-6 col-sm-6 col-xs-12">
	                      <div class="form-group">
	                        <div class="col-md-9 col-sm-12 col-xs-12">
	                          <div class="radio">
	                            <label class="control-label col-md-3 co-sm-3 col-xs-3">
	                              <input type="radio" value="0" id="radio_checkdate1" <?php echo $checked_1;?> name="radio_checkdate" onClick="hideDaterange()"> <?php echo $l_checkdate_range_s;?>
	                            </label>
	                            <label>
	                            </label>
	                            <label>
	                              <input type="radio" value="1" id="radio_checkdate2" name="radio_checkdate" onClick="showDaterange()"> <?php echo $l_checkdate_range_c;?>
	                            </label>
	                          </div>													
	                        </div>
	                      </div>

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
		                    <div class="form-group" id="daterange" style="display: none;">
													<label class="control-label col-md-3 co-sm-3 col-xs-3"></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <div id="reportrange2" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		                          <span><?php echo $datestartspan2.' - '.$dateendspan2;?></span> <b class="caret"></b>
		                        </div>
		                      </div>
	                        <input type="hidden" name="datestart2" id="datestart2" value='<?php echo $datestart2;?>'/>
	                        <input type="hidden" name="dateend2" id="dateend2" value='<?php echo $dateend2;?>'/>
		                    </div>
												<div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_hours;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <div class="col-md-6 col-sm-6 col-xs-12">
			                        <input id="timestart" type="text" name="timestart" <?php echo $show_access;?> class="form-control col-md-10" value=<?php echo $timestart;?> />
			                      </div>
			                      <div class="col-md-6 col-sm-6 col-xs-12">
			                        <input id="timeend" type="text" name="timeend" <?php echo $show_access;?> class="form-control col-md-10" value=<?php echo $timeend;?> />
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
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_spots;?></label>
													<div class="col-md-9 col-sm-9 col-xs-12">
													  <select id="selSpot" class="form-control" <?php echo $show_access;?> name="spot_id" onChange="showSensor()">
															<option value="%"><?php echo $l_all_spot;?></option>
													
													  </select>
													</div>
											  </div>				  
											  <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_sensor;?></label>
													<div class="col-md-6 col-sm-6 col-xs-12">
													  <select id="selSensor" class="form-control" <?php echo $show_access;?> name="sensor_name">
															<option value="%"><?php echo $l_all_sensor;?></option>
													
													  </select>
													</div>
												</div>
											  <div class="form-group">
		                      <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_group_by;?></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selGroupBy" class="form-control" name="sel_timegroup" <?php echo $show_access;?> >
			                        <option value="time_hour" <?php echo $selected_0;?>><?php echo $l_actual;?> </option>
		                          <option value="900" <?php echo $selected_15;?>>15 min.</option>
		                          <option value="1800" <?php echo $selected_30;?>>30 min.</option>
		                          <option value="3600" <?php echo $selected_1;?>>1 Hr.</option>
		                        </select>
		                      </div>
											  </div>
	                      <div class="form-group">
	                        <div class="col-md-12 col-sm-12 col-xs-12">
	                          <div class="radio">
				                      <label>
				                        <input type="radio" value="0" <?php echo $chk_grap_0;?> name="radio_chkgraph"><?php echo $l_chk_graph_hour ?>
				                      </label>
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
				              <!-- filters -->
				              <div class="col-md-6 col-sm-6 col-xs-12">									
			                  <div class="form-group">
			                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_status;?></label>
			                    <div class="col-md-6 col-sm-6 col-xs-12">
			                      <select id="selStatus" class="form-control" <?php echo $show_access;?> name="status_id" >
			                        <option value="%" <?php echo $selected_all;?>><?php echo $l_all_select_status;?></option>
			                        <option value="IN" <?php echo $selected_in;?>><?php echo $l_in;?></option>
			                        <option value="LIMIT" <?php echo $selected_limit;?>><?php echo $l_limit;?></option>
			                        <option value="OUT" <?php echo $selected_out;?>><?php echo $l_out;?></option>
			                      </select>
			                    </div>
			                  </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_time_ini;?></label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input id="timefilter_min" type="text" name="timefilter_min" <?php echo $show_access;?> class="form-control col-md-6" value='<?php echo $timefilter_min;?>' >
		                      </div>                    
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="sel_timefilter_min" class="form-control" <?php echo $show_access;?> name="sel_timefilter_min" >
		                          <option value="1" <?php echo $selected_s;?>><?php echo $l_seconds;?></option>
		                          <option value="60" <?php echo $selected_m;?>><?php echo $l_minutes;?></option>
		                          <option value="3600" <?php echo $selected_h;?>><?php echo $l_hours;?></option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class='form-group'>
		                      <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_time_end;?></label>
		                      <div class='col-md-3 col-sm-3 col-xs-12'>
		                        <input id="timefilter_max" type='text' name='timefilter_max' <?php echo $show_access;?> class='form-control col-md-6' value='<?php echo $timefilter_max;?>' >
		                      </div>                    
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="sel_timefilter_max" class="form-control" <?php echo $show_access;?> name="sel_timefilter_max" >
		                          <option value="1" <?php echo $selected_s;?>><?php echo $l_seconds;?></option>
		                          <option value="60" <?php echo $selected_m;?>><?php echo $l_minutes;?></option>
		                          <option value="3600" <?php echo $selected_h;?>><?php echo $l_hours;?></option>
		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_presence;?></label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                        <input id="presence" type="text" name="presence" <?php echo $show_access;?> class="form-control col-md-6" value=<?php echo $presence;?> >
		                      </div>
		                    </div>
												<div class="form-group">
												  <label class="control-label col-md-3 col-sm-3 col-xs-3"><?php echo $l_devices;?></label>
												  <div class="col-md-6 col-sm-6 col-xs-12">
														<select id="brand_list" class="select2_multiple form-control" <?php echo $show_access;?> name="brand_list[]" multiple="multiple" size="11" style="height: 100%;" >

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
              
							<!-- Big Data Graphics -->
							<div class="row">
	              <div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2><?php echo $l_titlelinebigdata;?> <small id="range_1a"></small></h2>
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

							<div id="ratios_bigdata_o" class="row" style="display: none;">
								<div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2><?php echo $l_titlelinebigdata;?> <small id="range_2a"></small></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="row tile_count">
	                    <div class="col-md-3 col-sm-6 col-xs-9 tile_stats_count">
	                      <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_visitors_bd;?></span>
	                      <div id="devicebd_o" class="count">0</div>
	                    </div>
	                    <div class="col-md-3 col-sm-6 col-xs-9 tile_stats_count">
	                    </div>
	                    <div class="col-md-3 col-sm-6 col-xs-9 tile_stats_count">
	                      <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_visitors_bd_in;?></span>
	                      <div id="devicebdin_o" class="count blue">0</div>
	                    </div>
	                    <div class="col-md-3 col-sm-6 col-xs-9 tile_stats_count">
	                      <span class="count_top"><i class="fa fa-users"></i> <?php echo $l_visitors_bdvisits_in;?></span>
	                      <div id="devicebdqvin_o" class="count blue">0</div>
	                      <div><span class="count_bottom"><i class="fa fa-clock-o"></i><?php echo $l_qualifiedavgtime;?></span></div>
	                      <span id="devicebdqvtin_o" class="count_bottom">0</span>
	                    </div>
	                  </div>	                  
	                </div>
	              </div>
							</div>
							<div class="row">
                <!-- pie chart -->
	              <div id="ratio_bd_o" class="col-md-6 col-sm-12 col-xs-12" style="display: none;">
	                <div class="x_panel">
	                  <div class="x_title">
			                <h2>Ratio <small><?php echo $l_visitors_bd_in;?></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="bigdata_o" style="height:350px;"></div>
	                  </div>
	                </div>
								</div>
                <!-- pie chart -->
	              <div id="ratio_bdin_o" class="col-md-6 col-sm-12 col-xs-12" style="display: none;">
	                <div class="x_panel">
	                  <div class="x_title">
			                <h2>Ratio <small><?php echo $l_visitors_bdvisits_in;?></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <div id="bigdatavisits_o" style="height:350px;"></div>
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
			                <h2><?php echo $l_visits;?> <small id="range_1b"></small></h2>
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
							
							<div id="qvisits_o" class="row" style="display: none;">
								<div class="col-md-12 col-sm-12 col-xs-12" style="height: 100%;">
			            <div class="x_panel">
			              <div class="x_title">
			                <h2><?php echo $l_visits;?> <small id="range_2b"></small></h2>
			                <div class="clearfix"></div>
			              </div>

			              <div class="row tile_count">
			                <div class="col-md-9 col-sm-9 col-xs-12 tile_stats_count">
			                  <span class="count_top"><i class="fa fa-bar-chart"></i><?php echo $l_total_acct;?> </span>
			                  <div id="totalacct_o" class="count">0</div>
			                </div>
										</div>
										<div class="row tile_count">
			                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
			                  <span class="count_top"><i class="fa fa-download"></i><?php echo $l_in;?> </span>
			                  <div id="in_o" class="count green">0</div>
			                  <div><span class="count_bottom"><i class="fa fa-clock-o"></i><?php echo $l_qualifiedavgtime;?></span></div>
			                  <span id="totaltimeinvisits_o" class="count_bottom"></span>
			                </div>
			                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
			                  <span class="count_top"><i class="fa fa-minus"></i><?php echo $l_limit;?> </span>
			                  <div id="limit_o" class="count blue">0</div>
			                  <div><span class="count_bottom"><i class="fa fa-clock-o"></i><?php echo $l_qualifiedavgtime;?></span></div>
			                  <span id="totaltimelimitvisits_o" class="count_bottom">0</span>
			                </div>
			                <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
			                  <span class="count_top"><i class="fa fa-upload"></i><?php echo $l_out;?> </span>
			                  <div id="out_o" class="count red">0</div>
			                  <div><span class="count_bottom"><i class="fa fa-clock-o"></i><?php echo $l_qualifiedavgtime;?></span></div>
			                  <span id="totaltimeoutvisits_o" class="count_bottom">0</span>
			                </div>
			              </div>
			            </div>
			          </div>
							</div>
							
              <!-- pie chart -->
							<div id="graphics_o" class="row" style="display: none;">
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
	                    <div id="graph_status_o" style="height:350px;"></div>
	                  </div>
	                </div>
	              </div>								
								<!-- /pie chart -->

								<!-- Brands -->
								<div id="brands_o" class="col-md-6 col-sm-12 col-xs-12" style="display: none;">
				          <div class="x_panel">
			              <div class="x_title">
			                <h2><?php echo $l_brands;?> <small></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                    </ul>
			                <div class="clearfix"></div>
			              </div>
			              <div class="x_content">
			                <div id="devices_o" style="height:350px;"></div>                  
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
				                <h2><?php echo $l_titlelineactivity;?> <small id="range_1c"></small></h2>
				                <div class="clearfix"></div>
				              </div>
				              <div class="x_content">
				                <div id="echart_activity" $display_h style="height:350px;"></div>                  
				              </div>
				            </div>
				          </div>
								</div>
							</div>							

							<div id="graph_acct_o" class="row" style="display: none;">
								<div class="col-md-12 col-sm-12 col-xs-12">
				          <div class="x_panel">
				              <div class="x_title">
				                <h2><?php echo $l_titlelineactivity;?> <small id="range_2c"></small></h2>
				                <div class="clearfix"></div>
				              </div>
				              <div class="x_content">
				                <div id="echart_activity_o" $display_h style="height:350px;"></div>                  
				              </div>
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
    <script src='../vendors/jquery/dist/jquery.min.js'></script>
    <!-- Bootstrap -->
    <script src='../vendors/bootstrap/dist/js/bootstrap.min.js'></script>
    <!-- FastClick -->
    <script src='../vendors/fastclick/lib/fastclick.js'></script>
    <!-- NProgress -->
    <script src='../vendors/nprogress/nprogress.js'></script>
    <!-- Chart.js -->
    <script src='../vendors/Chart.js/dist/Chart.min.js'></script>
    <!-- bootstrap-progressbar -->
    <script src='../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'></script>
    <!-- iCheck -->
    <script src='../vendors/iCheck/icheck.min.js'></script>
    <!-- DateJS -->
    <script src='../vendors/DateJS/build/date.js'></script>
    <!-- bootstrap-daterangepicker -->
    <script src='js/moment/moment.min.js'></script>
    <script src='js/datepicker/daterangepicker.js'></script>
    <!-- morris.js -->
    <script src='../vendors/raphael/raphael.min.js'></script>
    <script src='../vendors/morris.js/morris.min.js'></script>
    <!-- gauge.js -->
    <script src='../vendors/gauge.js/dist/gauge.min.js'></script>
    <!-- ECharts -->
    <script src='../vendors/echarts/dist/echarts.min.js'></script>

    <!-- Custom Theme Scripts -->
    <script src='../build/js/custom.min.js'></script>


		<script>
			$( window ).load(function() {
								
                showClient();
				var countryid = '<?php echo $country_id;?>';

			  $('#selCountry option[value="'+countryid+'"]').prop('selected', true);
			  var evt = document.createEvent("HTMLEvents");
			  evt.initEvent("change", false, true);
			  document.getElementById('selCountry').dispatchEvent(evt);
				
			});

			$("#selCountry").change(function() {
				var stateid = '<?php echo $state_id;?>';
				showState(stateid);
			});
							
    </script>
			
    <script>
		  function showClient() {

			$("#selClient").empty();
			$("#selClient").append("<option value='<?php echo $id_client;?>'><?php echo $c_name;?></option>");
		  }
    </script>

    <!-- /showState - City - Location -->
    <script>
		  function showState(s_id) {
	  
				var countryid = $("#selCountry").val();
				var cityid = '<?php echo $city_id;?>';

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
							
							selected = '';
							if (s_id == id) selected = "selected = '"+s_id+"'";

							$("#selState").append("<option value='"+id+"' "+selected+">"+name+"</option>");

						}
					}
				});
				showCity(cityid);
		  }	
    </script>
			
		<script>
		  function showCity(c_id) {
	  

				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var locationid = '<?php echo $location_id;?>';
				
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

							selected = '';
							if (c_id == id) selected = "selected = '"+c_id+"'";

							$("#selCity").append("<option value='"+id+"' "+selected+">"+name+"</option>");

						}
					}
				});
				showLocation(locationid);
				showSpot();
				showSensor();
		  }	
    </script>
		<script>
					
		  function showLocation(l_id) {
	  
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();
				var spotid = '<?php echo $spot_id;?>';

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

							selected = '';
							if (l_id == id) selected = "selected = '"+l_id+"'";

							$("#selLocation").append("<option value='"+id+"' "+selected+">"+name+"</option>");

						}
					}
				});
				showSpot(spotid);
		  }			
    </script>
    <!-- /showState - City - Location -->

    <!-- /showSpot - Sensor -->
    <script>
		  function showSpot(sp_id) {
	  
				var schemaid = $("#selClient").val();
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();
				var locationid = $("#selLocation").val();
				var sensorname = '<?php echo $sensor_name;?>';

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

							selected = '';
							if (sp_id == id) selected = "selected = '"+sp_id+"'";

							$("#selSpot").append("<option value='"+id+"' "+selected+">"+name+"</option>");

						}
					}
				});
				showSensor(sensorname);
		  }	
		</script>
			
	  <script>
		  function showSensor(sn_id) {
	  
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
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							selected = '';
							if (sn_id == id) selected = "selected = '"+sn_id+"'";

							$("#selSensor").append("<option value='"+id+"' "+selected+">"+name+"</option>");
						}
				  }
				});
		  }			
    </script>
    <!-- /showSpot - Sensor -->
		
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
          startDate: moment().subtract(1, 'days'),
          endDate: moment().subtract(1, 'days'),
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

    <!-- theme -->
    <script>
      var theme = {
          color: [
            '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
            '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
          ],

          title: {
            itemGap: 8,
            textStyle: {
              fontWeight: 'normal',
              color: '#408829'
            }
          },

          dataRange: {
            color: ['#1f610a', '#97b58d']
          },

          toolbox: {
            color: ['#408829', '#408829', '#408829', '#408829']
          },

          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.5)',
            axisPointer: {
              type: 'line',
              lineStyle: {
                color: '#408829',
                type: 'dashed'
              },
              crossStyle: {
                color: '#408829'
              },
              shadowStyle: {
                color: 'rgba(200,200,200,0.3)'
              }
            }
          },

          dataZoom: {
            dataBackgroundColor: '#eee',
            fillerColor: 'rgba(64,136,41,0.2)',
            handleColor: '#408829'
          },
          grid: {
            borderWidth: 0
          },

          categoryAxis: {
            axisLine: {
              lineStyle: {
                color: '#408829'
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
                color: '#408829'
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
              color: '#408829'
            },
            controlStyle: {
              normal: {color: '#408829'},
              emphasis: {color: '#408829'}
            }
          },

          k: {
            itemStyle: {
              normal: {
                color: '#68a54a',
                color0: '#a9cba2',
                lineStyle: {
                  width: 1,
                  color: '#408829',
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
                  strokeColor: '#408829'
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
                color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
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
			function drawChartbigdata_o(bd_o, bdin_o) {
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
				                {value:bdin_o, name:'<?php echo $l_in;?>'},
												{value:bd_o, name:'<?php echo $l_devices;?>'}
				            ]
				        }
				    ]
				};

				var bdchart_o = document.getElementById('bigdata_o');
				var mybdChart_o = echarts.init(bdchart_o);
				mybdChart_o.setOption(option);
				
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
			function drawChartbigdataqvin_o(bd_o, bdqvin_o) {
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
												{value:bdqvin_o, name:'<?php echo $l_in;?>'},
												{value:bd_o, name:'<?php echo $l_devices;?>'}										
				            ]
				        }
				    ]
				};
				var bdinchart_o = document.getElementById('bigdatavisits_o');
				var mybdinChart_o = echarts.init(bdinchart_o);
				mybdinChart_o.setOption(option);
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

		<script>
			function drawChartgraphstatus_o(d_in_o, d_limit_o, d_out_o) {
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
				                {value:d_in_o, name:'<?php echo $l_in;?>'},
				                {value:d_limit_o, name:'<?php echo $l_limit;?>'},
				                {value:d_out_o, name:'<?php echo $l_out;?>'}
				            ]
				        }
				    ]
				};
				var gschart_o = document.getElementById('graph_status_o');
				var mygsChart_o = echarts.init(gschart_o);
				mygsChart_o.setOption(option);
			}
		</script>
		<!-- /eChadt -->
		
    <!-- Line Graph Activity -->
		<script>
			function drawLineChartgraph(l_in, l_limit, l_out) {

				var radiochkgraph = $("input[name=radio_chkgraph]:checked", "#bigdata_select_form").val();
				
				switch (radiochkgraph) {
				case "0":
					var xaxis = '<?php echo $l_chk_graph_hour;?>';
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_hour;?>';
					var data_axis = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
					var data_in = [
								l_in[0],l_in[1],l_in[2],l_in[3],l_in[4],l_in[5],
								l_in[6],l_in[7],l_in[8],l_in[9],l_in[10],l_in[11],
								l_in[12],l_in[13],l_in[14],l_in[15],l_in[16],l_in[17],
								l_in[18],l_in[19],l_in[20],l_in[21],l_in[22],l_in[23]
						];
					var data_limit = [
								l_limit[0],l_limit[1],l_limit[2],l_limit[3],l_limit[4],l_limit[5],
								l_limit[6],l_limit[7],l_limit[8],l_limit[9],l_limit[10],l_limit[11],
								l_limit[12],l_limit[13],l_limit[14],l_limit[15],l_limit[16],l_limit[17],
								l_limit[18],l_limit[19],l_limit[20],l_limit[21],l_limit[22],l_limit[23]
						];
					var data_out = [
								l_out[0],l_out[1],l_out[2],l_out[3],l_out[4],l_out[5],
								l_out[6],l_out[7],l_out[8],l_out[9],l_out[10],l_out[11],
								l_out[12],l_out[13],l_out[14],l_out[15],l_out[16],l_out[17],
								l_out[18],l_out[19],l_out[20],l_out[21],l_out[22],l_out[23]
						];
					break;
				case "1":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_date;?>'
					var xaxis = '<?php echo $l_chk_graph_date;?>';
					var data_axis = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
					var data_in = [
								l_in[1],l_in[2],l_in[3],l_in[4],l_in[5],
								l_in[6],l_in[7],l_in[8],l_in[9],l_in[10],l_in[11],
								l_in[12],l_in[13],l_in[14],l_in[15],l_in[16],l_in[17],
								l_in[18],l_in[19],l_in[20],l_in[21],l_in[22],l_in[23],
								l_in[24],l_in[25],l_in[26],l_in[27],l_in[28],l_in[29],
								l_in[30],l_in[31]
						];
					var data_limit = [
								l_limit[1],l_limit[2],l_limit[3],l_limit[4],l_limit[5],
								l_limit[6],l_limit[7],l_limit[8],l_limit[9],l_limit[10],l_limit[11],
								l_limit[12],l_limit[13],l_limit[14],l_limit[15],l_limit[16],l_limit[17],
								l_limit[18],l_limit[19],l_limit[20],l_limit[21],l_limit[22],l_limit[23],
								l_limit[24],l_limit[25],l_limit[26],l_limit[27],l_limit[28],l_limit[29],
								l_limit[30],l_limit[31]
						];
					var data_out = [
								l_out[1],l_out[2],l_out[3],l_out[4],l_out[5],
								l_out[6],l_out[7],l_out[8],l_out[9],l_out[10],l_out[11],
								l_out[12],l_out[13],l_out[14],l_out[15],l_out[16],l_out[17],
								l_out[18],l_out[19],l_out[20],l_out[21],l_out[22],l_out[23],
								l_out[24],l_out[25],l_out[26],l_out[27],l_out[28],l_out[29],
								l_out[30],l_out[31]
						];
					break;
				case "2":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_weekday;?>'
					var xaxis = '<?php echo $l_chk_graph_weekday;?>';
					var data_axis = ['<?php echo $l_Mo;?>', '<?php echo $l_Tu;?>', '<?php echo $l_We;?>', 
					'<?php echo $l_Th;?>', '<?php echo $l_Fr;?>', '<?php echo $l_Sa;?>', '<?php echo $l_Su;?>']
					var data_in = [
								l_in[1],l_in[2],l_in[3],l_in[4],l_in[5],l_in[6],l_in[7]
						];
					var data_limit = [
								l_limit[1],l_limit[2],l_limit[3],l_limit[4],l_limit[5],l_limit[6],l_limit[7]
						];
					var data_out = [
								l_out[1],l_out[2],l_out[3],l_out[4],l_out[5],l_out[6],l_out[7]
						];
					break;
				case "3":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_weekly;?>'
					var xaxis = '<?php echo $l_chk_graph_weekly;?>';
					var data_axis = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,
						27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53];
					var data_in = [
								l_in[1],l_in[2],l_in[3],l_in[4],l_in[5],
								l_in[6],l_in[7],l_in[8],l_in[9],l_in[10],l_in[11],
								l_in[12],l_in[13],l_in[14],l_in[15],l_in[16],l_in[17],
								l_in[18],l_in[19],l_in[20],l_in[21],l_in[22],l_in[23],
								l_in[24],l_in[25],l_in[26],l_in[27],l_in[28],l_in[29],
								l_in[30],l_in[31],l_in[32],l_in[33],l_in[34],l_in[35],
								l_in[36],l_in[37],l_in[38],l_in[39],l_in[40],l_in[41],
								l_in[42],l_in[43],l_in[44],l_in[45],l_in[46],l_in[47],
								l_in[48],l_in[49],l_in[50],l_in[51],l_in[52],l_in[53]
						];
					var data_limit = [
								l_limit[1],l_limit[2],l_limit[3],l_limit[4],l_limit[5],
								l_limit[6],l_limit[7],l_limit[8],l_limit[9],l_limit[10],l_limit[11],
								l_limit[12],l_limit[13],l_limit[14],l_limit[15],l_limit[16],l_limit[17],
								l_limit[18],l_limit[19],l_limit[20],l_limit[21],l_limit[22],l_limit[23],
								l_limit[24],l_limit[25],l_limit[26],l_limit[27],l_limit[28],l_limit[29],
								l_limit[30],l_limit[31],l_limit[32],l_limit[33],l_limit[34],l_limit[35],
								l_limit[36],l_limit[37],l_limit[38],l_limit[39],l_limit[40],l_limit[41],
								l_limit[42],l_limit[43],l_limit[44],l_limit[45],l_limit[46],l_limit[47],
								l_limit[48],l_limit[49],l_limit[50],l_limit[51],l_limit[52],l_limit[53]
						];
					var data_out = [
								l_out[1],l_out[2],l_out[3],l_out[4],l_out[5],
								l_out[6],l_out[7],l_out[8],l_out[9],l_out[10],l_out[11],
								l_out[12],l_out[13],l_out[14],l_out[15],l_out[16],l_out[17],
								l_out[18],l_out[19],l_out[20],l_out[21],l_out[22],l_out[23],
								l_out[24],l_out[25],l_out[26],l_out[27],l_out[28],l_out[29],
								l_out[30],l_out[31],l_out[32],l_out[33],l_out[34],l_out[35],
								l_out[36],l_out[37],l_out[38],l_out[39],l_out[40],l_out[41],
								l_out[42],l_out[43],l_out[44],l_out[45],l_out[46],l_out[47],
								l_out[48],l_out[49],l_out[50],l_out[51],l_out[52],l_out[53]
						];
					break;
				case "4":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_month;?>'
					var xaxis = '<?php echo $l_chk_graph_month;?>';
					var data_axis = ['<?php echo $l_January;?>', '<?php echo $l_February;?>', '<?php echo $l_March;?>', '<?php echo $l_April;?>', '<?php echo $l_May;?>', '<?php echo $l_June;?>', '<?php echo $l_July;?>', '<?php echo $l_August;?>', '<?php echo $l_September;?>', '<?php echo $l_October;?>', '<?php echo $l_November;?>', '<?php echo $l_December;?>' ]
					var data_in = [
								l_in[1],l_in[2],l_in[3],l_in[4],l_in[5],
								l_in[6],l_in[7],l_in[8],l_in[9],l_in[10],l_in[11],l_in[12]
						];
					var data_limit = [
								l_limit[1],l_limit[2],l_limit[3],l_limit[4],l_limit[5],
								l_limit[6],l_limit[7],l_limit[8],l_limit[9],l_limit[10],l_limit[11],l_limit[12]
						];
					var data_out = [
								l_out[1],l_out[2],l_out[3],l_out[4],l_out[5],
								l_out[6],l_out[7],l_out[8],l_out[9],l_out[10],l_out[11],l_out[12]
						];
					break;
				case "5":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_year;?>'
					var xaxis = '<?php echo $l_chk_graph_year;?>';
					var d = new Date();
					var n = d.getFullYear();
					var data_axis = [n+1,n,n-1,n-2];
					var data_in = [
								l_in[n+1],l_in[n],l_in[n-1],l_in[n-2]
						];
					var data_limit = [
								l_limit[n+1],l_limit[n],l_limit[n-1],l_limit[n-2]
						];
					var data_out = [
								l_out[n+1],l_out[n],l_out[n-1],l_out[n-2]
						];
					break;									
				}

				var option = {
		      title: {
		        text: title,
		        subtext: ''
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
						name: xaxis,
		        boundaryGap: false,
		        data: data_axis
		      }],
		      yAxis: [{
		        type: 'value',
						name: '<?php echo $l_devices;?>'
		      }],
			    series : [
			        {
			            name:'<?php echo $l_in;?>',
			            type:'line',
			            data:data_in,
			            markLine : {
			                data : [
			                    {type : 'average', name: 'Avg'}
			                ]
			            }
			        },
			        {
			            name:'<?php echo $l_limit;?>',
			            type:'line',
			            data:data_limit,
			            markLine : {
			                data : [
			                    {type : 'average', name : 'Avg'}
			                ]
			            }
			        },
			        {
			            name:'<?php echo $l_out;?>',
			            type:'line',
			            data:data_out,
			            markLine : {
			                data : [
			                    {type : 'average', name : 'Avg'}
			                ]
			            }
			        }
						]
		    };					
				var linechart = document.getElementById('echart_activity');
				var echartLine_act = echarts.init(linechart, theme);
		    echartLine_act.setOption(option);
			}
		</script>
		
		<script>
			function drawLineChartgraph_o(l_in_o, l_limit_o, l_out_o) {

				var radiochkgraph = $("input[name=radio_chkgraph]:checked", "#bigdata_select_form").val();
								
				switch (radiochkgraph) {
				case "0":
					var xaxis = '<?php echo $l_chk_graph_hour;?>';
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_hour;?>';
					var data_axis = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
					var data_in = [
								l_in_o[0],l_in_o[1],l_in_o[2],l_in_o[3],l_in_o[4],l_in_o[5],
								l_in_o[6],l_in_o[7],l_in_o[8],l_in_o[9],l_in_o[10],l_in_o[11],
								l_in_o[12],l_in_o[13],l_in_o[14],l_in_o[15],l_in_o[16],l_in_o[17],
								l_in_o[18],l_in_o[19],l_in_o[20],l_in_o[21],l_in_o[22],l_in_o[23]
						];
					var data_limit = [
								l_limit_o[0],l_limit_o[1],l_limit_o[2],l_limit_o[3],l_limit_o[4],l_limit_o[5],
								l_limit_o[6],l_limit_o[7],l_limit_o[8],l_limit_o[9],l_limit_o[10],l_limit_o[11],
								l_limit_o[12],l_limit_o[13],l_limit_o[14],l_limit_o[15],l_limit_o[16],l_limit_o[17],
								l_limit_o[18],l_limit_o[19],l_limit_o[20],l_limit_o[21],l_limit_o[22],l_limit_o[23]
						];
					var data_out = [
								l_out_o[0],l_out_o[1],l_out_o[2],l_out_o[3],l_out_o[4],l_out_o[5],
								l_out_o[6],l_out_o[7],l_out_o[8],l_out_o[9],l_out_o[10],l_out_o[11],
								l_out_o[12],l_out_o[13],l_out_o[14],l_out_o[15],l_out_o[16],l_out_o[17],
								l_out_o[18],l_out_o[19],l_out_o[20],l_out_o[21],l_out_o[22],l_out_o[23]
						];
					break;
				case "1":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_date;?>'
					var xaxis = '<?php echo $l_chk_graph_date;?>';
					var data_axis = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
					
					var data_in = [
								l_in_o[1],l_in_o[2],l_in_o[3],l_in_o[4],l_in_o[5],
								l_in_o[6],l_in_o[7],l_in_o[8],l_in_o[9],l_in_o[10],l_in_o[11],
								l_in_o[12],l_in_o[13],l_in_o[14],l_in_o[15],l_in_o[16],l_in_o[17],
								l_in_o[18],l_in_o[19],l_in_o[20],l_in_o[21],l_in_o[22],l_in_o[23],
								l_in_o[24],l_in_o[25],l_in_o[26],l_in_o[27],l_in_o[28],l_in_o[29],
								l_in_o[30],l_in_o[31]
						];
					var data_limit = [
								l_limit_o[1],l_limit_o[2],l_limit_o[3],l_limit_o[4],l_limit_o[5],
								l_limit_o[6],l_limit_o[7],l_limit_o[8],l_limit_o[9],l_limit_o[10],l_limit_o[11],
								l_limit_o[12],l_limit_o[13],l_limit_o[14],l_limit_o[15],l_limit_o[16],l_limit_o[17],
								l_limit_o[18],l_limit_o[19],l_limit_o[20],l_limit_o[21],l_limit_o[22],l_limit_o[23],
								l_limit_o[24],l_limit_o[25],l_limit_o[26],l_limit_o[27],l_limit_o[28],l_limit_o[29],
								l_limit_o[30],l_limit_o[31]
						];
					var data_out = [
								l_out_o[1],l_out_o[2],l_out_o[3],l_out_o[4],l_out_o[5],
								l_out_o[6],l_out_o[7],l_out_o[8],l_out_o[9],l_out_o[10],l_out_o[11],
								l_out_o[12],l_out_o[13],l_out_o[14],l_out_o[15],l_out_o[16],l_out_o[17],
								l_out_o[18],l_out_o[19],l_out_o[20],l_out_o[21],l_out_o[22],l_out_o[23],
								l_out_o[24],l_out_o[25],l_out_o[26],l_out_o[27],l_out_o[28],l_out_o[29],
								l_out_o[30],l_out_o[31]
						];
					break;
				case "2":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_weekday;?>'
					var xaxis = '<?php echo $l_chk_graph_weekday;?>';
					var data_axis = ['<?php echo $l_Mo;?>', '<?php echo $l_Tu;?>', '<?php echo $l_We;?>', 
					'<?php echo $l_Th;?>', '<?php echo $l_Fr;?>', '<?php echo $l_Sa;?>', '<?php echo $l_Su;?>']
					var data_in = [
								l_in_o[1],l_in_o[2],l_in_o[3],l_in_o[4],l_in_o[5],l_in_o[6],l_in_o[7]
						];
					var data_limit = [
								l_limit_o[1],l_limit_o[2],l_limit_o[3],l_limit_o[4],l_limit_o[5],l_limit_o[6],l_limit_o[7]
						];
					var data_out = [
								l_out_o[1],l_out_o[2],l_out_o[3],l_out_o[4],l_out_o[5],l_out_o[6],l_out_o[7]
						];
					break;
				case "3":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_weekly;?>'
					var xaxis = '<?php echo $l_chk_graph_weekly;?>';
					var data_axis = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,
						27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53];
					var data_in = [
								l_in_o[1],l_in_o[2],l_in_o[3],l_in_o[4],l_in_o[5],
								l_in_o[6],l_in_o[7],l_in_o[8],l_in_o[9],l_in_o[10],l_in_o[11],
								l_in_o[12],l_in_o[13],l_in_o[14],l_in_o[15],l_in_o[16],l_in_o[17],
								l_in_o[18],l_in_o[19],l_in_o[20],l_in_o[21],l_in_o[22],l_in_o[23],
								l_in_o[24],l_in_o[25],l_in_o[26],l_in_o[27],l_in_o[28],l_in_o[29],
								l_in_o[30],l_in_o[31],l_in_o[32],l_in_o[33],l_in_o[34],l_in_o[35],
								l_in_o[36],l_in_o[37],l_in_o[38],l_in_o[39],l_in_o[40],l_in_o[41],
								l_in_o[42],l_in_o[43],l_in_o[44],l_in_o[45],l_in_o[46],l_in_o[47],
								l_in_o[48],l_in_o[49],l_in_o[50],l_in_o[51],l_in_o[52],l_in_o[53]
						];
					var data_limit = [
								l_limit_o[1],l_limit_o[2],l_limit_o[3],l_limit_o[4],l_limit_o[5],
								l_limit_o[6],l_limit_o[7],l_limit_o[8],l_limit_o[9],l_limit_o[10],l_limit_o[11],
								l_limit_o[12],l_limit_o[13],l_limit_o[14],l_limit_o[15],l_limit_o[16],l_limit_o[17],
								l_limit_o[18],l_limit_o[19],l_limit_o[20],l_limit_o[21],l_limit_o[22],l_limit_o[23],
								l_limit_o[24],l_limit_o[25],l_limit_o[26],l_limit_o[27],l_limit_o[28],l_limit_o[29],
								l_limit_o[30],l_limit_o[31],l_limit_o[32],l_limit_o[33],l_limit_o[34],l_limit_o[35],
								l_limit_o[36],l_limit_o[37],l_limit_o[38],l_limit_o[39],l_limit_o[40],l_limit_o[41],
								l_limit_o[42],l_limit_o[43],l_limit_o[44],l_limit_o[45],l_limit_o[46],l_limit_o[47],
								l_limit_o[48],l_limit_o[49],l_limit_o[50],l_limit_o[51],l_limit_o[52],l_limit_o[53]
						];
					var data_out = [
								l_out_o[1],l_out_o[2],l_out_o[3],l_out_o[4],l_out_o[5],
								l_out_o[6],l_out_o[7],l_out_o[8],l_out_o[9],l_out_o[10],l_out_o[11],
								l_out_o[12],l_out_o[13],l_out_o[14],l_out_o[15],l_out_o[16],l_out_o[17],
								l_out_o[18],l_out_o[19],l_out_o[20],l_out_o[21],l_out_o[22],l_out_o[23],
								l_out_o[24],l_out_o[25],l_out_o[26],l_out_o[27],l_out_o[28],l_out_o[29],
								l_out_o[30],l_out_o[31],l_out_o[32],l_out_o[33],l_out_o[34],l_out_o[35],
								l_out_o[36],l_out_o[37],l_out_o[38],l_out_o[39],l_out_o[40],l_out_o[41],
								l_out_o[42],l_out_o[43],l_out_o[44],l_out_o[45],l_out_o[46],l_out_o[47],
								l_out_o[48],l_out_o[49],l_out_o[50],l_out_o[51],l_out_o[52],l_out_o[53]
						];
					break;
				case "4":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_month;?>'
					var xaxis = '<?php echo $l_chk_graph_month;?>';
					var data_axis = ['<?php echo $l_January;?>', '<?php echo $l_February;?>', '<?php echo $l_March;?>', '<?php echo $l_April;?>', '<?php echo $l_May;?>', '<?php echo $l_June;?>', '<?php echo $l_July;?>', '<?php echo $l_August;?>', '<?php echo $l_September;?>', '<?php echo $l_October;?>', '<?php echo $l_November;?>', '<?php echo $l_December;?>' ]
					var data_in = [
								l_in_o[1],l_in_o[2],l_in_o[3],l_in_o[4],l_in_o[5],
								l_in_o[6],l_in_o[7],l_in_o[8],l_in_o[9],l_in_o[10],l_in_o[11],l_in_o[12]
						];
					var data_limit = [
								l_limit_o[1],l_limit_o[2],l_limit_o[3],l_limit_o[4],l_limit_o[5],
								l_limit_o[6],l_limit_o[7],l_limit_o[8],l_limit_o[9],l_limit_o[10],l_limit_o[11],l_limit_o[12]
						];
					var data_out = [
								l_out_o[1],l_out_o[2],l_out_o[3],l_out_o[4],l_out_o[5],
								l_out_o[6],l_out_o[7],l_out_o[8],l_out_o[9],l_out_o[10],l_out_o[11],l_out_o[12]
						];
					break;
				case "5":
					var title = '<?php echo $l_checkdate_range_s." ".$l_chk_graph_year;?>'
					var xaxis = '<?php echo $l_chk_graph_year;?>';
					var d = new Date();
					var n = d.getFullYear();
					var data_axis = [n+1,n,n-1,n-2];
					var data_in = [
								l_in_o[n+1],l_in_o[n],l_in_o[n-1],l_in_o[n-2]
						];
					var data_limit = [
								l_limit_o[n+1],l_limit_o[n],l_limit_o[n-1],l_limit_o[n-2]
						];
					var data_out = [
								l_out_o[n+1],l_out_o[n],l_out_o[n-1],l_out_o[n-2]
						];
					break;									
				}

				var option = {
		      title: {
		        text: title,
		        subtext: ''
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
						name: xaxis,
		        boundaryGap: false,
		        data: data_axis
		      }],
		      yAxis: [{
		        type: 'value',
						name: '<?php echo $l_devices;?>'
		      }],
			    series : [
			        {
			            name:'<?php echo $l_in;?>',
			            type:'line',
			            data:data_in,
			            markLine : {
			                data : [
			                    {type : 'average', name: 'Avg'}
			                ]
			            }
			        },
			        {
			            name:'<?php echo $l_limit;?>',
			            type:'line',
			            data:data_limit,
			            markLine : {
			                data : [
			                    {type : 'average', name : 'Avg'}
			                ]
			            }
			        },
			        {
			            name:'<?php echo $l_out;?>',
			            type:'line',
			            data:data_out,
			            markLine : {
			                data : [
			                    {type : 'average', name : 'Avg'}
			                ]
			            }
			        }
						]
		    };					
				var linechart_o = document.getElementById('echart_activity_o');
				var echartLine_act_o = echarts.init(linechart_o);
		    echartLine_act_o.setOption(option);
			}
		</script>

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

		<script>
			function drawDoughnutChartdevices_o(brands_o, q_o) {				
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
				                {value:q_o[0], name:brands_o[0]},
				                {value:q_o[1], name:brands_o[1]},
				                {value:q_o[2], name:brands_o[2]},
				                {value:q_o[3], name:brands_o[3]},
				                {value:q_o[4], name:brands_o[4]},
				                {value:q_o[5], name:brands_o[5]},
				                {value:q_o[6], name:brands_o[6]},
				                {value:q_o[7], name:brands_o[7]},
				                {value:q_o[8], name:brands_o[8]},
				                {value:q_o[9], name:brands_o[9]}
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
				var dchart_o = document.getElementById('devices_o');
				var mydChart_o = echarts.init(dchart_o);
				mydChart_o.setOption(option);
			}
		</script>
    <!-- /Doughnut Chart -->

		<script type="text/javascript">
			$(document).ready(function() {
		    $('#bigdata_select_form').submit(function(e) {
	        e.preventDefault();

					NProgress.start();
					NProgress.set(0,4);

					var schemaid = $("#selClient").val();
					var countryid = $("#selCountry").val();
					var stateid = $("#selState").val();
					var cityid = $("#selCity").val();
					var locationid = $("#selLocation").val();
					var spotid = $("#selSpot").val();
					var sensorname = $("#selSensor").val();
					var groupby = $("#selGroupBy").val();
					var radiochkgraph = $("input[name=radio_chkgraph]:checked", "#bigdata_select_form").val();
					var statusid = $("#selStatus").val();
					var timefiltermin = $("#timefilter_min").val();
					var seltimefiltermin = $("#sel_timefilter_min").val();
					var timefiltermax = $("#timefilter_max").val();
					var seltimefiltermax = $("#sel_timefilter_max").val();
					var presence = $("#presence").val();
					var radiochkin = $("input[name=radio_chkin]:checked", "#bigdata_select_form").val();
					var date_s = $("#datestart").val();
					var date_e = $("#dateend").val();
					var date_s2 = $("#datestart2").val();
					var date_e2 = $("#dateend2").val();
					var time_s = $("#timestart").val();
					var time_e = $("#timeend").val();
					
					var radiochkdate = $("input[name=radio_checkdate]:checked", "#bigdata_select_form").val();

					var operatorid = <?php echo $operator_profile_id;?>;
					if (operatorid != 1) operatorid = <?php echo $operator_id;?>;

					if (timefiltermin != '') var timemin = timefiltermin * seltimefiltermin;
					else var timemin = 60;

					if (timefiltermax != '') var timemax = timefiltermax * seltimefiltermax;
					else var timemax = 86400;

					var brandlist = 0;
					if (radiochkin != 1) {
						b_list = $('select#brand_list').val();
						var brandlist = b_list.toString();
					}	

					document.getElementById('range_1a').innerHTML = date_s+' - '+date_e;											
					document.getElementById('range_2a').innerHTML = date_s2+' - '+date_e2;											
					document.getElementById('range_1b').innerHTML = date_s+' - '+date_e;											
					document.getElementById('range_2b').innerHTML = date_s2+' - '+date_e2;											
					document.getElementById('range_1c').innerHTML = date_s+' - '+date_e;											
					document.getElementById('range_2c').innerHTML = date_s2+' - '+date_e2;											

					$.ajax({
					  url: 'rest-api/dashboard/getBigData.php',
					  type: 'POST',
						data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid,
						sensor_name:sensorname, sel_timegroup:groupby, radio_chkgraph:radiochkgraph, idstatus:statusid, time_min:timemin, time_max:timemax, datestart:date_s, dateend:date_e, timestart:time_s, timeend:time_e, operator_id:operatorid, brand_list:brandlist, presence:presence},
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
							
							switch (radiochkgraph) {
							case "0":
								var val = 23;
								break;
							case "1":
								var val = 31;
								break;
							case "2":
								var val = 7;
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
							
							if (radiochkgraph == "0") {
								for (var z = 0; z<=val; z++) {
									g_in[z] = 0;
									g_limit[z] = 0;
									g_out[z] = 0;
								}									
							} else {
								if (radiochkgraph != "5") {
									for (var z = 1; z<=val; z++) {
										g_in[z] = 0;
										g_limit[z] = 0;
										g_out[z] = 0;
									}
								} else {
									var d = new Date();
									var n = d.getFullYear();
									for (var z = 0; z<=val; z++) {
										g_in[n-(z-1)] = 0;
										g_limit[n-(z-1)] = 0;
										g_out[n-(z-1)] = 0;
									}										
								}
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
							if (radiochkdate != "1") NProgress.done();
							
					  }
					});
					
					if (radiochkdate == "1") {

						$.ajax({
						  url: 'rest-api/dashboard/getBigData.php',
						  type: 'POST',
							data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid,
							sensor_name:sensorname, sel_timegroup:groupby, radio_chkgraph:radiochkgraph, idstatus:statusid, time_min:timemin, time_max:timemax, datestart:date_s2, dateend:date_e2, timestart:time_s, timeend:time_e, operator_id:operatorid, brand_list:brandlist, presence:presence},
						  dataType: 'json',
						  success:function(response) {

						    console.log(response);
								var len = response.length;
								var bd_o = 0;
								var bdin_o = 0;
								var bdqvin_o = 0;
								var totalacct_o = 0;
								var total_i_o = 0;
								var total_l_o = 0;
								var total_o_o = 0;
								var time_i_o = 0;
								var time_l_o = 0;
								var time_o_o = 0;
								var marca_o = [];
								var cant_o = [];
								var g_in_o = [];
								var g_limit_o = [];
								var g_out_o = [];
							
								switch (radiochkgraph) {
								case "0":
									var val = 23;
									break;
								case "1":
									var val = 31;
									break;
								case "2":
									var val = 7;
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
							
								if (radiochkgraph == "0") {
									for (var z = 0; z<=val; z++) {
										g_in_o[z] = 0;
										g_limit_o[z] = 0;
										g_out_o[z] = 0;
									}									
								} else {
									for (var z = 1; z<=val; z++) {
										g_in_o[z] = 0;
										g_limit_o[z] = 0;
										g_out_o[z] = 0;
									}									
								}

								for (var i = 0; i<len; i++) {

									var object = response[i];
									for (property in object) {
						        var value = object[property];
										if (value == 'bigdata') {
											bd_o = object['data'];
											document.getElementById('devicebd_o').innerHTML = Intl.NumberFormat().format(bd_o);
										}
										if (value == 'bigdatain') {
											bdin_o = object['data'];
											document.getElementById('devicebdin_o').innerHTML = Intl.NumberFormat().format(bdin_o);
											drawChartbigdata_o(bd_o, bdin_o);
										}
										if (value == 'bigdataqvin') {
											bdqvin_o = object['data'][0].total;
											document.getElementById('devicebdqvin_o').innerHTML = Intl.NumberFormat().format(bdqvin_o);
											document.getElementById('devicebdqvtin_o').innerHTML = object['data'][0].time;
											drawChartbigdataqvin_o(bd_o, bdqvin_o);
										}
										if (value == 'activity') {
											for (var x = 0; x<object['data'].length; x++) {
												var pos = object['data'][x].pos;
												switch (pos) {
													case "3":
														total_i_o = object['data'][x].total;
														time_i_o = object['data'][x].time;
														break;
													case "2":
														total_l_o = object['data'][x].total;
														time_l_o = object['data'][x].time;
														break;
													case "1":
														total_o_o = object['data'][x].total;
														time_o_o = object['data'][x].time;
														break;
												}
											}
											totalacct_o = parseInt(total_i_o) + parseInt(total_l_o) + parseInt(total_o_o);
											document.getElementById('totalacct_o').innerHTML = Intl.NumberFormat().format(totalacct_o);
											document.getElementById('in_o').innerHTML = Intl.NumberFormat().format(total_i_o);
											document.getElementById('totaltimeinvisits_o').innerHTML = time_i_o;
											document.getElementById('limit_o').innerHTML = Intl.NumberFormat().format(total_l_o);
											document.getElementById('totaltimelimitvisits_o').innerHTML = time_l_o;
											document.getElementById('out_o').innerHTML = Intl.NumberFormat().format(total_o_o);
											document.getElementById('totaltimeoutvisits_o').innerHTML = time_o_o;
											drawChartgraphstatus_o(total_i_o, total_l_o, total_o_o);
										}
										if (value == 'brand') {
											for (var x = 0; x<object['data'].length; x++) {
												marca_o[x] = object['data'][x].brand;
												cant_o[x] = object['data'][x].cant;
											}
											drawDoughnutChartdevices_o(marca_o, cant_o);
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
														g_in_o[day_part_act] = object['data'][x].in;
														break;
													case "2":
														g_limit_o[day_part_act] = object['data'][x].limit;
														break;
													case "1":
														g_out_o[day_part_act] = object['data'][x].out;
														break;
												}
											}
											drawLineChartgraph_o(g_in_o, g_limit_o, g_out_o);
										}
							    }
								}
								NProgress.done();																						
						  }							
						});
					}
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

    <!-- show-ranges -->
    <script>
			function showDaterange(){
				document.getElementById("daterange").style.display = 'block';
				document.getElementById("ratios_bigdata_o").style.display = 'block';
				document.getElementById("ratio_bd_o").style.display = 'block';
				document.getElementById("ratio_bdin_o").style.display = 'block';
				document.getElementById("qvisits_o").style.display = 'block';
				document.getElementById("graphics_o").style.display = 'block';
				document.getElementById("brands_o").style.display = 'block';
				document.getElementById("graph_acct_o").style.display = 'block';
			}
			function hideDaterange(){
				document.getElementById("daterange").style.display = 'none';
				document.getElementById("ratios_bigdata_o").style.display = 'none';
				document.getElementById("ratio_bd_o").style.display = 'none';
				document.getElementById("ratio_bdin_o").style.display = 'none';
				document.getElementById("qvisits_o").style.display = 'none';
				document.getElementById("graphics_o").style.display = 'none';
				document.getElementById("brands_o").style.display = 'none';
				document.getElementById("graph_acct_o").style.display = 'none';
			};
    </script>
    <!-- /show-ranges -->
				
  </body>
</html>
