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
  
  if (isset($_POST['client']))
    $id_client = $_POST['client'];
  elseif (isset($_GET['client']))
    $id_client = $_GET['client'];

  if (isset($_POST['client_name']))
    $client_name = $_POST['client_name'];
  elseif (isset($_GET['client_name']))
    $client_name = $_GET['client_name'];

  if (isset($_POST['client_address']))
    $client_address = $_POST['client_address'];
  elseif (isset($_GET['client_address']))
    $client_address = $_GET['client_address'];

  if (isset($_POST['client_company']))
    $client_company = $_POST['client_company'];
  elseif (isset($_GET['client_company']))
    $client_company = $_GET['client_company'];

  if (isset($_POST['client_phone1']))
    $client_phone1 = $_POST['client_phone1'];
  elseif (isset($_GET['client_phone1']))
    $client_phone1 = $_GET['client_phone1'];

  if (isset($_POST['client_phone2']))
    $client_phone2 = $_POST['client_phone2'];
  elseif (isset($_GET['client_phone2']))
    $client_phone2 = $_GET['client_phone2'];

  if (isset($_POST['client_esquema']))
    $client_esquema = $_POST['client_esquema'];
  elseif (isset($_GET['client_esquema']))
    $client_esquema = $_GET['client_esquema'];

  if (isset($_POST['client_status']))
    $client_status = $_POST['client_status'];
  elseif (isset($_GET['client_status']))
    $client_status = $_GET['client_status'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

	if ($action == 'I') {
    $sql_insert = "INSERT INTO ".$configValues['TBL_RWCLIENT']." ".
									"(client, esquema, status, name, address, company, phone1, phone2, creationdate, creationby, updatedate, updateby) ".
									"VALUES('$id_client', '$client_esquema', '$client_status', '$client_name', '$client_address', '$client_company', '$client_phone1', '$client_phone2', '$currDate', '$operator_user', '$currDate', '$operator_user')";
    $ret = pg_query($dbConnect, $sql_insert);
		if(!$sql_insert) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "insert", "message" => $l_insert_message);		
	}

	if ($action == 'U') {
    $sql_update = "UPDATE ".$configValues['TBL_RWCLIENT']." ".
			           "SET esquema='$client_esquema', status='$client_status', name='$client_name', address='$client_address', company='$client_company', ".
										 "phone1='$client_phone1', phone2='$client_phone2', updatedate='$currDate', updateby='$operator_user' ".
			           "WHERE client = '$id_client'";
    $ret = pg_query($dbConnect, $sql_update);
		if(!$sql_update) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "update", "message" => $l_update_message);		
	}

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
