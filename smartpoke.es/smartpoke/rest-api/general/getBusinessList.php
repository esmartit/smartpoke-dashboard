<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['business_id']))
    $business_id = $_POST['business_id'];
  elseif (isset($_GET['business_id']))
    $business_id = $_GET['business_id'];
  
	$where_business = '';			
	if ($business_id != '') {
	  $where_business = "WHERE id = $business_id";
  }

  include('../../library/opendb.php');
	$data = array();

  $sql_businesstype = "SELECT id, business_type ".
											"FROM ".$configValues['TBL_RWBUSINESS']." ".$where_business;
	$ret_businesstype = pg_query($dbConnect, $sql_businesstype);
	if (pg_num_rows($ret_businesstype) > 0) $data = pg_fetch_all($ret_businesstype);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
