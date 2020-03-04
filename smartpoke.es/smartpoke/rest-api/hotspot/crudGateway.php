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
    
  if (isset($_POST['nas_id']))
    $nas_id = $_POST['nas_id'];
  elseif (isset($_GET['nas_id']))
    $nas_id = $_GET['nas_id'];

  if (isset($_POST['nas_ip_host']))
    $nas_ip_host = $_POST['nas_ip_host'];
  elseif (isset($_GET['nas_ip_host']))
    $nas_ip_host = $_GET['nas_ip_host'];

  if (isset($_POST['nas_secret']))
    $nas_secret = $_POST['nas_secret'];
  elseif (isset($_GET['nas_secret']))
    $nas_secret = $_GET['nas_secret'];

  if (isset($_POST['nas_type']))
    $nas_type = $_POST['nas_type'];
  elseif (isset($_GET['nas_type']))
    $nas_type = $_GET['nas_type'];

  if (isset($_POST['nas_shortname']))
    $nas_shortname = $_POST['nas_shortname'];
  elseif (isset($_GET['nas_shortname']))
    $nas_shortname = $_GET['nas_shortname'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {
		$sql_delete_nas = "SELECT	* FROM ".$esquema.".".$configValues['TBL_RADACCT']." ".
									    "WHERE calledstationid = '$nas_shortname' LIMIT 1";
		$ret_delete_nas = pg_query($dbConnect, $sql_delete_nas);
		$row_delete_nas = pg_num_rows($ret_delete_nas);

		if(!$ret_delete_nas) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else {
			
			if ($row_delete_nas >= 1) $line_message = array("action" => "delete", "message" => $l_delete_deny.' '.$l_nas);
			else {
		    $sql_del = "DELETE FROM ".$esquema.".".$configValues['TBL_RADNAS']." ".
										"WHERE spot_id = '$idspot' AND id = '$nas_id'";
				$ret_del = pg_query($dbConnect, $sql_del);
				if(!$ret_del) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "delete", "message" => $l_delete_message);			
			}		
		}
  } else {
    $sql_sel_nas = "SELECT spot_id, nasname FROM ".$esquema.".".$configValues['TBL_RADNAS']." ".
				           "WHERE spot_id = '$idspot' AND nasname = '$nas_ip_host'";
		$ret_sel_nas = pg_query($dbConnect, $sql_sel_nas);
		if(!$ret_sel_nas) $line_message = array("action" => "select", "message" => pg_last_error($dbConnect));
		else {
			
			$action = 'U';
	    if (pg_num_rows($ret_sel_nas) == 0) $action = 'I';

			if ($action == 'I') {
	      $sql_ins_nas = "INSERT INTO ".$esquema.".".$configValues['TBL_RADNAS']." ".
												"(spot_id, nasname, shortname, type, ports, secret, server, community, description) ".
												"VALUES('$idspot', '$nas_ip_host', '$nas_shortname', '$nas_type', 0, '$nas_secret', '', '', '')";
				$ret_ins_nas = pg_query($dbConnect, $sql_ins_nas);
				if(!$ret_ins_nas) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "insert", "message" => $l_insert_message);
			}

			if ($action == 'U') {
	      $sql_upd_nas = "UPDATE ".$esquema.".".$configValues['TBL_RADNAS']." ".
	             "SET nasname='$nas_ip_host', shortname='$nas_shortname', type='$nas_type', secret='$nas_secret' ".
	             "WHERE spot_id = '$idspot' AND id = '$nas_id'";
				$ret_upd_nas = pg_query($dbConnect, $sql_upd_nas);
				if(!$ret_upd_nas) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "update", "message" => $l_update_message);
			}
		}
  }

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
