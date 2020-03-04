<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
	include ('../../library/checklogin.php');
	include('../../library/pages_common.php');
	
	$lang = $_SESSION['lang'];
	
	if ($lang == 'es') include('../../lang/es.php');
	else include('../../lang/en.php');

  if (isset($_POST['operator_id']))
		$operator_profile_id = $_POST['operator_id'];
  elseif (isset($_GET['operator_id']))
    $operator_profile_id = $_GET['operator_id'];

  if (isset($_POST['datestart'])) 
		$datestart = $_POST['datestart'];
  elseif (isset($_GET['datestart']))
    $datestart = $_GET['datestart'];

  if (isset($_POST['dateend'])) 
		$dateend = $_POST['dateend'];
  elseif (isset($_GET['dateend']))
    $dateend = $_GET['dateend'];	
	
	if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];
  
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

  if (isset($_POST['type']))
    $type = $_POST['type'];
  elseif (isset($_GET['type']))
    $type = $_GET['type'];

	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

	$where_spot = '';
	$where_spot_id2 = '';
	if ($idspot != '%') {
		$where_spot = "AND s.spot_id = '$idspot' ";															
		$where_spot_id2 = "WHERE spot_id = '$idspot'";															
	}

  include('../../library/opendb.php');
	$arr_detailed = array(); // Array HotSpot Detailed
	
  #----------------- Detailed HotSpot ----------------------
  $sql_detail = "SELECT hs.name AS hotspot, ra.username, callingstationid, ".
												"acctstarttime, acctstoptime, acctsessiontime, acctinputoctets, acctoutputoctets ".
								"FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
										"JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
										"JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
										"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
										"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
								"WHERE (DATE(ra.acctstarttime) BETWEEN '$datestart' AND '$dateend') AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
										"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
								"ORDER BY hotspot, ra.username"; 

  if ($type == 1) {
	  $sql_detail = "SELECT DISTINCT hs.name AS hotspot, ra.username, callingstationid, ".
													"MIN(acctstarttime), MAX(acctstoptime), SUM(acctsessiontime), SUM(acctinputoctets), SUM(acctoutputoctets) ".
									"FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
											"JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
											"JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
											"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
									"WHERE (DATE(ra.acctstarttime) BETWEEN '$datestart' AND '$dateend') AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
											"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
									"GROUP BY hs.name, ra.username, callingstationid ".
									"ORDER BY hotspot, ra.username"; 
  }
	$ret_detail = pg_query($dbConnect, $sql_detail);	
  while ($row_detail = pg_fetch_row($ret_detail)) {
    
    $hashmac = substr($row_detail[2], 9,8).'-'.hashmac($row_detail[3]);
		$totaltime = time2str($row_detail[5]);
    $upload = toxbyte($row_detail[6]);
    $download = toxbyte($row_detail[7]);

		$arr_detailed[] = array("hotspot" => $row_detail[0], "username" => $row_detail[1], "devicehashmac" => $hashmac, "starttime" => $row_detail[3],  "stoptime" => $row_detail[4], "totaltime" => $totaltime, "upload" => $upload, "download" => $download);
	}

  include('../../library/closedb.php');
  echo json_encode($arr_detailed);
?>