<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

	$lang = $_SESSION['lang'];
	
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

  if (isset($_POST['sensor_id']))
    $sensor_id = $_POST['sensor_id'];
  elseif (isset($_GET['sensor_id']))
    $sensor_id = $_GET['sensor_id'];

	$where_spot = "";
	if ($idspot != '') $where_spot = "WHERE se.spot_id = '$idspot' ";

	$where_sensor = "";
	if ($sensor_id != '') $where_sensor = "WHERE id = '$sensor_id'";

  include('../../library/opendb.php');
	$data = array();

  $sql_sensors = "WITH sensors AS ( ".
									"SELECT ROW_NUMBER() OVER (ORDER BY se.spot_id, sensorname) AS id, se.spot_id, spot_name, sensorname, location, pwr_in, pwr_limit, pwr_out ".
									"FROM ".$esquema.".".$configValues['TBL_RWSENSOR']." AS se ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = se.spot_id ".
									$where_spot.") ".
									"SELECT * FROM sensors ".$where_sensor;
	$ret_sensors = pg_query($dbConnect, $sql_sensors);
	if (pg_num_rows($ret_sensors) > 0) $data = pg_fetch_all($ret_sensors);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
