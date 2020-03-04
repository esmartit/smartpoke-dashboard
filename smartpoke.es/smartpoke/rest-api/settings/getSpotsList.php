<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];
  
  if (isset($_POST['spot_id']))
    $idspot = $_POST['spot_id'];
  elseif (isset($_GET['spot_id']))
    $idspot = $_GET['spot_id'];

	$where_spot = '';
	if ($idspot != '') {
	  $where_spot = "WHERE id = $idspot";
	} 

  include('../../library/opendb.php');
	$data = array();
	
  $sql_spot = "WITH spot AS ( ".
								"SELECT ROW_NUMBER() OVER (ORDER BY spot_id) AS id, s.spot_id, spot_name, business_type, country_name, state_name, city_name, ".
										"location_name, zipcode, timestart, timestop, s.country_id, s.state_id, s.city_id, s.location_id, business_id ".
								"FROM ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ".
								"JOIN ".$configValues['TBL_RWCOUNTRY']." AS co ON co.id = s.country_id ".
								"JOIN ".$configValues['TBL_RWSTATE']." AS st ON st.id = s.state_id ".
								"JOIN ".$configValues['TBL_RWCITY']." AS ci ON ci.id = s.city_id ".
								"JOIN ".$configValues['TBL_RWLOCATION']." AS l ON l.id = s.location_id ".
								"LEFT JOIN ".$configValues['TBL_RWBUSINESS']." AS b ON b.id = business_id ".
								"ORDER BY spot_name) ".
							"SELECT * FROM spot ".$where_spot;
	$ret_spot = pg_query($dbConnect, $sql_spot);
	if (pg_num_rows($ret_spot) >= 1) {
		$data = pg_fetch_all($ret_spot);		
	}
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
