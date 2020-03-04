<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_id = $_SESSION['operator_id'];
  $operator_user = $_SESSION['operator_user'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $client_id = $_SESSION['client_id'];
  $lang = $_SESSION['lang'];
  $currDate = date('Y-m-d H:i:s');

  $session_id = $_SESSION['id'];
	if ($lang == 'es') include('../../lang/es.php');
	else include('../../lang/en.php');
  
  if (isset($_POST['business_id']))
    $business_id = $_POST['business_id'];
  elseif (isset($_GET['business_id']))
    $business_id = $_GET['business_id'];
  
  if (isset($_POST['business_type']))
    $business_type = $_POST['business_type'];
  elseif (isset($_GET['business_type']))
    $business_type = $_GET['business_type'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {
    $sql_del_business = "DELETE FROM ".$configValues['TBL_RWBUSINESS']." ".
										    "WHERE id = '$business_id'";
		$ret_del_business = pg_query($dbConnect, $sql_del_business);
		if(!$ret_del_business) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "delete", "message" => $l_delete_message);			
  } else {
		if ($action == 'I') {
      $sql_ins_business = "INSERT INTO ".$configValues['TBL_RWBUSINESS']." ".
													"(business_type, creationdate, creationby, updatedate, updateby) ".
													"VALUES('$business_type', '$currDate', '$operator_user', '$currDate', '$operator_user')";
			$ret_ins_business = pg_query($dbConnect, $sql_ins_business);
			if(!$ret_ins_business) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "insert", "message" => $l_insert_message);		
		}

		if ($action == 'U') {
      $sql_upd_business = "UPDATE ".$configValues['TBL_RWBUSINESS']." ".
													"SET business_type = '$business_type', updatedate = '$currDate', updateby='$operator_user' ".
													"WHERE id = '$business_id'";
			$ret_upd_business = pg_query($dbConnect, $sql_upd_business);
			if(!$ret_upd_business) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "update", "message" => $l_update_message);		
		}
  }

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
