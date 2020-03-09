<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['profile_id']))
    $profile_id = $_POST['profile_id'];
  elseif (isset($_GET['profile_id']))
    $profile_id = $_GET['profile_id'];
  
	$where_profile = '';			
	if ($profile_id != '') {
	  $where_profile = "WHERE id = $profile_id";
  }

  include('../../library/opendb.php');
	$data = array();

  $sql_profile = "SELECT id, profile, profile_name ".
								"FROM ".$configValues['TBL_RSPROFILES']." ".$where_profile;
  $ret_profile = pg_query($dbConnect, $sql_profile);
	if (pg_num_rows($ret_profile) > 0) $data = pg_fetch_all($ret_profile);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
