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

  if (isset($_POST['sensor_name']))
    $sensor_name = $_POST['sensor_name'];
  elseif (isset($_GET['sensor_name']))
    $sensor_name = $_GET['sensor_name'];

  if (isset($_POST['sensor_location']))
    $sensor_location = $_POST['sensor_location'];
  elseif (isset($_GET['sensor_location']))
    $sensor_location = $_GET['sensor_location'];

  if (isset($_POST['pwr_in']))
    $pwr_in = $_POST['pwr_in'];
  elseif (isset($_GET['pwr_in']))
    $pwr_in = $_GET['pwr_in'];

  if (isset($_POST['pwr_limit']))
    $pwr_limit = $_POST['pwr_limit'];
  elseif (isset($_GET['pwr_limit']))
    $pwr_limit = $_GET['pwr_limit'];

  if (isset($_POST['pwr_out']))
    $pwr_out = $_POST['pwr_out'];
  elseif (isset($_GET['pwr_out']))
    $pwr_out = $_GET['pwr_out'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();
		
  if ($action == 'D') {

		$sql_select = "SELECT	COUNT(sensorname) FROM ".$esquema.".".$configValues['TBL_RWSENSORTOTAL']." ".
							    "WHERE spot_id = '$idspot' AND sensorname = '$sensor_name' LIMIT 1";
		$ret_select = pg_query($dbConnect, $sql_select);
		$row_select = pg_fetch_row($ret_select);
		if(!$ret_select) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else {			
			if ($row_select[0] > 0) $line_message = array("action" => "delete", "message" => $l_delete_deny.' '.$l_sensor);
			else {
		    $sql_del_sensor = "DELETE FROM ".$esquema.".".$configValues['TBL_RWSENSOR']." ".
													"WHERE spot_id = '$idspot' AND sensorname = '$sensor_name'";
				$ret_del_sensor = pg_query($dbConnect, $sql_del_sensor);
				if(!$ret_del_sensor) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "delete", "message" => $l_delete_message);
			}
		}
	} else {

    $sql_select_sensor = "SELECT spot_id, sensorname FROM ".$esquema.".".$configValues['TBL_RWSENSOR']." ".
							           "WHERE spot_id = '$idspot' AND sensorname = '$sensor_name'";
		$ret_select_sensor = pg_query($dbConnect, $sql_select_sensor);
		if(!$ret_select_sensor) $line_message = array("action" => "select", "message" => pg_last_error($dbConnect));
		else {
			$action = 'U';
	    if (pg_num_rows($ret_select_sensor) == 0) $action = 'I';

			if ($action == 'I') {
		      $sql_ins_sensor = "INSERT INTO ".$esquema.".".$configValues['TBL_RWSENSOR']." ".
													"(spot_id, sensorname, location, pwr_in, pwr_limit, pwr_out, creationdate, creationby, updatedate, updateby) ".
													"VALUES('$idspot', '$sensor_name', '$sensor_location', '$pwr_in', '$pwr_limit', '$pwr_out', '$currDate', '$operator_user', '$currDate', '$operator_user')";
				$ret_ins_sensor = pg_query($dbConnect, $sql_ins_sensor);
				if(!$ret_ins_sensor) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "insert", "message" => $l_insert_message);
			}

			if ($action == 'U') {
		      $sql_upd_sensor = "UPDATE ".$esquema.".".$configValues['TBL_RWSENSOR']." ".
													"SET location='$sensor_location', pwr_in='$pwr_in', pwr_limit='$pwr_limit', pwr_out='$pwr_out', updatedate = '$currDate', updateby='$operator_user' ".
													"WHERE spot_id='$idspot' AND sensorname = '$sensor_name'";
				$ret_upd_sensor = pg_query($dbConnect, $sql_upd_sensor);
				if(!$ret_upd_sensor) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "update", "message" => $l_update_message);
			}			
		}
	}

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
