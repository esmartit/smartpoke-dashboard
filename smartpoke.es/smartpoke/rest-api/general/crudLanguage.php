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
  
  if (isset($_POST['lang']))
    $lang = $_POST['lang'];
  elseif (isset($_GET['lang']))
    $lang = $_GET['lang'];

  include('../../library/opendb.php');
	$line_message = array();

  $sql_update = "UPDATE ".$configValues['TBL_RSOPERATORS']." ".
         "SET lastlogin='$currDate', lang = '$lang' WHERE username='$operator_user'";
	$ret_update = pg_query($dbConnect, $sql_update);
	if(!$ret_update) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
	else $line_message = array("action" => "update", "message" => $l_update_message);		
	
  $_SESSION['lang'] = $lang;
  include('../../library/closedb.php');

	if ($lang == 'es') include('../../lang/es.php');
	else include('../../lang/en.php');

	echo json_encode($line_message);
	
?>
