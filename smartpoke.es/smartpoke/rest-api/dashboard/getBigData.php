<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

	include ('../../library/checklogin.php');
	include('../../library/pages_common.php');

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

  if (isset($_POST['timestart'])) 
		$timestart = $_POST['timestart'];
	elseif (isset($_GET['timestart']))
		$timestart = $_GET['timestart'];
	$time_ini = (int)substr($timestart, 0, 2);
		
  if (isset($_POST['timeend'])) 
		$timeend = $_POST['timeend'];
	elseif (isset($_GET['timeend']))
		$timeend = $_GET['timeend'];
	$time_end = (int)substr($timeend, 0, 2);
  
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
	
  if (isset($_POST['sensor_name'])) 
		$sensor_name = $_POST['sensor_name'];  	
  elseif (isset($_GET['sensor_name'])) 
		$sensor_name = $_GET['sensor_name'];
	
  if (isset($_POST['sel_timegroup']))
    $timevisit = $_POST['sel_timegroup'];
  elseif (isset($_GET['sel_timegroup']))
    $timevisit = $_GET['sel_timegroup'];	  	

  if (isset($_POST['radio_chkgraph'])) 
    $radio_chkgraph = $_POST['radio_chkgraph'];
	elseif (isset($_GET['radio_chkgraph']))
    $radio_chkgraph = $_GET['radio_chkgraph'];
	
  if (isset($_POST['idstatus'])) 
		$status_id = $_POST['idstatus'];
  elseif (isset($_GET['idstatus'])) 
		$status_id = $_GET['idstatus'];
  
  switch($status_id) {        
    case "IN":
			$where_pos = "AND pos_hour = 3 "; 
      break;
    case "LIMIT":
			$where_pos = "AND pos_hour = 2 "; 
      break;
    case "OUT":
			$where_pos = "AND pos_hour = 1 "; 
      break;
    default:
			$where_pos = ""; 			
      break;
  }

  if (isset($_POST['time_min']))
    $time_min = $_POST['time_min'];
  elseif (isset($_GET['time_min']))
    $time_min = $_GET['time_min'];

  if (isset($_POST['time_max']))
    $time_max = $_POST['time_max'];
  elseif (isset($_GET['time_max']))
    $time_max = $_GET['time_max'];

  include('../../library/opendb.php');

	// Filter Time min and max
	$filter_time = '';
	if (($time_min != 60) || ($time_max != 86400)) {
	  $filter_time = "AND devicehashmac IN (SELECT devicehashmac FROM ".$esquema.".sensor_acct_aggregate_view ".
			"WHERE (acctstartdate BETWEEN '$datestart' AND '$dateend') ".
			"GROUP BY acctstartdate, devicehashmac ".
			"HAVING sum($timevisit) >= $time_min AND sum($timevisit) <= $time_max) ";
	}

  if (isset($_POST['presence']))
    $presence = $_POST['presence'];
  elseif (isset($_GET['presence']))
    $presence = $_GET['presence'];	

	// Filter Presence
	$filter_presence = '';
	if ($presence > 1) {		
		$filter_presence = "AND devicehashmac IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWSENSORTOTAL']." ".
			"WHERE (acctdate BETWEEN '$datestart' AND '$dateend') AND pos = 'TOTAL' ".
			"GROUP BY devicehashmac ".
			"HAVING SUM(numto) >= $presence) ";
	}

	if (isset($_POST['brand_list'])) 
		$brand_list = $_POST['brand_list'];
	elseif (isset($_GET['brand_list'])) 
		$brand_list = $_GET['brand_list'];

	$sql_provider_list = "";
  if ($brand_list != "0") {
		$x = array(",");
		$y = array("','");
		$provider = str_replace($x, $y, $brand_list);
		$sql_provider_list = "AND brand IN ('$provider') ";  	
  }

	$time_ini = (int)substr($timestart, 0, 2);
	$time_end = (int)substr($timeend, 0, 2);

	$arr_activity = array(); // Activity
	$arr_brands = array(); // Brands
	$arr_graph = array(); // Graph

  $arr_online = array(); // Online Array
		
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

	$where_sensor = "";
	if ($sensor_name != '%') $where_sensor = "AND sensorname = '$sensor_name'";

	$device_bd = 0;
	#----------------- total bigdata ----------------------
	$sql_device_bd = 		"SELECT DISTINCT devicehashmac ".
								      "FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id ".	
											"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
											"WHERE operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".
												"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)";
  $ret_device_bd = pg_query($dbConnect, $sql_device_bd);
	if (pg_num_rows($ret_device_bd) > 0) $device_bd = pg_num_rows($ret_device_bd);
	

	#----------------- total bigdata IN ----------------------
	$sql_device_bdin = "SELECT DISTINCT devicehashmac ".
								      "FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
															$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
											"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".
												"AND pos_hour = 3 AND (acctstartdate BETWEEN '$datestart' AND '$dateend') ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)";
  $ret_device_bdin = pg_query($dbConnect, $sql_device_bdin);
	$device_bdin = 0;
  if (pg_num_rows($ret_device_bdin) >= 1) $device_bdin = pg_num_rows($ret_device_bdin);

	$sql_activity = "with aggregate_view AS ".
		 							"(SELECT DISTINCT acctstartdate, devicehashmac, MAX(pos_hour) ".
											"OVER (PARTITION BY acctstartdate, devicehashmac) AS pos_day, ".
											"SUM($timevisit) ".
											"OVER (PARTITION BY acctstartdate, devicehashmac) AS time_day ".
									"FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
													$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
									"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
										$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
										"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') AND (accttime BETWEEN '$time_ini' AND '$time_end') ".
										$sql_provider_list." ".$filter_time." ".$filter_presence." ".
										"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)".
									") ".
					"SELECT pos_day, COUNT(pos_day), AVG(time_day) FROM aggregate_view ".
					"GROUP BY pos_day ORDER BY pos_day desc";
  $ret_activity = pg_query($dbConnect, $sql_activity);

	$totalbigdatavisits_in = 0;
	$totalaccttimevisits = 0;
	$totaltimeinvisits = 0;
	$totaltimelimitvisits = 0;
	$totaltimeoutvisits = 0;

	while ($row_activity = pg_fetch_row($ret_activity)) {
		$pos = $row_activity[0];
		switch ($pos) {
			case 3:
				$totalbigdatavisits_in = $row_activity[1];
				$totaltimevisits = time2str($row_activity[2]);
				$totalinrow = $row_activity[1];
				$totaltimeinvisits = time2str($row_activity[2]);
			  $arr_activity[] = array("pos" => $pos, "total" => $totalinrow, "time" => $totaltimeinvisits);
				break;
			case 2:
				$totallimitrow = $row_activity[1];
				$totaltimelimitvisits = time2str($row_activity[2]);
			  $arr_activity[] = array("pos" => $pos, "total" => $totallimitrow, "time" => $totaltimelimitvisits);
				break;
			case 1:
				$totaloutrow = $row_activity[1];
				$totaltimeoutvisits = time2str($row_activity[2]);
			  $arr_activity[] = array("pos" => $pos, "total" => $totaloutrow, "time" => $totaltimeoutvisits);
				break;
		}
	}
  $arr_device_bdvisitsin[] = array("total" => $totalbigdatavisits_in, "time" => $totaltimevisits);

	$sql_brand = "SELECT	DISTINCT brand, COUNT(brand) AS cant ".
								"FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
													$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
									"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
										$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
										"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') AND (accttime BETWEEN '$time_ini' AND '$time_end') ".
										$sql_provider_list." ".$filter_time." ".$filter_presence." ".															
										"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
								"GROUP BY brand ".
								"ORDER BY cant, brand DESC";
  $ret_brand = pg_query($dbConnect, $sql_brand);
	$a_brand = '';
	$a_brand_cant = 0;
	while ($row_brand = pg_fetch_row($ret_brand)) {
	    $a_brand = $row_brand[0];
	    $a_brand_cant = $row_brand[1];

		$arr_brands[] = array("brand" => $a_brand, "cant" => $a_brand_cant);
	}

	switch ($radio_chkgraph) {
		case '0':
			$sql_graph = "with aggregate_view AS ".
				 							"(SELECT DISTINCT accttime, devicehashmac, MAX(pos_hour) ".
											"OVER (PARTITION BY acctstartdate, accttime, devicehashmac) AS pos_hour ".
											"FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
															$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
											"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
												"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') AND (accttime BETWEEN '$time_ini' AND '$time_end') ".
												$sql_provider_list." ".$filter_time." ".$filter_presence." ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)".
											") ".
							"SELECT accttime AS day_part, pos_hour, COUNT(pos_hour) FROM aggregate_view ".
							"GROUP BY day_part, pos_hour ORDER BY day_part, pos_hour DESC";
			break;
		case '1':
			$sql_graph = "with aggregate_view AS ".
				 							"(SELECT DISTINCT acctstartdate, devicehashmac, MAX(pos_hour) ".
											"OVER (PARTITION BY acctstartdate, devicehashmac) AS pos_hour ".
											"FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
															$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
											"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
												"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') AND (accttime BETWEEN '$time_ini' AND '$time_end') ".
												$sql_provider_list." ".$filter_time." ".$filter_presence." ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)".
											") ".
							"SELECT date_part('day', acctstartdate) AS day_part, pos_hour, COUNT(pos_hour) FROM aggregate_view ".
							"GROUP BY day_part, pos_hour ORDER BY day_part ";
			break;
		case '2':
			$sql_graph = "with aggregate_view AS ".
				 							"(SELECT DISTINCT acctstartdate, devicehashmac, MAX(pos_hour) ".
											"OVER (PARTITION BY acctstartdate, devicehashmac) AS pos_hour ".
											"FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
															$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
											"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
												"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') AND (accttime BETWEEN '$time_ini' AND '$time_end') ".
												$sql_provider_list." ".$filter_time." ".$filter_presence." ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)".
											") ".
							"SELECT date_part('isodow', acctstartdate) AS day_part, pos_hour, COUNT(pos_hour) FROM aggregate_view ".
							"GROUP BY day_part, pos_hour ORDER BY day_part, pos_hour DESC";
			break;
		case '3':
			$sql_graph = "with aggregate_view AS ".
				 							"(SELECT DISTINCT acctstartdate, devicehashmac, MAX(pos_hour) ".
											"OVER (PARTITION BY acctstartdate, devicehashmac) AS pos_hour ".
											"FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
															$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
											"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
												"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') AND (accttime BETWEEN '$time_ini' AND '$time_end') ".
												$sql_provider_list." ".$filter_time." ".$filter_presence." ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)".
											") ".
							"SELECT date_part('week', acctstartdate) AS day_part, pos_hour, COUNT(pos_hour) FROM aggregate_view ".
							"GROUP BY day_part, pos_hour ORDER BY day_part, pos_hour DESC";
			break;
		case '4':
			$sql_graph = "with aggregate_view AS ".
				 							"(SELECT DISTINCT acctstartdate, devicehashmac, MAX(pos_hour) ".
											"OVER (PARTITION BY acctstartdate, devicehashmac) AS pos_hour ".
											"FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
															$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
											"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
												"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') AND (accttime BETWEEN '$time_ini' AND '$time_end') ".
												$sql_provider_list." ".$filter_time." ".$filter_presence." ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)".
											") ".
							"SELECT date_part('month', acctstartdate) AS day_part, pos_hour, COUNT(pos_hour) FROM aggregate_view ".
							"GROUP BY day_part, pos_hour ORDER BY day_part, pos_hour DESC";
			break;
		case '5':
			$sql_graph = "with aggregate_view AS ".
				 							"(SELECT DISTINCT acctstartdate, devicehashmac, MAX(pos_hour) ".
											"OVER (PARTITION BY acctstartdate, devicehashmac) AS pos_hour ".
											"FROM ".$esquema.".sensor_acct_aggregate_view AS saav ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = saav.spot_id, ".
															$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
											"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
												"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') AND (accttime BETWEEN '$time_ini' AND '$time_end') ".
												$sql_provider_list." ".$filter_time." ".$filter_presence." ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)".
											") ".
							"SELECT date_part('year', acctstartdate) AS day_part, pos_hour, COUNT(pos_hour) FROM aggregate_view ".
							"GROUP BY day_part, pos_hour ORDER BY day_part, pos_hour DESC";
			break;			
	}
  $ret_graph = pg_query($dbConnect, $sql_graph);
	
	while ($row_graph = pg_fetch_row($ret_graph)) {
		$day_part = $row_graph[0];
		$pos_hour = $row_graph[1];
		$count = $row_graph[2];
		
		switch ($pos_hour) {
			case 3:
				$arr_graph[] = array("day_part" => $day_part, "pos" => $pos_hour, "in" => $count);
				break;
			case 2:
				$arr_graph[] = array("day_part" => $day_part, "pos" => $pos_hour, "limit" => $count);
				break;
			case 1:
				$arr_graph[] = array("day_part" => $day_part, "pos" => $pos_hour, "out" => $count);
				break;
		}			
	}

  include('../../library/closedb.php');
 	$arr_online[] = array("section" => 'bigdata', "data" => $device_bd);
	$arr_online[] = array("section" => 'bigdatain', "data" => $device_bdin);
	$arr_online[] = array("section" => 'bigdataqvin', "data" => $arr_device_bdvisitsin);
	$arr_online[] = array("section" => 'activity', "data" => $arr_activity);
	$arr_online[] = array("section" => 'brand', "data" => $arr_brands);
	$arr_online[] = array("section" => 'graph', "data" => $arr_graph);

  echo json_encode($arr_online);		
?>
