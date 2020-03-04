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

  if (isset($_POST['device_id']))
    $device_id = $_POST['device_id'];
  elseif (isset($_GET['device_id']))
    $device_id = $_GET['device_id'];

	$where_spot = "";
	if ($idspot != '') $where_spot = "WHERE d.spot_id = '$idspot' ";

	$where_device = "";
	if ($device_id != '') $where_device = "WHERE id = '$device_id'";

  include('../../library/opendb.php');
	$data = array();

  $sql_devices = "WITH devices AS ( ".
									"SELECT ROW_NUMBER() OVER (ORDER BY devicemac) AS id, d.spot_id, spot_name, devicemac, devicehashmac ".
									"FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." AS d ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = d.spot_id ".
									$where_spot.") ".
									"SELECT * FROM devices ".$where_device;
	$ret_devices = pg_query($dbConnect, $sql_devices);
	if (pg_num_rows($ret_devices) > 0) $data = pg_fetch_all($ret_devices);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
