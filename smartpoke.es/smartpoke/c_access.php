<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_access';
  $page2 = '$sb_operators';

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

  $esquema = $_SESSION['client_id'];
  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];

  if (isset($_POST['ope_id']))
    $ope_id = $_POST['ope_id'];
  elseif (isset($_GET['ope_id']))
    $ope_id = $_GET['ope_id'];
	else 
		$ope_id = $operator_id;
	
  include('library/pages_common.php');
  $add_access = opt_buttons($page, $operator_profile_id, 'add_btn');
  $edit_access = opt_buttons($page, $operator_profile_id, 'edit_btn');

  $btn_accesss = 0;
  if (($add_access == 1) || ($edit_access == 1)) {
    $btn_accesss = 1;
  }
  
  $enabled_ope='disabled';
  $where_client = "WHERE client = '$id_client'";
  if ($operator_profile_id == 1) {
    $enabled_ope='';
	  $where_client = '';
  }

  include('library/opendb.php');
	$sql_client = "SELECT	client FROM ".$configValues['TBL_RWCLIENT']." WHERE esquema = '$esquema'";
	$ret_client = pg_query($dbConnect, $sql_client);
	$row_client = pg_fetch_row($ret_client);
	$client = $row_client[0];

  $sql_spot = "SELECT spot_id, spot_name ".
         "FROM ".$esquema.".".$configValues['TBL_RWSPOT']." ";
	$ret_spot = pg_query($dbConnect, $sql_spot);
		 
  while ($row1 = pg_fetch_row($ret_spot)){
  
    $spot_id = $row1[0];
    $spot_name = $row1[1];

    $sql_sel_spotope = "SELECT * ".
           "FROM ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." ".
           "WHERE spot_id = '$spot_id' AND operator_id = '$ope_id'";
		$ret_sel_spotope = pg_query($dbConnect, $sql_sel_spotope);
		
    $sql_sel_ope = "SELECT * ".
           "FROM ".$configValues['TBL_RSOPERATORS']." ".
           "WHERE client = '$client' AND id = '$ope_id'";
		$ret_sel_ope = pg_query($dbConnect, $sql_sel_ope);
		
    if (pg_num_rows($ret_sel_spotope) == 0 && pg_num_rows($ret_sel_ope) == 1 && $ope_id != '%') {
                          
      $sql_ins_spotope = "INSERT INTO ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." ".
							"(spot_id, operator_id, access, creationdate, creationby, updatedate, updateby) ".
             "VALUES ('$spot_id', '$ope_id', 0, '$currDate', '$operator_user', '$currDate', '$operator_user') ";
			$ret_ins_spotope = pg_query($dbConnect, $sql_ins_spotope);
			if(!$ret_ins_spotope) {
	      $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
			}
    }
  } 
  include('library/closedb.php');
    
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
                <h3>Accesos / Access <small></small></h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_operator;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="access_form" enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">

											<!-- form Operators -->
				              <div class="col-md-6 col-sm-6 col-xs-12">
		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_clients;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <select id="selClient" class="form-control" name="id_client" onChange="showOperator()">
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
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $l_operator;?></label>
		                      <div class="col-md-9 col-sm-9 col-xs-12">
		                        <select id="selOperator" class="form-control" <?php echo $enabled_ope ;?> <?php echo $show_access;?> name="ope_id" onChange="showSpotOperatorsList(this.value, 'L')">
								              <option value="%" selected="true" disabled="disabled"><?php echo $l_select_operator;?> </option>
													
								            </select>
		                      </div>
		                    </div>
											</div>
											<!-- /form Access -->

                      <div class="form-group">
                      </div>
                      <div class="ln_solid"></div>

                    </form>
                  </div>
                </div>
              </div>

              <div class="clearfix"></div>

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
                      <table id="datatable_accessList" class="table table-striped table-bordered bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID </th>
                            <th class="column-title"><?php echo $l_spot;?> </th>                                   
														<th class="column-title"><?php echo $l_access;?></th>
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

		<script>
			$( window ).load(function() {
				var schema = '<?php echo $esquema;?>';
				if (schema != null && schema != '') {
					document.getElementById("selClient").value = '<?php echo $esquema;?>';
					showOperator();
					document.getElementById("selOperator").value = '<?php echo $ope_id;?>';
					document.getElementById("selClient").disabled = true;
				}				
			});	
		</script>
			
    <!-- showOperator -->
    <script>
		  function showOperator() {
	  
				var schemaid = $("#selClient").val();
				var opeid = '<?php echo $ope_id;?>';

				$.ajax({
					url: 'rest-api/settings/getOperator.php',
					type: 'POST',
					data: {schema:schemaid},
					dataType: 'json',
					success:function(response) {

						var len = response.length;
						$("#selOperator").empty();
						$("#selOperator").append("<option value='%' selected='true' disabled='disabled'><?php echo $l_select_operator;?></option>");
						for( var i = 0; i<len; i++) {
							var id = response[i]['id'];
							var name = response[i]['name'];
							
							if (opeid != null && opeid != '') {
								if (opeid == id) {
									$("#selOperator").append("<option value='"+id+"' selected='true'>"+name+"</option>");									
								}
							} else {
								$("#selOperator").append("<option value='"+id+"'>"+name+"</option>");								
							}
						}
					}
				});
				showSpotOperatorsList(opeid, 'L');
		  }	
		</script>
    <!-- /showOperator -->

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
				$('#datatable_accessList').DataTable();
      });
    </script>
    <!-- /Datatables -->

    <!-- showSpotOperatorsList -->
    <script>
		  function showSpotOperatorsList(opeid, type) {
				var schemaid = $("#selClient").val();
				
				$.ajax({
					url: 'rest-api/settings/getSpotOperatorsList.php',
					type: 'GET',
					data: {schema:schemaid, ope_id:opeid, type:type},
					dataType: 'json',
					success:function(response) {
						console.log(response);

						result = response;						
						if (type == 'L') {
							showSpotOperatorTable(result);														
						} else {
							checkValue(result);							
						}
					}
				});
		  }	
		</script>
    <!-- /showSpotOperatorsList -->

		<!-- showSpotOperatorTable -->
		<script>
			function showSpotOperatorTable(data) {
				$('#datatable_accessList').DataTable({
					destroy: true,
					data: data,
					columns: [
		          { data: "id" },
		          { data: "spot_name" },
							{ 
								data: null, render: function ( data, type, row ) {
	                // Combine the first and last names into a single table field
									if (data.access == '1') {
										// return '<button id="btn" class="btn btn-success btn-xs" onclick="checkAccess('+data.id+')"><i class="fa fa-check-circle"></i></button>';
										return '<button class="btn btn-success" onclick="checkAccess('+data.id+')"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>';
										
									} else {										
										// return '<button id="btn" class="btn btn-default btn-xs" onclick="checkAccess('+data.id+')"><i class="fa fa-times-circle"></i></button>';
										return '<button class="btn btn-primary" onclick="checkAccess('+data.id+')"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>';
									}
		            } 
							}
		      ],
          responsive: true						
				});
			}
		</script>
		<!-- /showSpotOperatorTable -->		

   <!-- checkAccess -->
	 <script>
		function checkAccess(id) {
			var table = document.getElementById("datatable_accessList");
			if (table) {
			  for (var i = 0; i < table.rows.length; i++) {
			    table.rows[i].onclick = function() {
						showSpotOperatorsList(id, 'C');						
			    };
			  }
			}
		};

	 </script>
   <!-- /checkAccess -->	

   <!-- checkValue -->
	 <script>
		function checkValue(data) {
			var schemaid = $("#selClient").val();
			var spotid = data[0].spot_id;
			var opeid = $("#selOperator").val();
			var check = data[0].access;

			$.ajax({
				url: 'rest-api/settings/crudSpotOperator.php',
				type: 'GET',
				data: {schema:schemaid, idspot:spotid, ope_id:opeid, access:check},
				dataType: 'json',
				success:function(response) {

					document.getElementById('line_message').innerHTML = response.message;	
				}
			});
			showSpotOperatorsList(opeid, 'L');						
		};

	 </script>
   <!-- /checkValue -->	
		
  </body>
</html>
