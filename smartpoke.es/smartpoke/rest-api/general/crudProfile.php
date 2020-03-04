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
  
  if (isset($_POST['profile_id']))
    $profile_id = $_POST['profile_id'];
  elseif (isset($_GET['profile_id']))
    $profile_id = $_GET['profile_id'];
  
  if (isset($_POST['profile']))
    $profile = $_POST['profile'];
  elseif (isset($_GET['profile']))
    $profile = $_GET['profile'];

  if (isset($_POST['profile_name']))
    $profile_name = $_POST['profile_name'];
  elseif (isset($_GET['profile_name']))
    $profile_name = $_GET['profile_name'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {

    $sql_del_moprofile = "DELETE FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
							           "WHERE profile_id = $profile_id";
		$ret_del_moprofile = pg_query($dbConnect, $sql_del_moprofile);
		if(!$ret_del_moprofile) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else {
			
	    $sql_del_profile = "DELETE FROM ".$configValues['TBL_RSPROFILES']." ".
							           "WHERE id = $profile_id";
			$ret_del_profile = pg_query($dbConnect, $sql_del_profile);
			if(!$ret_del_profile) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "delete", "message" => $l_delete_message);			
		}
  } else {
		if ($action == 'I') {
      $sql_ins_profile = "INSERT INTO ".$configValues['TBL_RSPROFILES']." ".
													"(profile, profile_name, creationdate, creationby, updatedate, updateby) ".
													"VALUES('$profile', '$profile_name', '$currDate', '$operator_user', '$currDate', '$operator_user')";
			$ret_ins_profile = pg_query($dbConnect, $sql_ins_profile);
			if(!$ret_ins_profile) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "insert", "message" => $l_insert_message);		
		}

		if ($action == 'U') {
      $sql_upd_profile = "UPDATE ".$configValues['TBL_RSPROFILES']." ".
													"SET profile = '$profile', profile_name = '$profile_name', updatedate = '$currDate', updateby='$operator_user' ".
													"WHERE id = '$profile_id'";
			$ret_upd_profile = pg_query($dbConnect, $sql_upd_profile);
			if(!$ret_upd_profile) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "update", "message" => $l_update_message);		
		}
  }

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
