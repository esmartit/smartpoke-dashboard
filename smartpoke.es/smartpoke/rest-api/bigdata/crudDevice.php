<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');
  include('../../library/pages_common.php');

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

  if (isset($_POST['device_mac']))
    $device_mac = strtoupper($_POST['device_mac']);
  elseif (isset($_GET['device_mac']))
    $device_mac = strtoupper($_GET['device_mac']);

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();
		
  if ($action == 'D') {

    $sql_del_device = "DELETE FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." ".
								      "WHERE spot_id = '$idspot' AND devicemac = '$device_mac'";
		$ret_del_device = pg_query($dbConnect, $sql_del_device);
		if(!$ret_del_device) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "delete", "message" => $l_delete_message);
	} else {

    $device_hashmac = substr($device_mac, 9,17).'-'.hashmac($device_mac);
		if ($action == 'I') {
      $sql_ins_device = "INSERT INTO ".$esquema.".".$configValues['TBL_RWDEVICES']." ".
												"(spot_id, devicemac, devicehashmac, creationdate, creationby, updatedate, updateby) ".
												"VALUES('$idspot', '$device_mac', '$device_hashmac', '$currDate', '$operator_user', '$currDate', '$operator_user' )";
			$ret_ins_device = pg_query($dbConnect, $sql_ins_device);
			if(!$sql_ins_device) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "insert", "message" => $l_insert_message);
		}

		if ($action == 'U') {
      $sql_upd_device = "UPDATE ".$esquema.".".$configValues['TBL_RWDEVICES']." ".
												"SET devicemac='$device_mac', devicehashmac='$device_hashmac', updatedate = '$currDate', updateby='$operator_user' ".
									      "WHERE spot_id = '$idspot' AND devicemac = '$device_mac'";
			$ret_upd_device = pg_query($dbConnect, $sql_upd_device);
			if(!$ret_upd_device) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "update", "message" => $l_update_message);
		}
	}

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
