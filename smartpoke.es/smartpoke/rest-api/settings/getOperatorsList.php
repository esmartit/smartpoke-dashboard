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
  
	$where_operator = '';			
	if ($ope_id != '') {
	  $where_operator = "AND o.id = $ope_id ";
  }

  $where_profile = '';
  if ($operator_profile_id != 1 ) {
	  $where_profile = "AND profile_id > 1";  	
  }

  include('../../library/opendb.php');
	$data = array();

	$sql_client = "SELECT	client FROM ".$configValues['TBL_RWCLIENT']." WHERE esquema = '$esquema'";
	$ret_client = pg_query($dbConnect, $sql_client);
	$row_client = pg_fetch_row($ret_client);
	$client = $row_client[0];
	
  $sql_select = "SELECT o.id, username, password, firstname, lastname, profile_id, profile_name, client ".
			         "FROM ".$configValues['TBL_RSOPERATORS']." AS o ".
			         "JOIN ".$configValues['TBL_RSPROFILES']." AS p ON o.profile_id = p.id ".  
			         "WHERE client = '$client' ".$where_operator.$where_profile;
	$ret_select = pg_query($dbConnect, $sql_select);
	if (pg_num_rows($ret_select) > 0) $data = pg_fetch_all($ret_select);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
