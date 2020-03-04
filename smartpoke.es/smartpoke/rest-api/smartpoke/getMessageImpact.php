<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

	include ('../../library/checklogin.php');
	include('../../library/pages_common.php');

	$session_id = $_SESSION['id'];

	if (isset($_POST['operator_id']))
			$operator_profile_id = $_POST['operator_id'];
	elseif (isset($_GET['operator_id']))
	  $operator_profile_id = $_GET['operator_id'];

	if (isset($_POST['schema']))
	  $esquema = $_POST['schema'];
	elseif (isset($_GET['schema']))
	  $esquema = $_GET['schema'];

	if (isset($_POST['idspotC']))
	  $idspotC = $_POST['idspotC'];
	elseif (isset($_GET['idspotC']))
	  $idspotC = $_GET['idspotC'];

	if (isset($_POST['message_id']))
	  $message_id = $_POST['message_id'];
	elseif (isset($_GET['message_id']))
	  $message_id = $_GET['message_id'];

	if (isset($_POST['datestart'])) 
		$datestart = $_POST['datestart'];
	elseif (isset($_GET['datestart']))
	  $datestart = $_GET['datestart'];

	if (isset($_POST['dateend'])) 
		$dateend = $_POST['dateend'];
	elseif (isset($_GET['dateend']))
	  $dateend = $_GET['dateend'];

	if (isset($_POST['idcountry']))
	  $idcountry = $_POST['idcountry'];
	elseif (isset($_GET['idcountry']))
	  $idcountry = $_GET['idcountry'];

	if (isset($_POST['idstate']))
	  $idstate = $_POST['idstate'];
	elseif (isset($_GET['idstate']))
	  $idstate = $_GET['idstate'];

	if (isset($_POST['idcity']))
	  $idcity = $_POST['idcity'];
	elseif (isset($_GET['idcity']))
	  $idcity = $_GET['idcity'];

	if (isset($_POST['idlocation']))
	  $idlocation = $_POST['idlocation'];
	elseif (isset($_GET['idlocation']))
	  $idlocation = $_GET['idlocation'];

	if (isset($_POST['idspot']))
	  $idspot = $_POST['idspot'];
	elseif (isset($_GET['idspot']))
	  $idspot = $_GET['idspot'];

	$arr_sms_target = array(); // SMS Target
	$arr_sms_users = array(); // SMS Users
	$arr_messages_table = array(); // Messages Table
	$arr_result = array(); // Result
  $arr_device_act = array(); // Total Activity - Status  
	$y = 0;
	
	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

	$where_hotspot = '';
	$where_spot = '';
	$where_spot_id2 = '';
	$where_userspot = '';
	if ($idspot != '%') {
		$where_hotspot = "WHERE spot_id = '$idspot' ";
		$where_spot = "AND spot_id = '$idspot' ";
		$where_spot_id2 = "WHERE spot_id = '$idspot' ";
		$where_userspot = "AND spot_id = '$idspot' ";															
	}

	$where_status = "";
	if ($status_id != '%') $where_status = "AND status = '$status_id' ";

  include('../../library/opendb.php');

	$totalrecord = 0;
	$totalin = 0;
	$totalusers = 0;
	$totalusersN = 0;
	$totalusersG = 0;

	$sql_activity = "SELECT COUNT(devicehashmac) ".
									"FROM ".$esquema.".".$configValues['TBL_RWSENSORTOTAL']." ".
									"WHERE (acctdate BETWEEN '$datestart' AND '$dateend') AND pos = 'IN' ".$where_spot." AND ".
									"devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) AND ".
									"CONCAT(devicemac, ':', LEFT(devicehashmac, 8)) IN (SELECT DISTINCT callingstationid ".
																						"FROM ".$esquema.".".$configValues['TBL_RWMESSAGESDETAIL']." AS md ".
																						"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = md.spot_id ".
																						"JOIN ".$esquema.".".$configValues['TBL_RSUSERDEVICE']." AS ud ON ud.username = md.username ".
																						"WHERE md.spot_id = '$idspotC' AND message_id = $message_id AND operator_id = '$operator_profile_id' AND access = 1 AND status = 0)";
	$ret_activity = pg_query($dbConnect, $sql_activity);
	$row_activity = pg_fetch_row($ret_activity);

	$totalin = $row_activity[0];

	$sql_msgdetail = "SELECT s.spot_name, m.name, username, acctstartdate, devicehashmac ".
									  "FROM ".$esquema.".".$configValues['TBL_RWMESSAGESDETAIL']." AS md ".
										"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = md.spot_id ".
										"JOIN ".$esquema.".".$configValues['TBL_RWMESSAGES']." AS m ON m.id = message_id ".
										"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = md.spot_id ".
					          "WHERE operator_id = '$operator_profile_id' AND access = 1 AND status = 0 ".
											"AND md.spot_id = '$idspotC' AND m.id = $message_id";
	$ret_msgdetail = pg_query($dbConnect, $sql_msgdetail);
	$ret_msg = pg_query($dbConnect, $sql_msgdetail);
	$totalrecord = pg_num_rows($ret_msgdetail);
	
	$arr_sms_target[] = array("total_sms" => $totalrecord, "total_in" => $totalin);

  while ($row_msg = pg_fetch_row($ret_msg)) {

		$devicehashmac = $row_msg[4];
		if ($row_msg[4] == '-1000000') $devicehashmac = '';
		
		$arr_messages_table[] = array("spot_id" => $row_msg[0], "campaign_name" => $row_msg[1], "username" => $row_msg[2], "device" => $devicehashmac, "date" => $row_msg[3]);			
  }
	
	$sql_mac_hs = "SELECT DISTINCT mac FROM ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ".$where_hotspot;
	$ret_mac_hs = pg_query($dbConnect, $sql_mac_hs);
	
  while ($row_mac_hs = pg_fetch_row($ret_mac_hs)) {
	  $hotspot_mac = $row_mac_hs[0];
	
		$sql_totusers = "SELECT COUNT(username) ".
									"FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." ".
									"WHERE creationby = '$hotspot_mac' AND creationdate < '$datestart 00:00:00' ".$where_userspot;
	  $ret_totuser = pg_query($dbConnect, $sql_totusers);
	  $row_totuser = pg_fetch_row($ret_totuser);
	  $totalusers = $totalusers + $row_totuser[0];
	
		$sql_usersN = "SELECT COUNT(username) ".
									"FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." ".
									"WHERE creationby = '$hotspot_mac' AND creationdate BETWEEN '$datestart 00:00:00' AND '$dateend 23:59:59' ".$where_userspot;										

	  $ret_usersN = pg_query($dbConnect, $sql_usersN);
	  $row_usersN = pg_fetch_row($ret_usersN);
	  $totalusersN = $totalusersN + $row_usersN[0];

		$sql_usersG = "SELECT COUNT(username) ".
									"FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." ".
									"WHERE creationby = '$hotspot_mac' AND creationdate BETWEEN '$datestart' AND '$dateend' ".$where_userspot." AND ".
									"username NOT IN (SELECT username FROM ".$esquema.".".$configValues['TBL_RWMESSAGESDETAIL']." AS md ".
																			"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = md.spot_id ".
																			"WHERE operator_id = '$operator_profile_id' AND access = 1 AND status = 0 AND ".
																				"md.spot_id = '$idspotC' AND message_id = $message_id)";
		$ret_usersG = pg_query($dbConnect, $sql_usersG);
		$row_usersG = pg_fetch_row($ret_usersG);
		$totalusersG = $totalusersG + $row_usersG[0];

	}
	$totaluserTN = $totalusersN - $totalusersG;
	
	$arr_sms_users[] = array("total_users" => $totalusers, "total_new_users" => $totalusersN, "total_new_target" => $totaluserTN, "total_users_guest" => $totalusersG);

	include('../../library/closedb.php');
  
	$arr_result[] = array("section" => 'target', "data" => $arr_sms_target);
	$arr_result[] = array("section" => 'users', "data" => $arr_sms_users);
	$arr_result[] = array("section" => 'table', "data" => $arr_messages_table);

	echo json_encode($arr_result);
													
?>
