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
	if ($idspot != '%') {
		$where_spot = "AND s.spot_id = '$idspot' ";															
	}

  include('../../library/opendb.php');
	$arr_comparative = array(); // Array Comparative
	$arr_weekly = array(); // Array Weekly
	$arr_result = array(); // Array Result
	
  #----------------- Comparative ----------------------
  $sql_comp = "SELECT hs.name AS hotspot, COUNT(DISTINCT(username)) AS uniqueusers, COUNT(radacctid) AS totalhits, ".
                      "SUM(acctsessiontime) AS totaltime, SUM(acctinputoctets) AS sumInputOctets, SUM(acctoutputoctets) AS sumOutputOctets ".
	            "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
							"JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
	            "JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = hs.spot_id ".
	                "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
	            "WHERE (DATE(acctstarttime) BETWEEN '$datestart' AND '$dateend') AND ".
									 "operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
										$where_state." ".$where_city." ".$where_location." ".$where_spot." ". 
              "GROUP BY hs.name ";
  $ret_comp = pg_query($dbConnect, $sql_comp);
	
  while($row_comp = pg_fetch_row($ret_comp)) {

    $totaltime = time2str($row_comp[3]);
    $upload = toxbyte($row_comp[4]);
    $download = toxbyte($row_comp[5]);

		$arr_comparative[] = array("hotspot" => $row_comp[0], "uniqueusers" => $row_comp[1], "totaltime" => $totaltime, "upload" => $upload, "download" => $download);
  }
	
	
  #----------------- Weekly ----------------------
  $sql_weekly = "SELECT hs.name AS hotspot, DATE_PART('year', acctstarttime) AS year, DATE_PART('week', acctstarttime) AS week, ".
								"SUM(acctinputoctets) AS sumInputOctets, SUM(acctoutputoctets) AS sumOutputOctets ".
                  "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
 									"JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
 	                "JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = hs.spot_id ".
  		                "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
                  "WHERE (DATE(acctstarttime) BETWEEN '$datestart' AND '$dateend') AND ".
 											 "operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
 												$where_state." ".$where_city." ".$where_location." ".$where_spot." ". 
                "GROUP BY hs.name, year, week ";
  $ret_weekly = pg_query($dbConnect, $sql_weekly);
	
  while($row_weekly = pg_fetch_row($ret_weekly)) {

    $upload = toxbyte($row_weekly[3]);
    $download = toxbyte($row_weekly[4]);
		
		$arr_weekly[] = array("hotspot" => $row_weekly[0], "year" => $row_weekly[1], "week" => $row_weekly[2], "upload" => $upload, "download" => $download);
  }
	
  include('../../library/closedb.php');
	$arr_result[] = array("section" => "comparative", "data" => $arr_comparative);
	$arr_result[] = array("section" => "weekly", "data" => $arr_weekly);

  echo json_encode($arr_result);
?>