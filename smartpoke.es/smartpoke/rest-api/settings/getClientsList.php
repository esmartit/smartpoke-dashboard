<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['client']))
    $id_client = $_POST['client'];
  elseif (isset($_GET['client']))
    $id_client = $_GET['client'];
  
  $where_client = "WHERE id = $id_client";
  if ($operator_profile_id == 1) {
		if ($id_client == '') {
			$where_client = '';			
		} 
  } else {
	  $where_client = "WHERE client = '$id_client'";  	
  }

  include('../../library/opendb.php');
	$data = array();
	
  $sql_client = "WITH clients AS ( ".
									"SELECT ROW_NUMBER() OVER (ORDER BY client) AS id, client, esquema, status, name, address, company, phone1, phone2 ".
									"FROM ".$configValues['TBL_RWCLIENT'].") ".
								"SELECT * FROM clients ".$where_client;		
	$ret_client = pg_query($dbConnect, $sql_client);
	if (pg_num_rows($ret_client) >= 1) {
		$data = pg_fetch_all($ret_client);		
	}
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
