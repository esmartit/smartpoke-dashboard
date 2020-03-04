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

  if (isset($_POST['idlocation']))
    $idlocation = $_POST['idlocation'];
  elseif (isset($_GET['idlocation']))
    $idlocation = $_GET['idlocation'];

	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

  include('../../library/opendb.php');
  $sql_zipcode = "SELECT id, zip_code FROM ".$configValues['TBL_RWZIPCODE']." WHERE country_id = '$idcountry' ".
									$where_state." ".
									$where_city." ".
									$where_location." ".
									"ORDER BY zip_code LIMIT 1";
	$ret_zipcode = pg_query($dbConnect, $sql_zipcode);
  $zipcode_arr = array();

	while ($row_zipcode = pg_fetch_row($ret_zipcode)) {

    $zipcode_id = $row_zipcode[0];
    $zipcode_name = $row_zipcode[1];
    
    $zipcode_arr[] = array("id" => $zipcode_id, "name" => $zipcode_name);
  }
  include('../../library/closedb.php');
  echo json_encode($zipcode_arr);
?>
