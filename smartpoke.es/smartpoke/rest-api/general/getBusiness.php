<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $session_id = $_SESSION['id'];
  
  include('../../library/opendb.php');
	$sql_sel_business = "SELECT id, business_type FROM ".$configValues['TBL_RWBUSINESS'];
	$ret_sel_business = pg_query($dbConnect, $sql_sel_business);
	$business_arr = array(); //Business Array
	while ($row_business = pg_fetch_row($ret_sel_business)) {

    $business_id = $row_business[0];
    $business_name = $row_business[1];
    
    $business_arr[] = array("id" => $business_id, "name" => $business_name);
  }
  include('../../library/closedb.php');
  echo json_encode($business_arr);
?>
