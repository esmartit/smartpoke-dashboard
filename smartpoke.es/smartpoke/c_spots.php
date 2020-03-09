<?php

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_spots';

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
	$spot_id = '';
	$spot_name = '';
	$business_id = '%';
	$timestart = '00:00:00';
	$timestop = '23:59:59';
	$country_id = '35';
	$state_id = '%';
	$city_id = '%';
	$location_id = '%';
	$zip_code = '';

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
                <h3>Establecimientos / Spots</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_spot;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="spot_form" class="form-horizontal form-label-left" method="POST">

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
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12'>Spot ID <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id="id" type="hidden" name="id" class="form-control" value="">
	                          <input id='spot_id' type='text' name='spot_id' <?php echo $add_access;?> class='form-control' required="required">
	                        </div>
	                      </div> 
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12' ><?php echo $l_spot_name;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id='spot_name' type='text' name='spot_name' <?php echo $add_access;?> class='form-control' required="required">
	                        </div>
	                      </div> 
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12'><?php echo $l_business_type;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <select id='selBusiness' class='form-control' <?php echo $add_access;?> name='business_id'>
	                            <option value='%' selected="true" disabled="disabled"><?php echo $l_select_business;?></option></select>
	                        </div>
	                      </div>												
												<div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-6"><?php echo $l_timestart;?> <span class="required">*</span></label>
		                      <div class="col-md-3 col-sm-3 col-xs-3">
		                        <input id="timestart" type="text" name="timestart" <?php echo $add_access;?> class="form-control col-md-10" value='<?php echo $timestart;?>' required="required">
		                      </div>
		                      <label class="control-label col-md-3 col-sm-3 col-xs-6"><?php echo $l_timeend;?> <span class="required">*</span></label>
		                      <div class="col-md-3 col-sm-3 col-xs-3">
		                        <input id="timestop" type="text" name="timestop" <?php echo $add_access;?> class="form-control col-md-10" value='<?php echo $timestop;?>' required="required">
		                      </div>                    
		                    </div>
		                    <div class="form-group" style="display: none;">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_country;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selCountry" class="form-control" <?php echo $add_access;?> name="country_id">

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
			                      <select id="selState" class="form-control" <?php echo $add_access;?> name="state_id" onChange="showCity()">
				                      <option value="%"> <?php echo $l_all_states;?> </option>

		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_city;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selCity" class="form-control" <?php echo $add_access;?> name="city_id" onChange="showLocation()">
				                      <option value="%"> <?php echo $l_all_cities;?> </option>

		                        </select>
		                      </div>
		                    </div>
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_location;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
			                      <select id="selLocation" class="form-control" <?php echo $add_access;?> name="location_id" onChange="showZipCode()">
				                      <option value="%"> <?php echo $l_all_locations;?> </option>

		                        </select>
		                      </div>
		                    </div>
	                      <div class='form-group'>
	                        <label class='control-label col-md-3 col-sm-3 col-xs-12' ><?php echo $l_zip_code;?> <span class="required">*</span></label>
	                        <div class='col-md-6 col-sm-6 col-xs-12'>
	                          <input id='zip_code' type='text' name='zip_code' <?php echo $add_access;?> class='form-control' value='<?php echo $zip_code;?>' required="required">
	                        </div>
	                      </div> 
											</div>
											<!-- /form Spot -->

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
						</div>
            <div class="clearfix"></div>

            <div class="row">  
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_spots;?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="datatable_spotsList" class="table table-striped table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID </th> 
                            <th class="column-title"><?php echo $l_spot;?></th> 
                            <th class="column-title"><?php echo $l_spot_name;?></th> 
                            <th class='column-title'><?php echo $l_acctstarttime;?></th> 
                            <th class='column-title'><?php echo $l_acctstoptime;?></th>
                            <th class="column-title"><?php echo $l_business_type;?></th> 
                            <th class="column-title"><?php echo $l_state;?></th> 
                            <th class="column-title"><?php echo $l_city;?></th> 
                            <th class="column-title"><?php echo $l_location;?></th> 
                            <th class="column-title"><?php echo $l_zip_code;?></th> 
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
                showSpotsList('');
				showBusiness();
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

    <script>
		  function showClient() {

			$("#selClient").empty();
			$("#selClient").append("<option value='<?php echo $id_client;?>'><?php echo $c_name;?></option>");
		  }
    </script>



    <!-- /showState - City - Location - Zip Code -->
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
		  }	
    </script>
			
		<script>
		  function showCity() {
	  
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				
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
		  }	
    </script>
			
		<script>					
		  function showLocation() {
	  
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();

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
		  }			
    </script>

		<script>					
		  function showZipCode() {
	  
				var countryid = $("#selCountry").val();
				var stateid = $("#selState").val();
				var cityid = $("#selCity").val();
				var locationid = $("#selLocation").val();

				$.ajax({
					url: 'rest-api/general/getZipCode.php',
					type: 'POST',
					data: {idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid},
					dataType: 'json',
					success:function(response) {

						document.getElementById("zip_code").value = response[0].name;
					}
				});
		  }			
    </script>
    <!-- /showState - City - Location - Zip Code -->

    <!-- showBusiness Type -->
		<script>	
		  function showBusiness() {
	  
					$.ajax({
					url: 'rest-api/general/getBusiness.php',
					type: 'POST',
					dataType: 'json',
					success:function(response) {

						var len = response.length;

						$("#selBusiness").empty();
						$("#selBusiness").append("<option value='%' selected='true' disabled='disabled'><?php echo $l_select_business;?></option>");
						for (var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];

							$("#selBusiness").append("<option value='"+id+"'>"+name+"</option>");

						}
					}
				});
		  }			
    </script>
    <!-- /showBusiness Type -->
			
    <!-- showSpotsList -->
    <script>
		  function showSpotsList(spotid) {
//				var schemaid = $("#selClient").val();
				var schemaid = 'smartpoke';

				if (spotid == '') {
					document.getElementById("spot_name").value = '<?php echo $spot_name;?>';
					document.getElementById("timestart").value = '<?php echo $timestart;?>';
					document.getElementById("timestop").value = '<?php echo $timestop;?>';
					document.getElementById("selBusiness").value = '<?php echo $business_id;?>';
					document.getElementById("selState").value = '<?php echo $state_id;?>';
					document.getElementById("selCity").value = '<?php echo $city_id;?>';
					document.getElementById("selLocation").value = '<?php echo $location_id;?>';
					document.getElementById("zip_code").value = '<?php echo $zip_code;?>';
				}
				
				$.ajax({
					url: 'rest-api/settings/getSpotsList.php',
					type: 'GET',
					data: {schema:schemaid, spot_id:spotid},
					dataType: 'json',
					success:function(response) {

						result = response;
						if (spotid == '') {
							showSpotTable(result);							
						} else {
							showSpot(result);														
						}
					}
				});
		  }	
		</script>
    <!-- /showSpotssList -->

		<!-- showSpotTable -->
		<script>
			function showSpotTable(data) {
				$('#datatable_spotsList').DataTable({
					destroy: true,
					data: data,
					columns: [
		          { data: "id" },
		          { data: "spot_id" },
		          { data: "spot_name" },
		          { data: "timestart" },
		          { data: "timestop" },
		          { data: "business_type" },
		          { data: "state_name" },
		          { data: "city_name" },
		          { data: "location_name" },
		          { data: "zipcode" },
	            { 
								data: null, render: function ( data, type, row ) {
	                // Combine the first and last names into a single table field
									return '<button id="btn" class="btn btn-success btn-xs" onclick="editSpot('+data.id+')"><i class="fa fa-edit"></i></button>';
		            } 
							}
		      ],
          responsive: true						
				});
			}
		</script>
		<!-- /showSpotTable -->		

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
				$('#datatable_spotsList').DataTable();

		    $('#spot_form').submit(function(e) {
	        e.preventDefault();

					var id = $("#id").val();
					var schemaid = $("#selClient").val();
					var spotid = $("#spot_id").val();
					var spotname = $("#spot_name").val();
					var time_s = $("#timestart").val();
					var time_e = $("#timestop").val();
					var business = $("#selBusiness").val();
					var countryid = $("#selCountry").val();
					var stateid = $("#selState").val();
					var cityid = $("#selCity").val();
					var locationid = $("#selLocation").val();
					var zipcode = $("#zip_code").val();
					var type = 'I';
					if (id != '') type = 'U';

					$.ajax({
					  url: 'rest-api/settings/crudSpot.php',
					  type: 'POST',
						data: {schema:schemaid, spot_id:spotid, spot_name:spotname, timestart: time_s, timestop:time_e, business_id:business, idcountry:countryid, idstate:stateid, idcity:cityid, idlocation:locationid, zipcode:zipcode, action:type},
					  dataType: 'json',
					  success:function(response) {
					    console.log(response);
							
							document.getElementById('line_message').innerHTML = response.message+' '+spotid+' '+spotname;	
							showSpotsList('');						
						}
					});
				});
      });
    </script>
    <!-- /Datatables -->
		
   <!-- Edit Spot -->
	 <script>
		function editSpot(id) {
			var table = document.getElementById("datatable_spotsList");
			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {
						showSpotsList(id);						
			    };
			  }
			}
			document.getElementById("selClient").disabled = true;
			document.getElementById("spot_id").disabled = true;
		};

	 </script>
   <!-- /Edit Spot -->	

   <!-- Show Spot -->
	 <script>
		function showSpot(data) {
			document.getElementById("id").value = data[0].id;
			document.getElementById("spot_id").value = data[0].spot_id;
			document.getElementById("spot_name").value = data[0].spot_name;
			document.getElementById("timestart").value = data[0].timestart;
			document.getElementById("timestop").value = data[0].timestop;
			document.getElementById("selBusiness").value = data[0].business_id;
			document.getElementById("selState").value = data[0].state_id;
			document.getElementById("selCity").value = data[0].city_id;
			document.getElementById("selLocation").value = data[0].location_id;
			document.getElementById("zip_code").value = data[0].zipcode;
		};

	 </script>
   <!-- /Show Spot -->	

   <!-- Reset Form -->
	 <script>
		function resetForm() {				
			window.location="<?php echo $loginpath;?>";
		};
	 </script>
   <!-- /Reset Form -->			


  </body>
</html>