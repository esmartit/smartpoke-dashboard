<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['schema']))
    $esquema = $_POST['schema'];
  elseif (isset($_GET['schema']))
    $esquema = $_GET['schema'];

  if (isset($_POST['idspot']))
    $idspot = $_POST['idspot'];
  elseif (isset($_GET['idspot']))
    $idspot = $_GET['idspot'];

  if (isset($_POST['user_id']))
    $user_id = $_POST['user_id'];
  elseif (isset($_GET['user_id']))
    $user_id = $_GET['user_id'];
  
	$where_user = '';			
	if ($user_id != '') {
	  $where_user = "WHERE id = $user_id";
  }

  include('../../library/opendb.php');
	$data = array();
	
	$sql_select = "WITH users AS ( ".
								"SELECT ROW_NUMBER() OVER (ORDER BY username) AS id, username, s.spot_name, ui.firstname, ui.lastname, email, mobilephone, ".
												"birthdate, gender, zip, flag_sms, ui.creationby, ui.spot_id ".
								"FROM  ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ".
                "LEFT JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
								"WHERE ui.spot_id = '$idspot') ".
								"SELECT * FROM users ".$where_user;
	$ret_select = pg_query($dbConnect, $sql_select);
	if (pg_num_rows($ret_select) > 0) $data = pg_fetch_all($ret_select);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
