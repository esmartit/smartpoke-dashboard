<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $session_id = $_SESSION['id'];
  
  if (isset($_POST['idcountry']))
    $idcountry = $_POST['idcountry'];
  elseif (isset($_GET['idcountry']))
    $idcountry = $_GET['idcountry'];
	
  include('../../library/opendb.php');
  $sql_state = "SELECT id, state_name FROM ".$configValues['TBL_RWSTATE']." WHERE country_id = '$idcountry' ".
								"ORDER BY state_name";	
	$ret_state = pg_query($dbConnect, $sql_state);
  $state_arr = array();

  while ($row_state = pg_fetch_row($ret_state)) {

    $state_id = $row_state[0];
    $state_name = $row_state[1];
    
    $state_arr[] = array("id" => $state_id, "name" => $state_name);
  }
  include('../../library/closedb.php');
  echo json_encode($state_arr);
?>
