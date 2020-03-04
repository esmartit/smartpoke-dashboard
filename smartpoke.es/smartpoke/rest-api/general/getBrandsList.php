<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['brand']))
    $brand = $_POST['brand'];
  elseif (isset($_GET['brand']))
    $brand = $_GET['brand'];
  
	$where_brand = '';			
	if ($brand != '') {
	  $where_brand = "WHERE id = $brand";
  }

  include('../../library/opendb.php');
	$data = array();
	
  $sql_brand = "WITH brands AS ( ".
									"SELECT ROW_NUMBER() OVER (ORDER BY brand) AS id, brand ".
									"FROM ".$configValues['TBL_RWBRANDS'].") ".
								"SELECT * FROM brands ".$where_brand;		
	$ret_brand = pg_query($dbConnect, $sql_brand);
	if (pg_num_rows($ret_brand) > 0) $data = pg_fetch_all($ret_brand);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
