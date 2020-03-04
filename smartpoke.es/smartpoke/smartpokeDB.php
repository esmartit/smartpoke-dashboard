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

	$session_id = $_SESSION['id'];
	include('lang/main.php');

	include('library/pages_common.php');
	$show_access = opt_buttons($page, $operator_profile_id, 'show_btn');
	
  if (isset($_POST['schema'])) 
		$schema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $schema = $_GET['schema'];

  if (isset($_POST['spotmsg_id'])) 
		$spotmsg_id = $_POST['spotmsg_id'];
  elseif (isset($_GET['spotmsg_id']))
    $spotmsg_id = $_GET['spotmsg_id'];

  if (isset($_POST['message_id'])) 
		$message_id = $_POST['message_id'];
  elseif (isset($_GET['message_id']))
    $message_id = $_GET['message_id'];

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
                <h3>SmartPoke Campaign / Communication</h3>
              </div>
						</div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $l_users." - ".$l_hotspot;?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
										<form id="smartpokeDB_form" action="smartpokeDB.php" method="POST">
    
							        <div class="row">
							          <div class="col-md-12 col-sm-12 col-xs-12">
	                        <input type="hidden" name="schema" id="schema" value='<?php echo $schema;?>'/>
	                        <input type="hidden" name="spotmsg_id" id="spotmsg_id" value='<?php echo $spotmsg_id;?>'/>
	                        <input type="hidden" name="message_id" id="message_id" value='<?php echo $message_id;?>'/>													
							          </div>
							        </div>
							        <div class="row">

							          <div class="col-md-12 col-sm-12 col-xs-12">
							            <div class="x_panel">
							              <div class="x_title">
							                <h2><?php echo $l_users;?><small></small></h2>
							                <ul class="nav navbar-right panel_toolbox">
							                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							                </ul>
							                <div class="clearfix"></div>
							              </div>
							              <div class="x_content">
							                <div class="table-responsive">
						                    <table id="datatable-smartpoke" class="table table-striped table-bordered bulk_action">
							                    <thead>
							                      <tr>
																			<th><input type="checkbox" name= "select_all" id="smartpoke_select_all" value="1" /></th>
													            <th><?php echo $l_user_firstname;?></th>
													            <th><?php echo $l_user_lastname;?></th>
													            <th><?php echo $l_user_mobilephone;?></th>
													            <th><?php echo $l_email;?></th>
													            <th><?php echo $l_user_name;?></th>
													            <th><?php echo $l_hotspot;?></th>
																		</tr>
							                    </thead>
							                  </table>
							                </div>
														</div>
							            </div>
							          </div>
							        </div>
											<button id="btnSmartpoke"  name="btnSmartpoke" type="submit" <?php echo $show_access;?> class="btn btn-default" value="smartpoke"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></button>

											<pre id="example-console" style="display:none"></pre>
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
			$(document).ready(function (){
				var sessionid = '<?php echo $session_id;?>';
				var file = 'datatables/smartpokeDB-'+sessionid+'.json';
				var table = $('#datatable-smartpoke').DataTable({
						'destroy': true,
			      'ajax': file,  
			      'columnDefs': [{
			         'targets': 0,
			         'searchable':false,
			         'orderable':false,
			         'className': 'dt-body-center',
			         'render': function (data, type, full, meta){
								 return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
			         }
			      }],
			      'order': [1, 'asc']
			   });

			   // Handle click on "Select all" control
			   $('#smartpoke_select_all').on('click', function(){
			      // Check/uncheck all checkboxes in the table
			      var rows = table.rows({ 'search': 'applied' }).nodes();
			      $('input[type="checkbox"]', rows).prop('checked', this.checked);
			   });

			   // Handle click on checkbox to set state of "Select all" control
			   $('#datatable-smartpoke tbody').on('change', 'input[type="checkbox"]', function(){
			      // If checkbox is not checked
			      if(!this.checked){
			         var el = $('#smartpoke_select_all').get(0);
			         // If "Select all" control is checked and has 'indeterminate' property
			         if(el && el.checked && ('indeterminate' in el)){
			            // Set visual state of "Select all" control 
			            // as 'indeterminate'
			            el.indeterminate = true;
			         }
			      }
			   });
    
			   $('#smartpokeDB_form').on('submit', function(e){
			      var form = this;

			      // Iterate over all checkboxes in the table
			      table.$('input[type="checkbox"]').each(function(){
			         // If checkbox doesn't exist in DOM
			         if(!$.contains(document, this)){
			            // If checkbox is checked
			            if (this.checked) {
			               // Create a hidden element 
			               $(form).append(
			                  $('<input>')
			                     .attr('type', 'hidden')
			                     .attr('name', this.name)
			                     .val(this.value)
			               );
			            }
			         } 
			      });

			      // FOR TESTING ONLY
      
			      // Output form data to a console 
						var str = $(form).serialize();

            $("#line_message").empty();
						$.ajax({  
						    type: "POST",  
						    url: "sendSmartPoke.php",  
								data: str,
						    success: function(value) {  
						            $("#line_message").html(value);
						    }
						});
			      $('#example-console').text($(form).serialize());
			      console.log("Form submission", $(form).serialize());
       
			      // Prevent actual form submission
			      e.preventDefault();
			   });
				document.getElementById("smartpokeDB_form").reset(); 
			});
		</script>
  </body>
</html>

