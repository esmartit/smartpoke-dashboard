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

  if (isset($_POST['topusertype']))
    $topusertype = $_POST['topusertype'];
  elseif (isset($_GET['topusertype']))
    $topusertype = $_GET['topusertype'];

	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

	$where_spot = '';
	if ($idspot != '%') {
		$where_spot = "AND s.spot_id = '$idspot' ";															
	}

  if ($topusertype == '1') {
    $orderby = "bandwidth DESC";
  } else {
    $orderby = "time DESC";
  }

  include('../../library/opendb.php');
	$arr_topuser = array(); // Array Last Connections
	
  #----------------- Top Users ----------------------
  $sql_topuser = "SELECT DISTINCT(ra.username), hs.name AS hotspot, MIN(acctstarttime), MAX(acctstoptime), ".
												"((DATE_PART('day', MAX(acctstoptime)::timestamp - MIN(acctstarttime)::timestamp) * 24 + 
					                DATE_PART('hour', MAX(acctstoptime)::timestamp - MIN(acctstarttime)::timestamp)) * 60 +
					                DATE_PART('minute', MAX(acctstoptime)::timestamp - MIN(acctstarttime)::timestamp)) * 60 +
					                DATE_PART('second', MAX(acctstoptime)::timestamp - MIN(acctstarttime)::timestamp) as time, ".                        
												"SUM(acctinputoctets) AS upload, SUM(acctoutputoctets) AS download, ".
                        "SUM(acctinputoctets+acctoutputoctets) AS bandwidth ". 
                 "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
									"JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
	                "JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = hs.spot_id ".
 		                "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
                 "WHERE (DATE(acctstarttime) BETWEEN '$datestart' AND '$dateend') AND cast(acctstoptime as character varying) > '0000-00-00 00:00:01' AND ".
											 "operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ". 
                 "GROUP BY ra.username, hs.name ".
                 "ORDER BY ".$orderby." LIMIT 10";
  $ret_topuser = pg_query($dbConnect, $sql_topuser);

  while ($row_topuser = pg_fetch_row($ret_topuser)) {
    
    $totaltime = time2str($row_topuser[4]);
    $upload = toxbyte($row_topuser[5]);
    $download = toxbyte($row_topuser[6]);
    $totaltraffic = toxbyte($row_topuser[5] + $row_topuser[6]);

		$arr_topuser[] = array("username" => $row_topuser[0], "hotspot" => $row_topuser[1], "starttime" => $row_topuser[2], "stoptime" => $row_topuser[3], "totaltime" => $totaltime, "bandwidth" => $totaltraffic, "upload" => $upload, "download" => $download);			
	}

  include('../../library/closedb.php');
  echo json_encode($arr_topuser);
?>