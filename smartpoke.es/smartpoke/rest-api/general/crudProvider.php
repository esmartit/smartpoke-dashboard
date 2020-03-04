<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_id = $_SESSION['operator_id'];
  $operator_user = $_SESSION['operator_user'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $client_id = $_SESSION['client_id'];
  $lang = $_SESSION['lang'];
  $currDate = date('Y-m-d H:i:s');

  $session_id = $_SESSION['id'];
	if ($lang == 'es') include('../../lang/es.php');
	else include('../../lang/en.php');
  
  if (isset($_POST['brand']))
    $brand = $_POST['brand'];
  elseif (isset($_GET['brand']))
    $brand = $_GET['brand'];

  include('../../library/opendb.php');
	$line_message = array();

  $sql_upd_provider = "UPDATE ".$configValues['TBL_RWPROVIDERS']." ".
											"SET brand = '$brand' ".
											"WHERE description LIKE '%$brand%'";
	$ret_upd_provider = pg_query($dbConnect, $sql_upd_provider);
	if(!$ret_upd_provider) {
    $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
	}
  $line_message = array("action" => "update", "message" => $l_update_message);		

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
