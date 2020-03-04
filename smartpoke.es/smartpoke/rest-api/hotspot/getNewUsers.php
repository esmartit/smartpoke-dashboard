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

  include('../../library/opendb.php');
	$arr_newusernotused = array(); // Array New and Not
	$arr_newusers = array(); // Array New Users
	$arr_notused = array(); // Array Not used
	
  #----------------- New Users ----------------------
  $sql_newusers = "SELECT DISTINCT DATE( ui.creationdate ) AS date, ui.username, lastname, firstname, mobilephone, email, ".
                          "(SELECT name FROM ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." WHERE mac = ui.creationby) AS hotspot ".
                  "FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
									  "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
                  "WHERE (DATE(ui.creationdate) BETWEEN '$datestart' AND '$dateend') AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
                         $where_state." ".$where_city." ".$where_location." ".$where_spot." ".
                  "ORDER BY hotspot, date ";
  $ret_newusers = pg_query($dbConnect, $sql_newusers);
  while ($row_newusers = pg_fetch_row($ret_newusers)) {
    
		$arr_newusers[] = array("date" => $row_newusers[0], "username" => $row_newusers[1], "lastname" => $row_newusers[2], "firstname" => $row_newusers[3], "mobilephone" => $row_newusers[4], "email" => $row_newusers[5], "hotspot" => $row_newusers[6]);
				
	}

  $sql_notused = "SELECT DATE(ui.creationdate ) AS date, username, lastname, firstname, mobilephone, email, '$l_nologged' AS hotspot ".
							    "FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
									  "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
                 "WHERE username NOT IN (SELECT DISTINCT username FROM ".$esquema.".".$configValues['TBL_RADACCT'].") AND ".
                        "operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
                         $where_state." ".$where_city." ".$where_location." ".$where_spot." ".
                 "ORDER BY date ";
  $ret_notused = pg_query($dbConnect, $sql_notused);
  while ($row_notused = pg_fetch_row($ret_notused)) {
    
		$arr_notused[] = array("date" => $row_notused[0], "username" => $row_notused[1], "lastname" => $row_notused[2], "firstname" => $row_notused[3], "mobilephone" => $row_notused[4], "email" => $row_notused[5], "hotspot" => $row_notused[6]);
				
	}

  include('../../library/closedb.php');
	$arr_newusernotused[] = array("section" => "newusers", "data" => $arr_newusers);
	$arr_newusernotused[] = array("section" => "notused", "data" => $arr_notused);

  echo json_encode($arr_newusernotused);
?>