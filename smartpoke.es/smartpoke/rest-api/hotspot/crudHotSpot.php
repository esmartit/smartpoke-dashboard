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
    
  if (isset($_POST['hotspot_id']))
    $hotspot_id = $_POST['hotspot_id'];
  elseif (isset($_GET['hotspot_id']))
    $hotspot_id = $_GET['hotspot_id'];

  if (isset($_POST['hotspot_name']))
    $hotspot_name = $_POST['hotspot_name'];
  elseif (isset($_GET['hotspot_name']))
    $hotspot_name = $_GET['hotspot_name'];

  if (isset($_POST['hotspot_mac']))
    $hotspot_mac = $_POST['hotspot_mac'];
  elseif (isset($_GET['hotspot_mac']))
    $hotspot_mac = $_GET['hotspot_mac'];

  if (isset($_POST['hotspot_geocode']))
    $hotspot_geocode = $_POST['hotspot_geocode'];
  elseif (isset($_GET['hotspot_geocode']))
    $hotspot_geocode = $_GET['hotspot_geocode'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {
		$sql_delete_hotspot = "SELECT	* FROM ".$esquema.".".$configValues['TBL_RADACCT']." ".
											    "WHERE calledstationid = '$hotspot_mac' LIMIT 1";
		$ret_delete_hotspot = pg_query($dbConnect, $sql_delete_hotspot);
		$row_delete_hotspot = pg_num_rows($ret_delete_hotspot);

		if(!$ret_delete_hotspot) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else {

			if ($row_delete_hotspot >= 1) $line_message = array("action" => "delete", "message" => $l_delete_deny.' '.$l_hotspot);
			else {
		    $sql_del = "DELETE FROM ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." ".
										"WHERE spot_id = '$idspot' AND mac = '$hotspot_mac'";
				$ret_del = pg_query($dbConnect, $sql_del);
				if(!$ret_del) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "delete", "message" => $l_delete_message);			
			}					
		}
  } else {
    $sql_sel_hotspot = "SELECT spot_id, mac FROM ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." ".
						           "WHERE spot_id = '$idspot' AND mac = '$hotspot_mac'";
		$ret_sel_hotspot = pg_query($dbConnect, $sql_sel_hotspot);
		if(!$ret_sel_hotspot) $line_message = array("action" => "select", "message" => pg_last_error($dbConnect));
		else {
			
			$action = 'U';
	    if (pg_num_rows($ret_sel_hotspot) == 0) $action = 'I';

			if ($action == 'I') {
	      $sql_ins_hs = "INSERT INTO ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." ".
											"(spot_id, name, mac, geocode, creationdate, creationby, updatedate, updateby) ".
											"VALUES('$idspot', '$hotspot_name', '$hotspot_mac', '$hotspot_geocode', '$currDate', '$operator_user', '$currDate', '$operator_user')";
				$ret_ins_hs = pg_query($dbConnect, $sql_ins_hs);
				if(!$ret_ins_hs) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "insert", "message" => $l_insert_message);
			}

			if ($action == 'U') {
	      $sql_upd_hs = "UPDATE ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." ".
					             "SET name='$hotspot_name', geocode='$hotspot_geocode', updatedate = '$currDate', updateby='$operator_user' ".
					             "WHERE spot_id = '$idspot' AND mac = '$hotspot_mac'";
				$ret_upd_hs = pg_query($dbConnect, $sql_upd_hs);
				if(!$ret_upd_hs) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "update", "message" => $l_update_message);
			}
		}
  }

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
