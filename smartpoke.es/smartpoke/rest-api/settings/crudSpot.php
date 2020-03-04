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

  if (isset($_POST['spot_id']))
    $spot_id = $_POST['spot_id'];
  elseif (isset($_GET['spot_id']))
    $spot_id = $_GET['spot_id'];
    
  if (isset($_POST['spot_name']))
    $spot_name = $_POST['spot_name'];
  elseif (isset($_GET['spot_name']))
    $spot_name = $_GET['spot_name'];
    
  if (isset($_POST['business_id']))
    $business_id = $_POST['business_id'];
  elseif (isset($_GET['business_id']))
    $business_id = $_GET['business_id'];
    
  if (isset($_POST['timestart'])) 
    $timestart = $_POST['timestart'];
  elseif (isset($_GET['timestart']))
    $timestart = $_GET['timestart'];
  
  if (isset($_POST['timestop'])) 
    $timestop = $_POST['timestop'];
  elseif (isset($_GET['timestop']))
    $timestop = $_GET['timestop'];

  if (isset($_POST['idcountry']))
    $country_id = $_POST['idcountry'];
  elseif (isset($_GET['idcountry']))
    $country_id = $_GET['idcountry'];
    
  if (isset($_POST['idstate']))
    $state_id = $_POST['idstate'];
  elseif (isset($_GET['idstate']))
    $state_id = $_GET['idstate'];
    
  if (isset($_POST['idcity']))
    $city_id = $_POST['idcity'];
  elseif (isset($_GET['idcity']))
    $city_id = $_GET['idcity'];
    
  if (isset($_POST['idlocation'])) 
    $location_id = $_POST['idlocation'];
  elseif (isset($_GET['idlocation'])) 
    $location_id = $_GET['idlocation'];  	
	
  if (isset($_POST['zipcode']))
    $zip_code = $_POST['zipcode'];
  elseif (isset($_GET['zipcode']))
    $zip_code = $_GET['zipcode'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

	if ($action == 'I') {
    $sql_insert = "INSERT INTO ".$esquema.".".$configValues['TBL_RWSPOT']." ".
									"(spot_id, spot_name, timestart, timestop, country_id, state_id, city_id, location_id, ".
									"zipcode, business_id, creationdate, creationby, updatedate, updateby) ".
									"VALUES('$spot_id', '$spot_name', '$timestart', '$timestop', '$country_id', '$state_id', ".
									"'$city_id', '$location_id', '$zip_code', '$business_id', '$currDate', '$operator_user', '$currDate', '$operator_user')";
    $ret = pg_query($dbConnect, $sql_insert);
		if(!$sql_insert) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "insert", "message" => $l_insert_message);		
	}

	if ($action == 'U') {
    $sql_update = "UPDATE ".$esquema.".".$configValues['TBL_RWSPOT']." ".
						      "SET spot_name = '$spot_name', timestart = '$timestart', timestop = '$timestop', ".
										"country_id = '$country_id', state_id = '$state_id', city_id = '$city_id', location_id = '$location_id', ".
										"zipcode = '$zip_code', business_id = '$business_id', updatedate = '$currDate', updateby = '$operator_user' ".
						      "WHERE spot_id = '$spot_id'";
    $ret = pg_query($dbConnect, $sql_update);
		if(!$sql_update) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
		else $line_message = array("action" => "update", "message" => $l_update_message);		
	}

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
