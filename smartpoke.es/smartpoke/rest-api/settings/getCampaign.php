<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_id = $_SESSION['operator_id'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];
  
  $valmsgDate = date('Y-m-d');	

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

  if (isset($_POST['type']))
    $type = $_POST['type'];
  elseif (isset($_GET['type']))
    $type = $_GET['type'];


	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

	$where_spot = "";
	if ($idspot != '%') $where_spot = "AND s.spot_id = '$idspot'";
	
	$where_valid = "";
	if ($type != 'T') $where_valid = "AND validdate >= '$valmsgDate'";

	$where_operator = "AND operator_id = '$operator_profile_id'";
	if ($operator_profile_id != 1) 	$where_operator = "AND operator_id = '$operator_id'";

  include('../../library/opendb.php');

	$sql_sel_msg = "SELECT m.id, name ".
									"FROM ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ".
									"JOIN ".$esquema.".".$configValues['TBL_RWMESSAGES']." AS m ON m.spot_id = s.spot_id, ".	
													$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
									"WHERE sp.spot_id = s.spot_id ".$where_operator." AND access = 1 AND country_id = '$idcountry' ".
									$where_state." ".
									$where_city." ".
									$where_location." ".
									$where_spot." ".
									$where_valid;														
	$ret_sel_msg = pg_query($dbConnect, $sql_sel_msg);
  $message_arr = array();

	while ($row_sel_msg = pg_fetch_row($ret_sel_msg)) {

    $message_id = $row_sel_msg[0];
    $message_name = $row_sel_msg[1];
    
    $message_arr[] = array("id" => $message_id, "name" => $message_name);
  }
  include('../../library/closedb.php');
  echo json_encode($message_arr);
?>
