<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];

  if (isset($_POST['idspot']))
    $idspot = $_POST['idspot'];
  elseif (isset($_GET['idspot']))
    $idspot = $_GET['idspot'];

  if (isset($_POST['hotspot_id']))
    $hotspot_id = $_POST['hotspot_id'];
  elseif (isset($_GET['hotspot_id']))
    $hotspot_id = $_GET['hotspot_id'];
  
	$where_hotspot = '';			
	if ($hotspot_id != '') {
	  $where_hotspot = "WHERE id = $hotspot_id";
  }

  include('../../library/opendb.php');
	$data = array();

	$sql_select = "WITH hotspots AS ( ".
								"SELECT ROW_NUMBER() OVER (ORDER BY name) AS id, hs.spot_id, s.spot_name, name, mac, geocode ".
								"FROM  ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ".
                "JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = hs.spot_id ".
								"WHERE hs.spot_id = '$idspot') ".
								"SELECT * FROM hotspots ".$where_hotspot;
	$ret_select = pg_query($dbConnect, $sql_select);
	if (pg_num_rows($ret_select) > 0) $data = pg_fetch_all($ret_select);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
