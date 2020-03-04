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

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

	if ($action == 'I') {
    $sql_insert = "INSERT INTO ".$configValues['TBL_RWBRANDS']." (brand) VALUES('$brand')";
    $ret = pg_query($dbConnect, $sql_insert);
		if(!$sql_insert) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "insert", "message" => $l_insert_message);		
	}

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
