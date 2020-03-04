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
  
  if (isset($_POST['menuoption_id']))
    $menuoption_id = $_POST['menuoption_id'];
  elseif (isset($_GET['menuoption_id']))
    $menuoption_id = $_GET['menuoption_id'];

  if (isset($_POST['title_menu']))
    $title_menu = $_POST['title_menu'];
  elseif (isset($_GET['title_menu']))
    $title_menu = $_GET['title_menu'];

  if (isset($_POST['icon_menu']))
    $icon_menu = $_POST['icon_menu'];
  elseif (isset($_GET['icon_menu']))
    $icon_menu = $_GET['icon_menu'];

  if (isset($_POST['file_menu']))
    $file_menu = $_POST['file_menu'];
  elseif (isset($_GET['file_menu']))
    $file_menu = $_GET['file_menu'];

  if (isset($_POST['category_menu']))
    $category_menu = $_POST['category_menu'];
  elseif (isset($_GET['category_menu']))
    $category_menu = $_GET['category_menu'];

  if (isset($_POST['section_menu']))
    $section_menu = $_POST['section_menu'];
  elseif (isset($_GET['section_menu']))
    $section_menu = $_GET['section_menu'];

  if (isset($_POST['level_menu']))
    $level_menu = $_POST['level_menu'];
  elseif (isset($_GET['level_menu']))
    $level_menu = $_GET['level_menu'];

  if (isset($_POST['lang_es']))
    $lang_es = $_POST['lang_es'];
  elseif (isset($_GET['lang_es']))
    $lang_es = $_GET['lang_es'];

  if (isset($_POST['lang_en']))
    $lang_en = $_POST['lang_en'];
  elseif (isset($_GET['lang_en']))
    $lang_en = $_GET['lang_en'];

  if (isset($_POST['action']))
    $action = $_POST['action'];
  elseif (isset($_GET['action']))
    $action = $_GET['action'];

  include('../../library/opendb.php');
	$line_message = array();

  if ($action == 'D') {

    $sql_sel_section = "SELECT section, level ".
           "FROM ".$configValues['TBL_RSMENUOPTIONS']." ".
           "WHERE id = $menuoption_id";
		$ret_sel_section = pg_query($dbConnect, $sql_sel_section);
		if(!$ret_sel_section) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
		else {
			
			$row = pg_fetch_assoc($ret_sel_section);
	    $section = $row['section'];
	    $level = $row['level'];
    
	    if ($level == 0) {
		    $line_message = array("action" => "delete", "message" => $l_level0_message);			
	    } else {
	      if ($level == 1) {
			    $line_message = array("action" => "delete", "message" => $l_level1_message);			
	      } else {

	        $sql_del_optprofile = "DELETE FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
																"WHERE section = '$section'";
					$ret_del_optprofile = pg_query($dbConnect, $sql_del_optprofile);
					if(!$ret_del_optprofile) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
					else {
						
		        $sql_del_opt = "DELETE FROM ".$configValues['TBL_RSMENUOPTIONS']." ".
														"WHERE id = $menuoption_id";
						$ret_del_opt = pg_query($dbConnect, $sql_del_opt);
						if(!$ret_del_opt) $line_message = array("action" => "delete", "message" => pg_last_error($dbConnect));
						else $line_message = array("action" => "delete", "message" => $l_delete_message);
					}
	      }		    
	    }
		}

  } else {
		if ($action == 'I') {
      $sql_ins_opt = "INSERT INTO ".$configValues['TBL_RSMENUOPTIONS']." ".
											"(title, icon, file, category, section, level, es, en, creationdate, creationby, updatedate, updateby) ".
											"VALUES('$title_menu', '$icon_menu', '$file_menu', '$category_menu', '$section_menu', '$level_menu', '$lang_es', '$lang_en', '$currDate', '$operator_user', '$currDate', '$operator_user')";
			$ret_ins_opt = pg_query($dbConnect, $sql_ins_opt);
			if(!$ret_ins_opt) $line_message = array("action" => "insert", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "insert", "message" => $l_insert_message);		
		}

		if ($action == 'U') {
      $sql_upd_opt = "UPDATE ".$configValues['TBL_RSMENUOPTIONS']." ".
											"SET title = '$title_menu', icon = '$icon_menu', file = '$file_menu', category = '$category_menu', section = '$section_menu', level = '$level_menu', es = '$lang_es', en = '$lang_en', updatedate = '$currDate', updateby='$operator_user' ".
											"WHERE id = '$menuoption_id'";
			$ret_upd_opt = pg_query($dbConnect, $sql_upd_opt);
			if(!$ret_upd_opt) $line_message = array("action" => "update", "message" => pg_last_error($dbConnect));
			else $line_message = array("action" => "update", "message" => $l_update_message);		
		}
  }

  include('../../library/closedb.php');
	echo json_encode($line_message);
	
?>
