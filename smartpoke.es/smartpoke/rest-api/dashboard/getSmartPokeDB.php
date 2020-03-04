<?php
// ini_set('display_errors','On');
// error_reporting(E_ALL);

	include ('../../library/checklogin.php');
	include('../../library/pages_common.php');
	
	$session_id = $_SESSION['id'];
 
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
	
  $arr_users = array(); // Users Array
	$arr_smartpoke = array(); // SmartPoke

	$arr_smartpoke['data'] = $arr_users;	
	$myfile = "../../json/smartpokeDB-".$session_id.".json";
	// $myfile = "rocotowifi/datatables/smartpokeDB-".$session_id.".json";
	try {
		//Convert updated array to JSON
		$jsondata = json_encode($arr_smartpoke, JSON_PRETTY_PRINT);

		//write json data into data.json file
		if (file_put_contents($myfile, $jsondata)) {
			echo 'Data successfully saved';
		}
		else echo "error";

	}
	catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}		

	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

	$where_spot = '';
	if ($idspot != '%') {
		$where_spot = "AND s.spot_id = '$idspot' ";															
	}

  include('../../library/opendb.php');

  #----------------- total new users ----------------------
  $sql_user = "SELECT username, firstname, lastname, mobilephone, email, ui.creationby ".
								"FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ".
								"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
								"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
								"JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = ui.creationby ".
								"WHERE operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot;
  $ret_user = pg_query($dbConnect, $sql_user);

	while ($row_user = pg_fetch_row($ret_user)) {
		$username = $row_user[0];
		$firstname = $row_user[1];
    $lastaname = $row_user[2];
    $mobilephone = $row_user[3];
    $email = $row_user[4];
    $hotspot = $row_user[5];
		$arr_users[] = array("0" => $mobilephone."-".$firstname, "1" => $firstname, "2" => $lastaname, "3" => $mobilephone, "4" => $email, "5" => $username, "6" => $hotspot);
  }
  include('../../library/closedb.php');

	$arr_smartpoke['data'] = $arr_users;
	$myfile = "../../datatables/smartpokeDB-".$session_id.".json";
	if (file_exists($myfile)) unlink($myfile);
	try {
		//Convert updated array to JSON
		$jsondata = json_encode($arr_smartpoke, JSON_PRETTY_PRINT);

		//write json data into data.json file
		if (file_put_contents($myfile, $jsondata)) {
			echo 'Data successfully saved';
		}
		else echo "error";

	}
	catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}		
	echo json_encode($arr_smartpoke);
	
?>