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
    $c_name = $_SESSION['c_name'];
	$lang = $_SESSION['lang'];
	$currDate = date('Y-m-d H:i:s');
	$currTime = date('H:i:s');

	$session_id = $_SESSION['id'];
	include('lang/main.php');
	include('library/pages_common.php');
	$show_access = opt_buttons($page, $operator_profile_id, 'show_btn');

  $radio_checkcampaign = '0';
	$checked_0 = 'checked';

  $datestart = date("Y-m-d", strtotime($currDate));
  $datestartspan = date("d M Y", strtotime($datestart));

	$datestart1 = date("Y-m-d", strtotime("-1 day", strtotime($currDate)));
	$datestartspan1 = date("d M Y", strtotime($datestart1));

	$dateend1 = date("Y-m-d", strtotime("-1 day", strtotime($currDate)));
	$dateendspan1 = date("d M Y", strtotime($dateend1));

	$datestart2 = date("Y-m-d", strtotime($currDate));
	$datestartspan2 = date("d M Y", strtotime($datestart2));

	$dateend2 = date("Y-m-d", strtotime($currDate));
	$dateendspan2 = date("d M Y", strtotime($dateend2));

  $timestart=$_SESSION['timestart'];
	$time_ini = (int)substr($timestart, 0, 2);

  $timeend=$currTime;
	$time_end = (int)substr($timeend, 0, 2);

	$timestart1=$_SESSION['timestart1'];
	$time_ini1 = (int)substr($timestart, 0, 2);

	$timeend1=$_SESSION['timeend1'];
	$time_end1 = (int)substr($timeend, 0, 2);

	$id_client = $client_id;
	$country_id = '35';
	$state_id = '%';
	$city_id = '%';
	$location_id = '%';
	$spot_id = '%';
	$sensor_name = '%';
  $spot_id_msg = '%';
  $message_id = '';
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
	$selected_m = '';
	$selected_h = '';
	$presence = '1';
	$brand_list = '';
	$radio_chkin = '1';
	$chk_in_1 = 'checked';

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
                <h3>SmartPoke Campaign / Communication</h3>
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
                    <form id="smartpoke_select_form" class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">

				              <!-- form select -->
				              <div class="col-md-6 col-sm-6 col-xs-12">

	                      <div class="form-group">
	                        <div class="col-md-9 col-sm-12 col-xs-12">
	                          <div class="radio">
	                            <label class="control-label col-md-3 co-sm-3 col-xs-3">
	                              <input type="radio" value="0" id="radio_checkcampaign0" <?php echo $checked_0;?> name="radio_checkcampaign" onClick="showOption0()"> On-Line
	                            </label>
	                            <label>
	                            </label>
	                            <label>
	                              <input type="radio" value="1" id="radio_checkcampaign1" name="radio_checkcampaign" onClick="showOption1()"> Off-Line
	                            </label>
	                            <label>
	                            </label>
	                            <label>
	                              <input type="radio" value="2" id="radio_checkcampaign2" name="radio_checkcampaign" onClick="showOption2()"> Data Base
	                            </label>
	                            <label>
	                            </label>
	                            <label>
	                              <input type="radio" value="3" id="radio_checkcampaign3" name="radio_checkcampaign" onClick="showOption3()"> .File
	                            </label>
	                          </div>													
	                        </div>
	                      </div>
												<fieldset id="OnLine">
			                    <div id="date_online" class="form-group">
														<label class="control-label col-md-3 co-sm-3 col-xs-3"><?php echo $l_select_date;?></label>
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
			                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
			                          <span><?php echo $datestartspan;?></span> <b class="caret"></b>
			                        </div>
			                      </div>
		                        <input type="hidden" name="datestart" id="datestart" value="<?php echo $datestart;?>" />
			                    </div>
													<div id="time_online" class="form-group">
			                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_hours;?></label>
			                      <div class="col-md-9 col-sm-9 col-xs-12">
				                      <div class="col-md-4 col-sm-6 col-xs-12">
				                        <input id="timestart" type="text" name="timestart" <?php echo $show_access;?> class="form-control col-md-10" value=<?php echo $timestart;?> />
				                      </div>
				                      <div class="col-md-4 col-sm-6 col-xs-12">
				                        <input id="timeend" type="text" name="timeend" disabled class="form-control col-md-10" >
				                      </div> 
														</div>
			                    </div>	
												</fieldset>	                    
		                    <div id="date_range" class="form-group" style="display:none">
													<label class="control-label col-md-3 co-sm-3 col-xs-3"><?php echo $l_select_date;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <div id="reportrange1" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		                          <span><?php echo $datestartspan1.' - '.$dateendspan1;?></span> <b class="caret"></b>
		                        </div>
		                      </div>
	                        <input type="hidden" name="datestart1" id="datestart1" value='<?php echo $datestart1;?>'/>
	                        <input type="hidden" name="dateend1" id="dateend1" value='<?php echo $dateend1;?>'>
		                    </div>
												<div id="time_range" class="form-group" style="display:none">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_hours;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <div class="col-md-4 col-sm-6 col-xs-12">
			                        <input id="timestart1" type="text" name="timestart1" <?php echo $show_access;?> class="form-control col-md-10" value=<?php echo $timestart;?> />
			                      </div>
			                      <div class="col-md-4 col-sm-6 col-xs-12">
			                        <input id="timeend1" type="text" name="timeend1" <?php echo $show_access;?> class="form-control col-md-10" value="23:59:59" />
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
												<fieldset id="OffLine">
			                    <div class="form-group" style="display: none;">>
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
														<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_spots_dl ?></label>
														<div class="col-md-9 col-sm-9 col-xs-12">
														  <select id="selSpot" class="form-control" <?php echo $show_access;?> name="spot_id" onChange="showSensor()">
																<option value="%"><?php echo $l_all_spot ?></option>
													
														  </select>
														</div>
												  </div>				  
												  <div id="sensors" class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_sensor ?></label>
														<div class="col-md-9 col-sm-9 col-xs-12">
														  <select id="selSensor" class="form-control" <?php echo $show_access;?> name="sensor_name">
																<option value="%"><?php echo $l_all_sensor ?></option>
													
														  </select>
														</div>
												  </div>
												</fieldset>
												<fieldset id="DataBase" style="display: none;">
												</fieldset>
												<fieldset id="File" style="display: none;">
			                    <div class="form-group">
			                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_import;?><span class="required">*</span></label>
			                      <div class="col-md-9 col-sm-9 col-xs-12">
															<input id="selFile" type="file" class="btn btn-primary" name="file_upload">
			                      </div>
			                    </div>                   
												</fieldset>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_spots_s;?><span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selSpotC" class="form-control" <?php echo $show_access;?> name="spot_id_msg" required="required" onChange="showCampaign()">
								              <option value="" selected="true" disabled="disabled"><?php echo $l_select_spot;?> </option>
														
								            </select>
		                      </div>
		                    </div>                   
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_message;?><span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="selCampaign" class="form-control" <?php echo $show_access;?> name="message_id" required="required">
								              <option value="" selected="true" disabled="disabled"><?php echo $l_select_message;?> </option>
														
		                        </select>
		                      </div>
		                    </div>
											</div>												
				              <!-- / select -->
				              <!-- filters -->
				              <div class="col-md-6 col-sm-6 col-xs-12">	
												<fieldset id="Filters">								
				                  <div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_select_status;?></label>
				                    <div class="col-md-6 col-sm-6 col-xs-12">
				                      <select id="selStatus" class="form-control" <?php echo $show_access;?> name="status_id">
				                        <option value="%" $selected_all><?php echo $l_all_select_status;?></option>
				                        <option value="IN" $selected_in><?php echo $l_in;?></option>
				                        <option value="LIMIT" $selected_limit><?php echo $l_limit;?></option>
				                        <option value="OUT" $selected_out><?php echo $l_out;?></option>
				                      </select>
				                    </div>
				                  </div>
			                    <div class="form-group">
			                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_time_ini;?></label>
			                      <div class="col-md-3 col-sm-3 col-xs-12">
			                        <input id="timefilter_min" type="text" name="timefilter_min" <?php echo $show_access;?> class="form-control col-md-6" value=<?php echo $timefilter_min;?> >
			                      </div>                    
			                      <div class="col-md-6 col-sm-6 col-xs-12">
			                        <select id="sel_timefilter_min" class="form-control" <?php echo $show_access;?> name="sel_timefilter_min">
			                          <option value="1" <?php echo $selected_s;?>><?php echo $l_seconds;?></option>
			                          <option value="60" <?php echo $selected_m;?>><?php echo $l_minutes;?></option>
			                          <option value="3600" <?php echo $selected_h;?>><?php echo $l_hours;?></option>
			                        </select>
			                      </div>
			                    </div>
			                    <div class='form-group'>
			                      <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_time_end;?></label>
			                      <div class='col-md-3 col-sm-3 col-xs-12'>
			                        <input id="timefilter_max" type='text' name='timefilter_max' <?php echo $show_access;?> class='form-control col-md-6' value=<?php echo $timefilter_max;?> >
			                      </div>                    
			                      <div class="col-md-6 col-sm-6 col-xs-12">
			                        <select id="sel_timefilter_max" class="form-control" <?php echo $show_access;?> name="sel_timefilter_max">
			                          <option value="1" <?php echo $selected_s;?>><?php echo $l_seconds;?></option>
			                          <option value="60" <?php echo $selected_m;?>><?php echo $l_minutes;?></option>
			                          <option value="3600" <?php echo $selected_h;?>><?php echo $l_hours;?></option>
			                        </select>
			                      </div>
			                    </div>
			                    <div id="date_range2" class="form-group">
														<label class="control-label col-md-3 co-sm-3 col-xs-3"><?php echo $l_select_date;?></label>
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <div id="reportrange2" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
			                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
			                          <span><?php echo $datestartspan2.' - '.$dateendspan2;?></span> <b class="caret"></b>
			                        </div>
			                      </div>
		                        <input type="hidden" name="datestart2" id="datestart2" value='<?php echo $datestart2;?>'/>
		                        <input type="hidden" name="dateend2" id="dateend2" value='<?php echo $dateend2;?>'>
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
																<input type="radio" value="2" <?php echo $chk_in_2;?> name="radio_chkin"><?php echo $l_select_in;?>
															  </label>
															</div>
													  </div>
													</div> 
												</fieldset>                       
											</div>
											<!-- /filters -->
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
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
    <!-- morris.js -->
    <script src="../vendors/raphael/raphael.min.js"></script>
    <script src="../vendors/morris.js/morris.min.js"></script>
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
				var countryid = '<?php echo $country_id?>';
				var check = '<?php echo $radio_checkcampaign;?>';

			  $('#selCountry option[value="'+countryid+'"]').prop('selected', true);
			  var evt = document.createEvent("HTMLEvents");
			  evt.initEvent("change", false, true);
			  document.getElementById('selCountry').dispatchEvent(evt);

			});

			document.getElementById("timeend").value = '<?php echo $currTime;?>'; 
			$("#selCountry").change(function() {
				showState();
			});
							
    </script>
		
    <script>
		  function showClient() {

			$("#selClient").empty();
			$("#selClient").append("<option value='<?php echo $id_client;?>'><?php echo $c_name;?></option>");
		  }
    </script>

    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {

        var datestart1;
        var dateend1;
        var datestart2;
        var dateend2;
				
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange1 span').html(start.format('<?php echo $l_dateformat;?>') + ' - ' + end.format('<?php echo $l_dateformat;?>'));
          datestart1 = start.format('YYYY-MM-DD');
          dateend1 = end.format('YYYY-MM-DD');
          $('#datestart1').val(datestart1);
          $('#dateend1').val(dateend1);
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

        $('#reportrange1').daterangepicker(optionSet1, cb);
        $('#reportrange1').on('show.daterangepicker', function() {
          console.log('show event fired');
        });
        $('#reportrange1').on('hide.daterangepicker', function() {
          console.log('hide event fired');
        });
        $('#reportrange1').on('apply.daterangepicker', function(ev, picker) {
          console.log('apply event fired, start/end dates are ' + picker.startDate.format('<?php echo $l_dateformat;?>') + ' to ' + picker.endDate.format('<?php echo $l_dateformat;?>'));
        });
        $('#reportrang1').on('cancel.daterangepicker', function(ev, picker) {
          console.log('cancel event fired');
        });
        $('#options1').click(function() {
          $('#reportrange1').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange1').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange1').data('daterangepicker').remove();
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
				showSensor();
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
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selSpot").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
				showSensor();
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
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selSensor").append("<option value='"+id+"'>"+name+"</option>");

						}
				  }
				});
				showSpotC();
		  }			
    </script>
    <!-- /showSpot - Sensor -->

    <!-- /showSpot - Campaign -->
    <script>
		  function showSpotC() {
	  
				var schemaid = $("#selClient").val();
				var countryid = $("#selCountry").val();
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

						$("#selSpotC").empty();
						$("#selSpotC").append("<option value='%' selected='true' disabled='disabled'><?php echo $l_select_spot;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selSpotC").append("<option value='"+id+"'>"+name+"</option>");

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
				var spotid = $("#selSpotC").val();
				var typeid = "V";
				
				$.ajax({
				  url: 'rest-api/settings/getCampaign.php',
				  type: 'POST',
					data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid, type:typeid},
				  dataType: 'json',
				  success:function(response) {

						var len = response.length;

						$("#selCampaign").empty();
						$("#selCampaign").append("<option value='%' selected='true' disabled='disabled'><?php echo $l_select_message;?></option>");
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

		<script>
			$(document).ready(function() {

		    $('#smartpoke_select_form').on('submit', function(e) {
	        e.preventDefault();

					NProgress.start();

					var radiocampaign = $("input[name=radio_checkcampaign]:checked", "#smartpoke_select_form").val();
					var schemaid = $("#selClient").val();
				  var spotmsgid = $("#selSpotC").val();
				  var messageid = $("#selCampaign").val();
					
					if (radiocampaign != "3") {
						var countryid = $("#selCountry").val();
						var stateid = $("#selState").val();
						var cityid = $("#selCity").val();
						var locationid = $("#selLocation").val();
						var spotid = $("#selSpot").val();	
						
						if (radiocampaign == "0" || radiocampaign == "1") {
							var sensorname = $("#selSensor").val();
							var statusid = $("#selStatus").val();
							var timefiltermin = $("#timefilter_min").val();
							var seltimefiltermin = $("#sel_timefilter_min").val();
							var timefiltermax = $("#timefilter_max").val();
							var seltimefiltermax = $("#sel_timefilter_max").val();
							var cant_presence = $("#presence").val();
							var radiochkin = $("input[name=radio_chkin]:checked", "#smartpoke_select_form").val();
							var date_s1 = $("#datestart").val();
							var date_e1 = $("#datestart").val();
							var time_s1 = $("#timestart").val();
							var time_e1 = $("#timeend").val();							
							var date_s2 = $("#datestart2").val();
							var date_e2 = $("#dateend2").val();
							
							if (radiocampaign == "1") {
								var date_s1 = $("#datestart1").val();
								var date_e1 = $("#dateend1").val();
								var time_s1 = $("#timestart1").val();
								var time_e1 = $("#timeend1").val();							
							}

							var timemin = 60;
							if (timefiltermin != '') timemin = timefiltermin * seltimefiltermin;

							var timemax = 86400;
							if (timefiltermax != '') timemax = timefiltermax * seltimefiltermax;

							var brandlist = 0;
							if (radiochkin != 1) {
								alert(radiochkin);
								b_list = $('select#brand_list').val();
								brandlist = b_list.toString();
							}	
						}						
					} 
					
					var operatorid = <?php echo $operator_profile_id;?>;
					if (operatorid != 1) operatorid = <?php echo $operator_id;?>;
									
					switch (radiocampaign) {
						case "0":

							NProgress.set(0.4);
 							$.ajax({
							  url: 'rest-api/dashboard/getSmartPokeOLine.php',
							  type: 'POST',
								data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid,
								sensor_name:sensorname, idstatus:statusid, time_min:timemin, time_max:timemax, datestart:date_s1, dateend:date_e1, timestart:time_s1, timeend:time_e1, datestart2:date_s2, dateend2:date_e2, operator_id:operatorid, brand_list:brandlist, presence:cant_presence, radio_campaign:radiocampaign},
							  dataType: 'json',
							  success:function(response) {

							    console.log(response);
							  }
							});
							NProgress.done();
							window.location="smartpokeOLine.php?schema="+schemaid+"&idspot="+spotid+"&sensor_name="+sensorname+"&spotmsg_id="+spotmsgid+"&message_id="+messageid;
							break;
						case "1":
							
							// alert('schema='+schemaid+'&idcountry='+countryid+'&idstate='+stateid+'&idcity='+cityid+'&idlocation='+locationid+'&idspot='+spotid+'&sensor_name='+sensorname+'&idstatus='+statusid+'&time_min='+timemin+'&time_max='+timemax+'&datestart='+date_s1+'&dateend='+date_e1+'&timestart='+time_s1+'&timeend='+time_e1+'&datestart2='+date_s2+'&dateend2='+date_e2+'&operator_id='+operatorid+'&brand_list='+brandlist+'&presence='+cant_presence+'&radio_campaign='+radiocampaign);


							NProgress.set(0.4);
 							$.ajax({
							  url: 'rest-api/dashboard/getSmartPokeOLine.php',
							  type: 'POST',
								data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid,
								sensor_name:sensorname, idstatus:statusid, time_min:timemin, time_max:timemax, datestart:date_s1, dateend:date_e1, timestart:time_s1, timeend:time_e1, datestart2:date_s2, dateend2:date_e2, operator_id:operatorid, brand_list:brandlist, presence:cant_presence, radio_campaign:radiocampaign},
							  dataType: 'json',
							  success:function(response) {

							    console.log(response);
							  }
							});
							NProgress.done();
							window.location="smartpokeOLine.php?schema="+schemaid+"&idspot="+spotid+"&sensor_name="+sensorname+"&spotmsg_id="+spotmsgid+"&message_id="+messageid;
							break;
						case "2":
							
 							$.ajax({
							  url: 'rest-api/dashboard/getSmartPokeDB.php',
							  type: 'POST',
								data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid, operator_id:operatorid},
							  dataType: 'json',
							  success:function(response) {

							    console.log(response);
							  }
							});
							NProgress.done();
							window.location="smartpokeDB.php?schema="+schemaid+"&spotmsg_id="+spotmsgid+"&message_id="+messageid;							
							break;
						case "3":

							var str = $('#smartpoke_select_form').serialize();
							var formFile = document.getElementById('selFile');
							var formFileJson = formFile.files[0];
							var formData = new FormData();
							formData.append('file', formFileJson);

							NProgress.set(0.4);
							$.ajax({
							  url: 'rest-api/dashboard/getSmartPokeFile.php', // point to server-side PHP script 
							  type: 'POST',
								data: formData,
							  cache: false,
							  contentType: false,
							  processData: false,
							  dataType: 'json',  // what to expect back from the PHP script, if anything
							  success: function(response){

						      console.log(response); // display response from the PHP script, if any
							  }
							});
							NProgress.done();
							window.location="smartpokeFile.php?schema="+schemaid+"&spotmsg_id="+spotmsgid+"&message_id="+messageid;						
							break;							
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

    <!-- /show-option -->
    <script>
			function showOption0(){
				document.getElementById("OnLine").style.display = 'block';
				document.getElementById("OffLine").style.display = 'block';
				document.getElementById("date_range").style.display = 'none';				
				document.getElementById("time_range").style.display = 'none';				
				document.getElementById("sensors").style.display = 'block';				
				document.getElementById("DataBase").style.display = 'none';
				document.getElementById("File").style.display = 'none';
				document.getElementById("Filters").style.display = 'block';
			}

			function showOption1(){
				document.getElementById("OnLine").style.display = 'none';
				document.getElementById("OffLine").style.display = 'block';
				document.getElementById("date_range").style.display = 'block';				
				document.getElementById("time_range").style.display = 'block';				
				document.getElementById("sensors").style.display = 'block';				
				document.getElementById("DataBase").style.display = 'none';
				document.getElementById("File").style.display = 'none';
				document.getElementById("Filters").style.display = 'block';
			}

			function showOption2(){
				document.getElementById("OnLine").style.display = 'none';
				document.getElementById("OffLine").style.display = 'block';
				document.getElementById("date_range").style.display = 'none';				
				document.getElementById("time_range").style.display = 'none';				
				document.getElementById("sensors").style.display = 'none';				
				document.getElementById("DataBase").style.display = 'block';
				document.getElementById("File").style.display = 'none';
				document.getElementById("Filters").style.display = 'none';
			}
			function showOption3(){
				document.getElementById("OnLine").style.display = 'none';
				document.getElementById("OffLine").style.display = 'none';
				document.getElementById("date_range").style.display = 'none';				
				document.getElementById("time_range").style.display = 'none';				
				document.getElementById("sensors").style.display = 'none';				
				document.getElementById("DataBase").style.display = 'none';
				document.getElementById("File").style.display = 'block';
				document.getElementById("Filters").style.display = 'none';
			}
    </script>
    <!-- /show-message -->
		
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
				} 
			} 

			setInterval(objTimer, 1000);
			objTimer();
			
		</script>		
  </body>
</html>
