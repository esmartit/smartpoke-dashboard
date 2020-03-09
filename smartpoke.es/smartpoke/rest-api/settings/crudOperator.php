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

  if (isset($_POST['ope_id']))
    $ope_id = $_POST['ope_id'];
  elseif (isset($_GET['ope_id']))
    $ope_id = $_GET['ope_id'];

  if (isset($_POST['username']))
    $username = $_POST['username'];
  elseif (isset($_GET['username']))
    $username = $_GET['username'];

  if (isset($_POST['password']))
    $password = $_POST['password'];
  elseif (isset($_GET['password']))
    $password = $_GET['password'];

  if (isset($_POST['confirmpassword']))
    $confirmpassword = $_POST['confirmpassword'];
  elseif (isset($_GET['confirmpassword']))
    $confirmpassword = $_GET['confirmpassword'];

  if (isset($_POST['firstname']))
    $opefirstname = $_POST['firstname'];
  elseif (isset($_GET['firstname']))
    $opefirstname = $_GET['firstname'];

  if (isset($_POST['lastname']))
    $opelastname = $_POST['lastname'];
  elseif (isset($_GET['lastname']))
    $opelastname = $_GET['lastname'];

  if (isset($_POST['profile_id']))
    $profile_id = $_POST['profile_id'];
  elseif (isset($_GET['profile_id']))
    $profile_id = $_GET['profile_id'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {

    $sql_del_spotope = "DELETE FROM ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." ".
							           "WHERE operator_id = $ope_id";
		$ret_del_spotope = pg_query($dbConnect, $sql_del_spotope);
		if(!$ret_del_spotope) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else {
			
      $sql_del_ope = "DELETE FROM ".$configValues['TBL_RSOPERATORS']." ".
							        "WHERE id = '$ope_id'";
			$ret_del_ope = pg_query($dbConnect, $sql_del_ope);
			if(!$ret_del_ope) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "delete", "message" => $l_delete_message);			
		}
  } else {
    if (($password == '') || ($password != $confirmpassword)) {
      $line_message = $line_message = array("action" => "valid", "message" => $l_password_message);	
    } else {
			
			$sql_client = "SELECT	client FROM ".$configValues['TBL_RWCLIENT']." WHERE esquema = '$esquema'";
			$ret_client = pg_query($dbConnect, $sql_client);
			$row_client = pg_fetch_row($ret_client);
			$client = $row_client[0];

			if ($action == 'I') {
	      $pass = hash_hmac('sha512', $password, 'eSmartIT');
	      $sql_ins_operator = "INSERT INTO ".$configValues['TBL_RSOPERATORS']." ".
														"(client, username, password, firstname, lastname, profile_id, creationdate, creationby, updatedate, updateby) ".
														"VALUES('$client', '$username', '$pass', '$opefirstname', '$opelastname', '$profile_id', '$currDate', '$operator_user', '$currDate', '$operator_user')";
				$ret_ins_operator = pg_query($dbConnect, $sql_ins_operator);
				if(!$ret_ins_operator) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "insert", "message" => $l_insert_message);		
			}

			if ($action == 'U') {
	      $pass = hash_hmac('sha512', $password, 'eSmartIT');
	      $sql_upd_operator = "UPDATE ".$configValues['TBL_RSOPERATORS']." ".
														"SET password='$pass', firstname='$opefirstname', ".
														     "lastname='$opelastname', profile_id='$profile_id', updatedate='$currDate', updateby='$operator_user' ".
														"WHERE id = '$ope_id'";
				$ret_upd_operator = pg_query($dbConnect, $sql_upd_operator);
				if(!$ret_upd_operator) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "update", "message" => $l_update_message);		
			}
		}
  }

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
