<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

	$lang = $_SESSION['lang'];
	
	if ($lang == 'es') include('../../lang/es.php');
	else include('../../lang/en.php');

  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];
  
  if (isset($_POST['idspot']))
    $idspot = $_POST['idspot'];
  elseif (isset($_GET['idspot']))
    $idspot = $_GET['idspot'];

  if (isset($_POST['setting_id']))
    $setting_id = $_POST['setting_id'];
  elseif (isset($_GET['setting_id']))
    $setting_id = $_GET['setting_id'];

	$where_spot = "";
	if ($idspot != '') $where_spot = "WHERE se.spot_id = '$idspot' ";

	$where_setting = "";
	if ($setting_id != '') $where_setting = "WHERE id = '$setting_id'";

  include('../../library/opendb.php');
	$data = array();

  $sql_settings = "WITH settings AS ( ".
									"SELECT ROW_NUMBER() OVER (ORDER BY name) AS id, se.spot_id, spot_name, name, value ".
									"FROM ".$esquema.".".$configValues['TBL_RWSETTINGS']." AS se ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = se.spot_id ".
									$where_spot.") ".
									"SELECT * FROM settings ".$where_setting;
	$ret_settings = pg_query($dbConnect, $sql_settings);
  while ($row_settings = pg_fetch_row($ret_settings)) {
		
    switch($row_settings[3]) {
      case "ret":
        $description=$l_returning;
        break;
      case "time_ini":
        $description=$l_time_ini;
        break;
      case "time_end":
        $description=$l_time_end;
        break;
      case "msg_limit":
        $description=$l_messages;
        break;
    }
		$data[] = array("id" => $row_settings[0], "spot_id" => $row_settings[1], "spot_name" => $row_settings[2], "name" => $row_settings[3], "description" => $description, "value" => $row_settings[4]);
	}
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
