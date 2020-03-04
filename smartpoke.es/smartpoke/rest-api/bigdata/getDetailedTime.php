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
	
  if (isset($_POST['sel_timegroup']))
    $sel_timegroup = $_POST['sel_timegroup'];
  elseif (isset($_GET['sel_timegroup']))
    $sel_timegroup = $_GET['sel_timegroup'];

	$arr_detailed_time = array(); // Detailed by Time
	$arr_result = array(); // Result
	
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

  switch($sel_timegroup) {
		case "1":
			$sql_select = "SELECT DISTINCT acctstartdate, DATE_PART('hour', acctstarttime) AS h, ".
								" CASE
								 WHEN DATE_PART('minute', acctstarttime) >= 0 AND
									 DATE_PART('minute', acctstarttime) < 15 THEN '00'
								 WHEN DATE_PART('minute', acctstarttime) >= 15 AND
								 	DATE_PART('minute', acctstarttime) < 30 THEN '15'
								 WHEN DATE_PART('minute', acctstarttime) >= 30 AND
								 	DATE_PART('minute', acctstarttime) < 45 THEN '30'
								 WHEN DATE_PART('minute', acctstarttime) >= 30 AND
								 	DATE_PART('minute', acctstarttime) < 59 THEN '45'
									ELSE 0
								END as m, sa.sensorname, COUNT(devicehashmac) ";
			break;
		case "2":
			$sql_select = "SELECT DISTINCT acctstartdate, DATE_PART('hour', acctstarttime) AS h, ".
								" CASE
								 WHEN DATE_PART('minute', acctstarttime) >= 0 AND
									 DATE_PART('minute', acctstarttime) < 30 THEN '00'
								 WHEN DATE_PART('minute', acctstarttime) >= 30 AND
								 	DATE_PART('minute', acctstarttime) < 59 THEN '30'
									ELSE 0
								END as m, sa.sensorname, COUNT(devicehashmac) ";
			break;
		case "3":
			$sql_select = "SELECT DISTINCT acctstartdate, DATE_PART('hour', acctstarttime) AS h, ".
									"'00' as m, sa.sensorname, COUNT(devicehashmac) ";
			break;
	}

	$sql_det = $sql_select." ".
						"FROM ".$esquema.".".$configValues['TBL_RWSENSORACCT']." AS sa ".
						"JOIN ".$esquema.".".$configValues['TBL_RWSENSOR']." AS se ON se.sensorname = sa.sensorname ".
						"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = sa.spot_id ".
						"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
						"WHERE operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
								$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".
								"AND (acctstartdate BETWEEN '$datestart' AND '$dateend') ".
								"AND (acctstarttime BETWEEN '$timestart' AND '$timeend') ".
								"AND acctpower::numeric >= se.pwr_out::numeric ".
								"AND devicehashmac NOT IN (SELECT devicehashmac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
						"GROUP BY acctstartdate, h, m, sa.sensorname ".
						"ORDER BY acctstartdate, h, m, sa.sensorname ";
	$ret_det = pg_query($dbConnect, $sql_det);

	while ($row_det = pg_fetch_row($ret_det)) {

		$hh = substr('0'.$row_det[1], 0, 2);
		if (strlen($row_det[1]) > 1) $hh = $row_det[1];
		$mm = substr($row_det[2].'0', 0, 2);
		$arr_result[] = array("date" => $row_det[0], "hour" => $hh.':'.$mm, "sensor" => $row_det[3], "total" => number_format($row_det[4], 0, ',', '.'));

	}
	include('../../library/closedb.php');

	$arr_detailed_time['data'] = $arr_result;
	
  echo json_encode($arr_detailed_time);

?>
