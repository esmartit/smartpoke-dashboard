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
  
  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];

  if (isset($_POST['idspot']))
    $idspot = $_POST['idspot'];
  elseif (isset($_GET['idspot']))
    $idspot = $_GET['idspot'];
    
  if (isset($_POST['user_name']))
    $username = $_POST['user_name'];
  elseif (isset($_GET['user_name']))
    $username = $_GET['user_name'];

  if (isset($_POST['user_lastname']))
    $lastname = $_POST['user_lastname'];
  elseif (isset($_GET['user_lastname']))
    $lastname = $_GET['user_lastname'];

  if (isset($_POST['user_email']))
    $email = $_POST['user_email'];
  elseif (isset($_GET['user_email']))
    $email = $_GET['user_email'];

  if (isset($_POST['user_birthdate']))
    $birthdate = $_POST['user_birthdate'];
  elseif (isset($_GET['user_birthdate']))
    $birthdate = $_GET['user_birthdate'];

  if (isset($_POST['gender']))
    $gender = $_POST['gender'];
  elseif (isset($_GET['gender']))
    $gender = $_GET['gender'];

  if (isset($_POST['zip_code']))
    $zip = $_POST['zip_code'];
  elseif (isset($_GET['zip_code']))
    $zip = $_GET['zip_code'];

  if (isset($_POST['flag_sms']))
    $flag = $_POST['flag_sms'];
  elseif (isset($_GET['flag_sms']))
    $flag = $_GET['flag_sms'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

	if ($action == 'U') {

    $sql_update = "UPDATE ".$esquema.".".$configValues['TBL_RSUSERINFO']." ".
									"SET lastname='$lastname', email='$email', birthdate='$birthdate', gender='$gender', zip='$zip', ".
											"flag_sms='$flag', updatedate='$currDate', updateby='$operator_user' ".
									"WHERE spot_id = '$idspot' AND username = '$username'";
    $ret_update = pg_query($dbConnect, $sql_update);
		if(!$ret_update) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "update", "message" => $l_update_message);		
	}

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
