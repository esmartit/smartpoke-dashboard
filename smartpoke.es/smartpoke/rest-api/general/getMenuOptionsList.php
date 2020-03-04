<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');

  $operator_profile_id = $_SESSION['operator_profile_id'];
  $session_id = $_SESSION['id'];

  if (isset($_POST['menuoption_id']))
    $menuoption_id = $_POST['menuoption_id'];
  elseif (isset($_GET['menuoption_id']))
    $menuoption_id = $_GET['menuoption_id'];
  
	$where_option = '';			
	if ($menuoption_id != '') {
	  $where_option = "WHERE id = $menuoption_id";
  }

  include('../../library/opendb.php');
	$data = array();

  $sql_sel_menu = "SELECT id, title, icon, file, category, section, level, es, en ".
         "FROM ".$configValues['TBL_RSMENUOPTIONS']." ".$where_option." ".
         "ORDER BY category, section, level";
	$ret_sel_menu = pg_query($dbConnect, $sql_sel_menu);
	if (pg_num_rows($ret_sel_menu) > 0) $data = pg_fetch_all($ret_sel_menu);
	
  include('../../library/closedb.php');
	echo json_encode($data);

?>
