<?php

	// ini_set('display_errors','On');
	// error_reporting(E_ALL);

	$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	srand((double)microtime()*1000000 );
	$rand = rand(1,9);
	$session_id = $rand.substr(md5($REMOTE_ADDR), 0, 11+$rand);
	$session_id .= substr(md5(rand(1,1000000)), rand(1,32-$rand), 21-$rand);
	session_id($session_id);
	ini_set('session.gc_maxlifetime', 60*60);
	session_start();

	$errorMessage = '';
	$_SESSION['id'] = $session_id;
	$_SESSION['radio_checkdate'] = '0';
	$today = date("Y-m-d H:i:s");
	$_SESSION['timestart'] = '00:00:00';
	$_SESSION['timeend'] = '23:59:59';

	include('library/opendb.php');
	
	$operator_user = $_POST['operator_user'];
	$operator_pass = $_POST['operator_pass'];

	// check if the user id and password combination exist in database
	$password = hash_hmac('sha512', $operator_pass, 'eSmartIT');

	$sql_operator = "SELECT id, username, password, esquema, name, firstname, lastname, profile_id, lang ".
		     "FROM ".$configValues['TBL_RSOPERATORS']." AS o ".
				 "JOIN ".$configValues['TBL_RWCLIENT']." AS c ON c.client = o.client ".
		     "WHERE username = '$operator_user' AND password = '$password'";
	$ret_operator = pg_query($dbConnect, $sql_operator);
	if(!$ret_operator) {
		echo pg_last_error($dbConnect);
		exit;
	}
	$num_rows = pg_num_rows($ret_operator);

	if ($num_rows == 1) {

	  // the user id and password match,
	  // set the session

		$row = pg_fetch_assoc($ret_operator);
    $operator_id = $row['id'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$client_id = $row['esquema'];
		$c_name = $row['name'];
		$operator_profile_id=$row['profile_id'];
		$passwordDB = $row['password'];
		$lang = $row['lang'];

		if ($lang == '') {
			$lang = $_POST['lang'];
		}

		if ($password == $passwordDB) {
			$_SESSION['esmartit_logged_in'] = true;
			$_SESSION['operator_user'] = $operator_user;
      $_SESSION['operator_id'] = $operator_id;
			$_SESSION['operator_profile_id'] = $operator_profile_id;
			$_SESSION['lang'] = $lang;

			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
			$_SESSION['client_id'] = $client_id;
			$_SESSION['c_name'] = $c_name;
			// lets update the lastlogin time for this operator
			$date = date("Y-m-d H:i:s");
			$sql_upd_operator = "UPDATE ".$configValues['TBL_RSOPERATORS']." ".
					"SET lastlogin='$date', lang = '$lang' WHERE username='$operator_user'";

			$ret_upd_operator = pg_query($dbConnect, $sql_upd_operator);
			if(!$ret_upd_operator) {
				echo pg_last_error($dbConnect);
				exit;
			}
			include('library/closedb.php');

			header('Location: index.php');
			exit;
	  } else {
	    header( "Location: login.php?error='Wrong Password'");
	    exit;
	  }
  } else {
    header( "Location: login.php?error='$num_rows'");
    exit;
  }
		
?>
