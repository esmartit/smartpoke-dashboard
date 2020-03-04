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

  if (isset($_POST['idspot']))
    $idspot = $_POST['idspot'];
  elseif (isset($_GET['idspot']))
    $idspot = $_GET['idspot'];

  if (isset($_POST['ope_id']))
    $ope_id = $_POST['ope_id'];
  elseif (isset($_GET['ope_id']))
    $ope_id = $_GET['ope_id'];
	
  if (isset($_POST['access']))
    $access = $_POST['access'];
  elseif (isset($_GET['access']))
    $access = $_GET['access'];
	  
  include('../../library/opendb.php');
	$data = array();
	
	$check = 0;
	if ($access == 0) $check = 1;
	
  $sql_udp_spotope = "UPDATE ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." ".
											"SET access = $check, updatedate = '$currDate', updateby='$operator_user' ".
											"WHERE spot_id = '$idspot' AND operator_id = '$ope_id'";
	$ret_udp_spotope = pg_query($dbConnect, $sql_udp_spotope);
	if(!$sql_udp_spotope) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
	else $line_message = array("action" => "update", "message" => $l_update_message);		
	
  include('../../library/closedb.php');
	echo json_encode($line_message);

?>
