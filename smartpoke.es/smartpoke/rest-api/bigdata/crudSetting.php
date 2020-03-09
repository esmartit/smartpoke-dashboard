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
  
  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];
  
  if (isset($_POST['idspot']))
    $idspot = $_POST['idspot'];
  elseif (isset($_GET['idspot']))
    $idspot = $_GET['idspot'];

  if (isset($_POST['setting_name']))
    $setting_name = $_POST['setting_name'];
  elseif (isset($_GET['setting_name']))
    $setting_name = $_GET['setting_name'];

  if (isset($_POST['setting_value'])) 
    $setting_value = $_POST['setting_value'];
  elseif (isset($_GET['setting_value']))
    $setting_value = $_GET['setting_value'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {
    $sql_del_setting = "DELETE FROM ".$esquema.".".$configValues['TBL_RWSETTINGS']." ".
								      "WHERE spot_id = '$idspot' AND name = '$setting_name'";
		$ret_del_setting = pg_query($dbConnect, $sql_del_setting);
		if(!$ret_del_setting) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "delete", "message" => $l_delete_message);
	} else {
		
    $sql_select_setting = "SELECT spot_id, name FROM ".$esquema.".".$configValues['TBL_RWSETTINGS']." ".
								           "WHERE spot_id = '$idspot' AND name = '$setting_name'";
		$ret_select_setting = pg_query($dbConnect, $sql_select_setting);
		if(!$ret_select_setting) $line_message = array("action" => "select", "message" => pg_last_error($dbConnect));
		else {
			$action = 'U';
	    if (pg_num_rows($ret_select_setting) == 0) $action = 'I';

			if ($action == 'I') {
	      $sql_ins_setting = "INSERT INTO ".$esquema.".".$configValues['TBL_RWSETTINGS']." ".
														"(spot_id, name, value, creationdate, creationby, updatedate, updateby) ".
														"VALUES('$idspot', '$setting_name', '$setting_value', '$currDate', '$operator_user', '$currDate', '$operator_user')";
				$ret_ins_setting = pg_query($dbConnect, $sql_ins_setting);
				if(!$ret_ins_setting) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "insert", "message" => $l_insert_message);		
			}

			if ($action == 'U') {
	      $sql_upd_setting = "UPDATE ".$esquema.".".$configValues['TBL_RWSETTINGS']." ".
							             "SET value='$setting_value', updatedate='$currDate', updateby='$operator_user' ".
							             "WHERE spot_id = '$idspot' AND name = '$setting_name'";
				$ret_upd_setting = pg_query($dbConnect, $sql_upd_setting);
				if(!$ret_upd_setting) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "update", "message" => $l_update_message);		
			}			
		}
	}

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
