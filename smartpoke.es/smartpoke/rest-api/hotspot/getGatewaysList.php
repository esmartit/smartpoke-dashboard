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

  if (isset($_POST['nas_id']))
    $nas_id = $_POST['nas_id'];
  elseif (isset($_GET['nas_id']))
    $nas_id = $_GET['nas_id'];
  
	$where_nas = '';			
	if ($nas_id != '') {
	  $where_nas = "AND id = $nas_id";
  }

  include('../../library/opendb.php');
	$data = array();
	
  $sql_select = "SELECT id, n.spot_id, s.spot_name, nasname, secret, type, shortname ".
								"FROM ".$esquema.".".$configValues['TBL_RADNAS']." AS n ".
                "JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = n.spot_id ".
								"WHERE n.spot_id = '$idspot' ".$where_nas;
	$ret_select = pg_query($dbConnect, $sql_select);
	if (pg_num_rows($ret_select) > 0) $data = pg_fetch_all($ret_select);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
