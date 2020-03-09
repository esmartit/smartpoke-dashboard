<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];
  
  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];
  
  include('../../library/opendb.php');
	
	$sql_client = "SELECT	client FROM ".$configValues['TBL_RWCLIENT']." WHERE esquema = '$esquema'";
	$ret_client = pg_query($dbConnect, $sql_client);
	$row_client = pg_fetch_row($ret_client);
	$client = $row_client[0];


	$sql_sel_ope = "SELECT id, CONCAT(lastname,', ',firstname) AS operator ".
                "FROM ".$configValues['TBL_RSOPERATORS']." ".
                "WHERE client = '$client'";    
	$ret_sel_ope = pg_query($dbConnect, $sql_sel_ope);
  $operator_arr = array();

	while ($row_sel_ope = pg_fetch_row($ret_sel_ope)) {

    $ope_id = $row_sel_ope[0];
    $ope_name = $row_sel_ope[1];
    
    $operator_arr[] = array("id" => $ope_id, "name" => $ope_name);
  }
  include('../../library/closedb.php');
  echo json_encode($operator_arr);

?>
