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

  if (isset($_POST['limit_id']))
    $limit_id = $_POST['limit_id'];
  elseif (isset($_GET['limit_id']))
    $limit_id = $_GET['limit_id'];
  
	$where_limit = '';			
	if ($limit_id != '') {
	  $where_limit = "WHERE id = $limit_id";
  }

  include('../../library/opendb.php');
	$data = array();

	$sql_select = "WITH limits AS ( ".
								"SELECT DISTINCT ROW_NUMBER() OVER (ORDER BY rgr.groupname) AS id, rgr.spot_id, rgr.groupname, COUNT(DISTINCT(rug.username)) AS cant ".
								"FROM ".$esquema.".".$configValues['TBL_RADGROUPREPLY']." AS rgr ".
								"LEFT JOIN ".$esquema.".".$configValues['TBL_RADUSERGROUP']." AS rug ON rug.groupname = rgr.groupname ".
								"WHERE rgr.spot_id = '$idspot' ".
								"GROUP BY rgr.spot_id, rgr.groupname ".
								"UNION ".
								"SELECT DISTINCT ROW_NUMBER() OVER (ORDER BY rgc.groupname) AS id, rgc.spot_id, rgc.groupname, COUNT(DISTINCT(rug.username)) AS cant ".
								"FROM ".$esquema.".".$configValues['TBL_RADGROUPCHECK']." AS rgc ".
								"LEFT JOIN ".$esquema.".".$configValues['TBL_RADUSERGROUP']." AS rug ON rug.groupname = rgc.groupname ".
								"WHERE rgc.spot_id = '$idspot' ".
								"GROUP BY rgc.spot_id, rgc.groupname) ".	
								"SELECT * FROM limits ".$where_limit;
	$ret_select = pg_query($dbConnect, $sql_select);
	if (pg_num_rows($ret_select) > 0) $data = pg_fetch_all($ret_select);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
