<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_id = $_SESSION['operator_id'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];
  
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

	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";
	
	$where_operator = "AND operator_id = '$operator_profile_id'";
	if ($operator_profile_id != 1) 	$where_operator = "AND operator_id = '$operator_id'";

  include('../../library/opendb.php');
	$sql_sel_spot = "SELECT s.spot_id, spot_name ".
									"FROM ".$esquema.".".$configValues['TBL_RWSPOT']." AS s, ".
													$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
									"WHERE sp.spot_id = s.spot_id ".$where_operator." AND access = 1 AND country_id = '$idcountry' ".
									$where_state." ".
									$where_city." ".
									$where_location;
	$ret_sel_spot = pg_query($dbConnect, $sql_sel_spot);
  $spot_arr = array();

	while ($row_sel_spot = pg_fetch_row($ret_sel_spot)) {

    $spot_id = $row_sel_spot[0];
    $spot_name = $row_sel_spot[1];
    
    $spot_arr[] = array("id" => $spot_id, "name" => $spot_name);
  }
  include('../../library/closedb.php');
  echo json_encode($spot_arr);
?>
