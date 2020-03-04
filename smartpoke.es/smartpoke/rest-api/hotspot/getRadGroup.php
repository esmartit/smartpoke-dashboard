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

  if (isset($_POST['limit_name']))
    $limit_name = $_POST['limit_name'];
  elseif (isset($_GET['limit_name']))
    $limit_name = $_GET['limit_name'];
  
	$where_limit = '';			
	if ($limit_id != '') {
	  $where_limit = "WHERE id = $limit_id";
  }

  include('../../library/opendb.php');
	$data = array();

  $sql_select = "SELECT id, groupname, attribute, value, 'CHECK' AS rad, spot_id ".
											"FROM ".$esquema.".".$configValues['TBL_RADGROUPCHECK']." ".
											"WHERE spot_id = '$idspot' AND groupname = '$limit_name' ".
											"UNION ".
											"SELECT id, groupname, attribute, value, 'REPLY' AS rad, spot_id ".
											"FROM ".$esquema.".".$configValues['TBL_RADGROUPREPLY']." ".
											"WHERE spot_id = '$idspot' AND groupname = '$limit_name' ";
	$ret_select = pg_query($dbConnect, $sql_select);
	if (pg_num_rows($ret_select) > 0) $data = pg_fetch_all($ret_select);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
