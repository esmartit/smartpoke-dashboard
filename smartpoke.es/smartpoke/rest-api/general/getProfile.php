<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $session_id = $_SESSION['id'];
  
  include('../../library/opendb.php');
	$sql_sel_profile = "SELECT id, profile_name FROM ".$configValues['TBL_RSPROFILES'];
	$ret_sel_profile = pg_query($dbConnect, $sql_sel_profile);
	$profile_arr = array(); //Profile Array
	while ($row_profile = pg_fetch_row($ret_sel_profile)) {

    $profile_id = $row_profile[0];
    $profile_name = $row_profile[1];
    
    $profile_arr[] = array("id" => $profile_id, "name" => $profile_name);
  }
  include('../../library/closedb.php');
  echo json_encode($profile_arr);
?>
