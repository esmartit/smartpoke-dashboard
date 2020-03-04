<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $session_id = $_SESSION['id'];
  
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

	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

  include('../../library/opendb.php');
  $sql_location = "SELECT id, location_name FROM ".$configValues['TBL_RWLOCATION']." WHERE country_id = '$idcountry' ".
									$where_state." ".
									$where_city." ".
									"ORDER BY location_name";
	$ret_location = pg_query($dbConnect, $sql_location);
  $location_arr = array();

	while ($row_location = pg_fetch_row($ret_location)) {

    $location_id = $row_location[0];
    $location_name = $row_location[1];
    
    $location_arr[] = array("id" => $location_id, "name" => $location_name);
  }
  include('../../library/closedb.php');
  echo json_encode($location_arr);
?>
