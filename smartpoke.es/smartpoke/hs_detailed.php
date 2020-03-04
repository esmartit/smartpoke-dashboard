<?php
 	 
// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_detailed_hs';

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
                <h3><?php echo $l_details;?></h3>
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
                    <form id="detailed_select_form" class="form-horizontal form-label-left" method="POST" action='<?php echo $loginpath;?>'>

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
			                      <select id="selCity" class="form-control" <?php echo $show_access;?> disabled name="city_id" onChange="showLocation()">
				                      <option value="%"> <?php echo $l_all_cities;?> </option>

		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_location;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selLocation" class="form-control" <?php echo $show_access;?> disabled name="location_id" onChange="showHotSpot()">
				                      <option value="%"> <?php echo $l_all_locations;?> </option>

		                        </select>
		                      </div>
		                    </div>

											  <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_hotspot ?> <span class="required">*</span></label>
													<div class="col-md-9 col-sm-9 col-xs-12">
													  <select id="selHotSpot" class="form-control" name="hotspot_id" required="required">
															<option value="%"><?php echo $l_select_hotspot ?></option>
													
													  </select>
													</div>
											  </div>
	                      <div class="form-group">
	                        <label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $l_group_by." ".$l_username;?></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
	                          <div class="checkbox">
	                            <label>
	                              <input id="group_user" type="checkbox" class="iCheck">
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
                          <button id="btnCancel" type="submit" name="btnCancel" class="btn btn-primary" value="cancel" onclick="resetForm()"><?php echo $l_cancel;?></button>
                          <button id="btnSubmit" type="submit" name="btnSubmit" class="btn btn-success" <?php echo $show_access;?> value="submit" ><?php echo $l_search;?></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_details;?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable-detailed" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <!-- <th class='column-title'>ID</th> -->
                            <th class="column-title"><?php echo $l_hotspot;?></th>
                            <th class="column-title"><?php echo $l_username;?></th>
                            <th class='column-title'><?php echo $l_devicehashmac;?></th>
                            <!-- <th class="column-title"><?php echo $l_ipaddress;?></th> -->
                            <th class="column-title"><?php echo $l_starttime;?></th>
                            <th class="column-title"><?php echo $l_stoptime;?></th>
                            <th class="column-title"><?php echo $l_totaltime;?></th>
                            <th class='column-title'><?php echo $l_upload;?></th>
                            <th class='column-title'><?php echo $l_download;?></th>
                            <!-- <th class='column-title'><?php echo $l_terminatecause;?></th> -->
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
    <!-- DateJS -->
    <script src='../vendors/DateJS/build/date.js'></script>
    <!-- bootstrap-daterangepicker -->
    <script src='js/moment/moment.min.js'></script>
    <script src='js/datepicker/daterangepicker.js'></script>
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
						$("#selHotSpot").append("<option value='%' selected='true' disabled='disabled'><?php echo $l_select_hotspot;?></option>");
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
				$('#destroy').click(function() {
					$('#reportrange').data('daterangepicker').remove();
				});
			});
		</script>
		<!-- /bootstrap-daterangepicker -->

		<script>
			$(document).ready(function() {
				$('#datatable-detailed').DataTable();
		    $('#detailed_select_form').submit(function(e) {
	        e.preventDefault();

					var schemaid = $("#selClient").val();
					var countryid = $("#selCountry").val();
					var stateid = $("#selState").val();
					var cityid = $("#selCity").val();
					var locationid = $("#selLocation").val();
					var spotid = $("#selHotSpot").val();
					var date_s = $("#datestart").val();
					var date_e = $("#dateend").val();
					var checked = document.getElementById("group_user").checked;

					var checkuser = 0;
					if (checked) checkuser = 1;

					var operatorid = <?php echo $operator_profile_id;?>;
					if (operatorid != 1) operatorid = <?php echo $operator_id;?>;
					
					$.ajax({
					  url: 'rest-api/hotspot/getDetailed.php',
					  type: 'POST',
						data: {schema:schemaid, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, idspot:spotid,
						datestart:date_s, dateend:date_e, operator_id:operatorid, type:checkuser},
					  dataType: 'json',
					  success:function(response) {

					    console.log(response);
							showDetailed(response);
					  }
					});
				});
			});
		</script>

		<!-- showDetailed -->
		<script>
			function showDetailed(data) {
        var handleDataTableButtons = function() {
          if ($('#datatable-detailed').length) {
            $('#datatable-detailed').DataTable({
							destroy: true,
							data: data,
							columns: [
								// { data: "id"},
								{ data: "hotspot" },
			          { data: "username" },
			          { data: "devicehashmac" },
			          // { data: "ipaddress" },
			          { data: "starttime" },
			          { data: "stoptime" },
			          { data: "totaltime" },
			          { data: "upload" },
			          { data: "download" },
			          // { data: "terminatecause" },
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
          }
        };

        TableManageButtons = function() {
          'use strict';
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        TableManageButtons.init();
			};
		</script>
		<!-- /showDetailed -->		

   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			
	 
  </body>
</html>

