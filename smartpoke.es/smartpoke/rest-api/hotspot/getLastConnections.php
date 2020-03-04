<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
	include ('../../library/checklogin.php');
	include('../../library/pages_common.php');
	
	$lang = $_SESSION['lang'];
	
	if ($lang == 'es') include('../../lang/es.php');
	else include('../../lang/en.php');

  if (isset($_POST['operator_id']))
		$operator_profile_id = $_POST['operator_id'];
  elseif (isset($_GET['operator_id']))
    $operator_profile_id = $_GET['operator_id'];

  if (isset($_POST['datestart'])) 
		$datestart = $_POST['datestart'];
  elseif (isset($_GET['datestart']))
    $datestart = $_GET['datestart'];

  if (isset($_POST['dateend'])) 
		$dateend = $_POST['dateend'];
  elseif (isset($_GET['dateend']))
    $dateend = $_GET['dateend'];	
	
	if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];
  
  if (isset($_POST['idcountry']))
    $idcountry = $_POST['idcountry'];
  elseif (isset($_GET['idcountry']))
    $idcountry = $_GET['idcountry'];
	
  if (isset($_POST['idstate']))
    $idstate = $_POST['idstate'];
  elseif (isset($_GET['idstate']))
    $idstate = $_GET['idstate'];

  if (isset($_POST['idcity']))
    $idcity = $_POST['idcity'];
  elseif (isset($_GET['idcity']))
    $idcity = $_GET['idcity'];

  if (isset($_POST['idlocation']))
    $idlocation = $_POST['idlocation'];
  elseif (isset($_GET['idlocation']))
    $idlocation = $_GET['idlocation'];

  if (isset($_POST['idspot']))
    $idspot = $_POST['idspot'];
  elseif (isset($_GET['idspot']))
    $idspot = $_GET['idspot'];

  if (isset($_POST['radreply']))
    $radiusreply = $_POST['radreply'];
  elseif (isset($_GET['radreply']))
    $radiusreply = $_GET['radreply'];

	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

	$where_spot = '';
	$where_spot_id2 = '';
	if ($idspot != '%') {
		$where_spot = "AND s.spot_id = '$idspot' ";															
		$where_spot_id2 = "WHERE spot_id = '$idspot'";															
	}

	$where_reply = "";
	if ($radiusreply != '%') $where_reply = "reply = '$radiusreply' AND ";


  include('../../library/opendb.php');
	$arr_lastconnections = array(); // Array Last Connections
	
  #----------------- last connections ----------------------
  $sql_lastconn = "SELECT rpa.username, pass, reply, authdate ".
                  "FROM ".$esquema.".".$configValues['TBL_RADPOSTAUTH']." AS rpa ".
		                "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = rpa.username ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
		                "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
                  "WHERE ".$where_reply." (DATE(authdate) BETWEEN '$datestart' AND '$dateend') AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
                  "ORDER BY authdate";
  $ret_lastconn = pg_query($dbConnect, $sql_lastconn);

  while ($row_lastconn = pg_fetch_row($ret_lastconn)) {
    
		$authdate = date('Y-m-d H:i:s', strtotime($row_lastconn[3]));
    $reply = "<font color='green'><b>".$row_lastconn[2]."</b></font>";
    if ($row_lastconn[2] == 'Access-Reject') {
      $reply = "<font color='red'><b>".$row_lastconn[2]."</b></font>";
    }
		$arr_lastconnections[] = array("username" => $row_lastconn[0], "password" => $row_lastconn[1], "reply" => $reply, "date" => $authdate);			
	}

  include('../../library/closedb.php');
  echo json_encode($arr_lastconnections);
?>