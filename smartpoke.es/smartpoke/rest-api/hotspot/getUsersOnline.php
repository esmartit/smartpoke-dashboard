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

  $where_online = "(DATE(ra.acctstarttime) BETWEEN '$datestart' AND '$dateend') AND (ra.acctstoptime IS NULL OR cast(ra.acctstoptime as character varying) = '0000-00-00 00:00:00') AND ";

  include('../../library/opendb.php');
	$arr_usersonline = array(); // Array Users Online
	
  #----------------- total online ----------------------
  $sql_online = "SELECT ra.username, ui.firstname, ra.framedipaddress, ra.acctstarttime, ra.acctsessiontime, ".
                "ra.acctinputoctets AS upload, ra.acctoutputoctets AS download, hs.name AS hotspot ".
	                "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
	                "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
	                "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
								"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
	                "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
	                "WHERE ".$where_online." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
								"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
         "ORDER BY hotspot, ra.acctstarttime"; 
	$ret_online = pg_query($dbConnect, $sql_online);	
  while ($row_online = pg_fetch_row($ret_online)) {
    
		$totaltime = gmdate("H:i:s", $row_online[4]);
    $upload = toxbyte($row_online[5]);
    $download = toxbyte($row_online[6]);
    $totaltraffic = toxbyte($row_online[5] + $row_online[6]);
		// $traffic = '<b>'.$l_upload.':</b> '.$upload.'</br><b>'.$l_download.':</b> '.$download.'</br><b>'.$l_traffic.':</b> '.$totaltraffic;
		
		$arr_usersonline[] = array("username" => $row_online[0], "firstname" => $row_online[1], "ipaddress" => $row_online[2], "date" => $row_online[3], "time" => $totaltime, "traffic" => $totaltraffic, "hotspot" => $row_online[7]);
				
	}

  include('../../library/closedb.php');
  echo json_encode($arr_usersonline);
?>