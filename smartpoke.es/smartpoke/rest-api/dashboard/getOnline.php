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

  if (isset($_POST['timestart'])) 
		$timestart = $_POST['timestart'];
	elseif (isset($_GET['timestart']))
		$timestart = $_GET['timestart'];
		
  if (isset($_POST['timeend'])) 
		$timeend = $_POST['timeend'];
	elseif (isset($_GET['timeend']))
		$timeend = $_GET['timeend'];
  
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

  if (isset($_POST['idstatus'])) 
		$status_id = $_POST['idstatus'];
  elseif (isset($_GET['idstatus'])) 
		$status_id = $_GET['idstatus'];
  
  switch($status_id) {        
    case "IN":
			// $where_pos = "AND pos_hour = 3 ";
			$where_pos = "AND pos = 'IN' "; 
      break;
    case "LIMIT":
			// $where_pos = "AND pos_hour = 2 ";
			$where_pos = "AND pos = 'LIMIT' "; 
      break;
    case "OUT":
			// $where_pos = "AND pos_hour = 1 ";
			$where_pos = "AND pos = 'OUT' "; 
      break;
    default:
			// $where_pos = "";
			$where_pos = "AND pos <> 'TOTAL' "; 			
      break;
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

	$arr_device_bd = array(); // BigData
	$arr_device_bdin = array(); // BigData IN
	$arr_device_bdvisitsin = array(); // BigData Visits IN
	
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

  include('../../library/opendb.php');

	$sql_device_bd = "SELECT DISTINCT devicehashmac ".
								      "FROM ".$esquema.".".$configValues['TBL_RWSENSORTOTAL']." AS st ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = st.spot_id ".
											"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
											"WHERE operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." AND pos = 'TOTAL' ".
												"AND (acctdate = '$datestart') ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)";
  $ret_device_bd = pg_query($dbConnect, $sql_device_bd);
	$device_bd = 0;
	if (pg_num_rows($ret_device_bd) >= 1) $device_bd = pg_num_rows($ret_device_bd);
	
	$sql_device_bdin = "SELECT DISTINCT devicehashmac ".
								      "FROM ".$esquema.".".$configValues['TBL_RWSENSORTOTAL']." AS st ".
											"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = st.spot_id ".
											"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
											"WHERE operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." AND pos = 'IN' ".
												"AND (acctdate = '$datestart') ".
												"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)";
	$ret_device_bdin = pg_query($dbConnect, $sql_device_bdin);
	$device_bdin = 0;
	if (pg_num_rows($ret_device_bdin) >= 1) $device_bdin = pg_num_rows($ret_device_bdin);

	$sql_activity = "SELECT DISTINCT pos, sum(num00), sum(num01), sum(num02), sum(num03), sum(num04), sum(num05), sum(num06), ".
												"sum(num07), sum(num08), sum(num09), sum(num10), sum(num11), sum(num12), sum(num13), sum(num14), ".
												"sum(num15), sum(num16), sum(num17), sum(num18), sum(num19), sum(num20), sum(num21), sum(num22), ".
												"sum(num23), AVG(timto), sum(numto) ".
						      "FROM ".$esquema.".".$configValues['TBL_RWSENSORTOTAL']." AS st ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = st.spot_id ".
									"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
									"WHERE operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
										$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
										"AND (acctdate = '$datestart') ".$sql_provider_list." ".
										"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
									"GROUP BY pos";
  $ret_activity = pg_query($dbConnect, $sql_activity);

	$totalbigdatavisits_in = 0;
	$totalaccttimevisits = 0;
	$totaltimeinvisits = 0;
	$totaltimelimitvisits = 0;
	$totaltimeoutvisits = 0;
	
	while ($row_activity = pg_fetch_row($ret_activity)) {

		$pos = $row_activity[0];
		$atime = $row_activity[25];
		$numto = $row_activity[26];

		switch ($pos) {
			case 'IN':
				$totaltimevisits = time2str($atime);
				$totaltimeinvisits = time2str($atime);

				for ($h = 0; $h <= 23; $h++ ) {
					$i = $h + 1;
					if ($h >= $time_ini && $h <= $time_end) {
						$totalbigdatavisits_in = $totalbigdatavisits_in + $row_activity[$i];
						$totalinrow = $totalinrow + $row_activity[$i];
						$arr_graph[] = array("day_part" => $h, "pos" => "3", "in" => $row_activity[$i]);
					}
				}
			  $arr_activity[] = array("pos" => "3", "total" => $totalinrow, "time" => $totaltimeinvisits);
				break;
			case 'LIMIT':
				$totaltimelimitvisits = time2str($atime);

				for ($h = 0; $h <= 23; $h++ ) {
					$i = $h + 1;
					if ($h >= $time_ini && $h <= $time_end) {
						$totallimitrow = $totallimitrow + $row_activity[$i];
						$arr_graph[] = array("day_part" => $h, "pos" => "2", "limit" => $row_activity[$i]);						
					}
				}
			  $arr_activity[] = array("pos" => "2", "total" => $totallimitrow, "time" => $totaltimelimitvisits);
				break;
			case 'OUT':
				$totaltimeoutvisits = time2str($atime);

				for ($h = 0; $h <= 23; $h++ ) {
					$i = $h + 1;
					if ($h >= $time_ini && $h <= $time_end) {
						$totaloutrow = $totaloutrow + $row_activity[$i];
						$arr_graph[] = array("day_part" => $h, "pos" => "1", "out" => $row_activity[$i]);
					}
				}
			  $arr_activity[] = array("pos" => "1", "total" => $totaloutrow, "time" => $totaltimeoutvisits);
				break;
		}
	}
  $arr_device_bdvisitsin[] = array("total" => $totalbigdatavisits_in, "time" => $totaltimevisits);	
	
	$sql_brand = "SELECT	DISTINCT brand, COUNT(brand) AS cant ".
							"FROM ".$esquema.".".$configValues['TBL_RWSENSORTOTAL']." AS st ".
							"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = st.spot_id ".
							"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
							"WHERE operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
								$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
								"AND (acctdate = '$datestart') ".$sql_provider_list." ".
								"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
							"GROUP BY brand"; 	
  $ret_brand = pg_query($dbConnect, $sql_brand);
	$a_brand = '';
	$a_brand_cant = 0;
	while ($row_brand = pg_fetch_row($ret_brand)) {
	    $a_brand = $row_brand[0];
	    $a_brand_cant = $row_brand[1];

		$arr_brands[] = array("brand" => $a_brand, "cant" => $a_brand_cant);
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
