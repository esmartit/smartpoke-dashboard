<?php

	include('library/pages_common.php');

	include ('library/checklogin.php');

	$session_id = $_SESSION['id'];
	include('lang/main.php');
 
  $esquema = $_POST['schema'];
  $msg_spot_id = $_POST['spotmsg_id'];
  $message_id = $_POST['message_id'];

	$msg_spot = get_spotname($esquema, $msg_spot_id);
	$msg_desc = get_msgdescription($esquema, $msg_spot_id, $message_id);

	$list = $_POST['id'];
	$ok = 0;
	$nok = 0;
	foreach ($list as $data) {

		$msg_mobile = substr($data, 0, strpos($data, "-"));
		$msg_name = substr($data, (strpos($data, "-") + 1), (strlen($data) - strpos($data, "-")));
		$msg_device = '';
		$msg_username = get_username($esquema, $msg_spot_id, $msg_mobile);

		$phoneSMS = $msg_mobile;
		// $messageSMS = $msg_desc;
		$messageSMS = trim($msg_name).', '.$msg_desc;
		
		$senderSMS = $msg_spot;
		
		// $line_message = $phoneSMS.' - '.$msg_username.' - '.$messageSMS.' - '.$senderSMS;
		$status = 1;
		$resultSMS = trim(sendWorldLine($phoneSMS, $messageSMS, $senderSMS)); // WorldLine Web SMS
		if (substr($resultSMS, 0, 2) == 'OK') {
			$status = 0;
			$ok = $ok + 1;
		} else $nok = $nok + 1;
		$currDate = date('Y-m-d H:i:s');

		include('library/opendb.php');
		$sql_insert = "INSERT INTO ".$esquema.".".$configValues['TBL_RWMESSAGESDETAIL']." (spot_id, message_id, devicehashmac, username, acctstartdate, status, description) ".
		       "VALUES ('$msg_spot_id', $message_id, '$msg_device', '$msg_username', '$currDate', '$status', '$resultSMS')";
		$ret_insert = pg_query($dbConnect, $sql_insert);
		if(!$ret_insert) {
		  $line_message = "<div><i class='fa fa-thumbs-down'></i>".pg_last_error($dbConnect)."</div></br>";
		}
	}

	$line_message = "<div><i class='fa fa-thumbs-up'> </i>".$l_send_message_ok.$ok."</div></br><div><i class='fa fa-thumbs-down'> </i>".$l_send_message_nok.$nok."</div>";
	include('library/closedb.php');
	echo $line_message;
	
?>
