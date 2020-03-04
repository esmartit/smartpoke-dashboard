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
	
	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";


  include('../../library/opendb.php');
  $sql_city = "SELECT id, city_name FROM ".$configValues['TBL_RWCITY']." WHERE country_id = '$idcountry' ".$where_state." ".
							"ORDER BY city_name";
	$ret_city = pg_query($dbConnect, $sql_city);
  $city_arr = array();

	while ($row_city = pg_fetch_row($ret_city)) {

    $city_id = $row_city[0];
    $city_name = $row_city[1];
    
    $city_arr[] = array("id" => $city_id, "name" => $city_name);
  }
  include('../../library/closedb.php');
  echo json_encode($city_arr);
?>
