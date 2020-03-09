<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];

  if (isset($_POST['ope_id']))
    $ope_id = $_POST['ope_id'];
  elseif (isset($_GET['ope_id']))
    $ope_id = $_GET['ope_id'];
	
  if (isset($_POST['type']))
    $type = $_POST['type'];
  elseif (isset($_GET['type']))
    $type = $_GET['type'];
	
	$where = "WHERE operator_id = '$ope_id' ";
	if ($type == 'C') $where = "WHERE id = '$ope_id' ";
  
  include('../../library/opendb.php');
	$data = array();
	
	$sql_client = "SELECT	client FROM ".$configValues['TBL_RWCLIENT']." WHERE esquema = '$esquema'";
	$ret_client = pg_query($dbConnect, $sql_client);
	$row_client = pg_fetch_row($ret_client);
	$client = $row_client[0];
	
  $sql_select = "WITH spotope AS (".
									"SELECT ROW_NUMBER() OVER (ORDER BY so.spot_id) AS id, so.spot_id, spot_name, operator_id, access ".
									"FROM ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS so ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = so.spot_id ".  
									"JOIN ".$configValues['TBL_RSOPERATORS']." AS o ON o.id = operator_id) ".  
								"SELECT	* FROM spotope ".$where;
	$ret_select = pg_query($dbConnect, $sql_select);
	if (pg_num_rows($ret_select) > 0) $data = pg_fetch_all($ret_select);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
