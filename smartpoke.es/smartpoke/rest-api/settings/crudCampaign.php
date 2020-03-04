<?php 
// ini_set('display_errors','On');
// error_reporting(E_ALL);

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

  if (isset($_POST['message_id']))
    $message_id = $_POST['message_id'];
  elseif (isset($_GET['message_id']))
    $message_id = $_GET['message_id'];

  if (isset($_POST['message_name']))
    $message_name = $_POST['message_name'];
  elseif (isset($_GET['message_name']))
    $message_name = $_GET['message_name'];

  if (isset($_POST['message_description'])) 
    $message_description = $_POST['message_description'];
  elseif (isset($_GET['message_description']))
    $message_description = $_GET['message_description'];
	$len_message = strlen($message_description);

  if (isset($_POST['message_validdate']))
    $message_validdate = $_POST['message_validdate'];
  elseif (isset($_GET['message_validdate']))
    $message_validdate = $_GET['message_validdate'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];
	
  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {
  		$sql_delete_message = "SELECT	* FROM ".$esquema.".".$configValues['TBL_RWMESSAGESDETAIL']." ".
  											    "WHERE message_id = '$message_id'";
  		$ret_delete_message = pg_query($dbConnect, $sql_delete_message);
  		$row_delete_message = pg_num_rows($ret_delete_message);
  		if (!$ret_delete_message) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
  		else {
  			if ($row_delete_message >= 1) $line_message = array("action" => "delete", "message" => $l_delete_deny.' '.$l_campaign);
  			else {
  		    $sql_del_msg = "DELETE FROM ".$esquema.".".$configValues['TBL_RWMESSAGES']." ".
  						    "WHERE id = '$message_id'";
  				$ret_del_msg = pg_query($dbConnect, $sql_del_msg);
  				if (!$ret_sel_msg) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
  				else $line_message = array("action" => "delete", "message" => $l_delete_message);
  			}
  		}
  } else {
	  if ($len_message >= 20 && $len_message <= 160) {
			if ($action == 'I') {
		    $sql_ins_msg = "INSERT INTO ".$esquema.".".$configValues['TBL_RWMESSAGES']." ".
											"(spot_id, name, description, validdate, creationdate, creationby, updatedate, updateby) ".
											"VALUES('$idspot', '$message_name', '$message_description', '$message_validdate', '$currDate', '$operator_user', '$currDate', '$operator_user')";
				$ret_ins_msg = pg_query($dbConnect, $sql_ins_msg);
				if (!$ret_ins_msg) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "insert", "message" => $l_insert_message);
			}

			if ($action == 'U') {
		    $sql_udp_msg = "UPDATE ".$esquema.".".$configValues['TBL_RWMESSAGES']." ".
		           "SET spot_id='$idspot', name='$message_name', description='$message_description', validdate = '$message_validdate', updatedate = '$currDate', updateby='$operator_user' ".
		           "WHERE id = '$message_id'";
				$ret_udp_msg = pg_query($dbConnect, $sql_udp_msg);
				if (!$ret_upd_msg) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
		    else $line_message = array("action" => "update", "message" => $l_update_message);
			}
		} else {
	    $line_message = array("action" => "length", "message" => $l_message_text);
		}
  }

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
