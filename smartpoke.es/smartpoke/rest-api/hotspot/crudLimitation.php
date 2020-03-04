<?php 
ini_set('display_errors','On');
error_reporting(E_ALL);


  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  function inscheckreply($table, $spotid, $groupname, $attribute, $value) {

	  include('../../library/opendb.php');
    $sql_ins_table = "INSERT INTO $table (spot_id, groupname, attribute, op, value) ".
					           "VALUES('$spotid', '$groupname', '$attribute', ':=', '$value')";
		$ret_ins_table = pg_query($dbConnect, $sql_ins_table);
		if(!$ret_ins_table) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
	  include('../../library/closedb.php');
  }

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
    
  if (isset($_POST['limit_name']))
    $limit_name = $_POST['limit_name'];
  elseif (isset($_GET['limit_name']))
    $limit_name = $_GET['limit_name'];

  if (isset($_POST['limit_upload']))
    $limit_upload = $_POST['limit_upload'];
  elseif (isset($_GET['limit_upload']))
    $limit_upload = $_GET['limit_upload'];

  if (isset($_POST['value_upload']))
    $value_upload = $_POST['value_upload'];
  elseif (isset($_GET['value_upload']))
    $value_upload = $_GET['value_upload'];

  if (isset($_POST['limit_download']))
    $limit_download = $_POST['limit_download'];
  elseif (isset($_GET['limit_download']))
    $limit_download = $_GET['limit_download'];

  if (isset($_POST['value_download']))
    $value_download = $_POST['value_download'];
  elseif (isset($_GET['value_download']))
    $value_download = $_GET['value_download'];

  if (isset($_POST['limit_traffic']))
    $limit_traffic = $_POST['limit_traffic'];
  elseif (isset($_GET['limit_traffic']))
    $limit_traffic = $_GET['limit_traffic'];

  if (isset($_POST['value_traffic']))
    $value_traffic = $_POST['value_traffic'];
  elseif (isset($_GET['value_traffic']))
    $value_traffic = $_GET['value_traffic'];

  if (isset($_POST['redirect']))
    $redirect = $_POST['redirect'];
  elseif (isset($_GET['redirect']))
    $redirect = $_GET['redirect'];

  if (isset($_POST['access_period']))
    $access_period = $_POST['access_period'];
  elseif (isset($_GET['access_period']))
    $access_period = $_GET['access_period'];

  if (isset($_POST['value_access_period']))
    $value_access_period = $_POST['value_access_period'];
  elseif (isset($_GET['value_access_period']))
    $value_access_period = $_GET['value_access_period'];

  if (isset($_POST['daily_session']))
    $daily_session = $_POST['daily_session'];
  elseif (isset($_GET['daily_session']))
    $daily_session = $_GET['daily_session'];

  if (isset($_POST['value_daily_session']))
    $value_daily_session = $_POST['value_daily_session'];
  elseif (isset($_GET['value_daily_session']))
    $value_daily_session = $_GET['value_daily_session'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {
		$sql_select_group = "SELECT	* FROM ".$esquema.".".$configValues['TBL_RADUSERGROUP']." ".
										    "WHERE groupname = '$limit_name' LIMIT 1";
		$ret_select_group = pg_query($dbConnect, $sql_select_group);
		$row_select_group = pg_num_rows($ret_select_group);

		if(!$ret_select_group) $line_message = array("action" => "select", "message" => pg_last_error($dbConnect));
		else {
			
			if ($row_select_group >= 1) $line_message = array("action" => "delete", "message" => $l_delete_deny.' '.$l_limitation);
			else {
		    $sql_del_gcheck = "DELETE FROM ".$esquema.".".$configValues['TBL_RADGROUPCHECK']." ".
								           "WHERE spot_id = '$idspot' AND groupname = '$limit_name' ";
				$ret_del_gcheck = pg_query($dbConnect, $sql_del_gcheck);
				if(!$ret_del_gcheck) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "delete", "message" => $l_delete_message);			
				
		    $sql_del_greply = "DELETE FROM ".$esquema.".".$configValues['TBL_RADGROUPREPLY']." ".
								           "WHERE spot_id = '$idspot' AND groupname = '$limit_name' ";
				$ret_del_greply = pg_query($dbConnect, $sql_del_greply);
				if(!$ret_del_greply) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
				else $line_message = array("action" => "delete", "message" => $l_delete_message);							
			}		
		}
  } else {
		$sql_del_groupc = "DELETE FROM ".$esquema.".".$configValues['TBL_RADGROUPCHECK']." ".
							       "WHERE spot_id = '$idspot' AND groupname = '$limit_name' ";
		$ret_del_groupc = pg_query($dbConnect, $sql_del_groupc);
		if(!$ret_del_groupc) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));

    $sql_del_groupr = "DELETE FROM ".$esquema.".".$configValues['TBL_RADGROUPREPLY']." ".
		                 "WHERE spot_id = '$idspot' AND groupname = '$limit_name' ";
		$ret_del_groupr = pg_query($dbConnect, $sql_del_groupr);
		if(!$ret_del_groupr) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
				
    inscheckreply($esquema.".".$configValues['TBL_RADGROUPREPLY'], $idspot, $limit_name, 'Acct-Interim-Interval', 60);

    if ($limit_upload !='') {
      $limit_upload *= $value_upload;
      inscheckreply($esquema.".".$configValues['TBL_RADGROUPREPLY'], $idspot, $limit_name, 'WISPr-Bandwidth-Max-Up', $limit_upload);
    }

    if ($limit_download !='') {
      $limit_download *= $value_download;
      inscheckreply($esquema.".".$configValues['TBL_RADGROUPREPLY'], $idspot, $limit_name, 'WISPr-Bandwidth-Max-Down', $limit_download);
    }

    if ($redirect !='') 
      inscheckreply($esquema.".".$configValues['TBL_RADGROUPREPLY'], $idspot, $limit_name, 'WISPr-Redirection-URL', $redirect);

    if ($limit_traffic !='') {
      $limit_traffic *= $value_traffic;
      inscheckreply($esquema.".".$configValues['TBL_RADGROUPCHECK'], $idspot, $limit_name, 'Max-Daily-Octets', $limit_traffic);
    }

    if ($access_period !='') {
      $access_period *= $value_access_period;
      inscheckreply($esquema.".".$configValues['TBL_RADGROUPCHECK'], $idspot, $limit_name, 'Access-Period', $access_period);
    }

    if ($daily_session !='') {
      $daily_session *= $value_daily_session;
      inscheckreply($esquema.".".$configValues['TBL_RADGROUPCHECK'], $idspot, $limit_name, 'Max-Daily-Session', $daily_session);
    }      
    $line_message = array("action" => "insert", "message" => $l_insert_message);
  }

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
