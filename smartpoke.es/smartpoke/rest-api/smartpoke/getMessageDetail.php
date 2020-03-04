<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

	include ('../../library/checklogin.php');
	include('../../library/pages_common.php');

	$session_id = $_SESSION['id'];

	if (isset($_POST['operator_id']))
			$operator_profile_id = $_POST['operator_id'];
	elseif (isset($_GET['operator_id']))
	  $operator_profile_id = $_GET['operator_id'];

	if (isset($_POST['datestart'])) 
		$datestart = $_POST['datestart'];
	elseif (isset($_GET['datestart']))
	  $datestart = $_GET['datestart'];

	if (isset($_POST['dateend'])) 
		$dateend = $_POST['dateend'];
	elseif (isset($_GET['dateend']))
	  $dateend = $_GET['dateend'];

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
	
  if (isset($_POST['message_id']))
    $message_id = $_POST['message_id'];
  elseif (isset($_GET['message_id']))
    $message_id = $_GET['message_id'];
    
  if (isset($_POST['status']))
    $status_id = $_POST['status'];
  elseif (isset($_GET['status']))
    $status_id = $_GET['status'];

	$arr_messages_month = array(); // Messages by month
	$arr_messages_per = array(); // Messages by period
	$arr_messages_table = array(); // Messages Table
	$arr_status = array(); // Messages Status
	$arr_result = array(); // Result
	$y = 0;
	
	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

	$where_spot = '';
	$where_spot_2 = '';
	if ($idspot != '%') {
		$where_spot = "AND s.spot_id = '$idspot' ";															
		$where_spot_2 = "AND md.spot_id = '$idspot'";															
	}

	$where_message = "";
	if ($message_id != '%') $where_message = "AND m.id::text = '$message_id' ";

	$where_status = "";
	if ($status_id != '%') $where_status = "AND status = '$status_id' ";

  include('../../library/opendb.php');


  $total_sms = 0;
  $total_sms_send = 0;
	$total_balance = 0;
  $total_sms_send_ok = 0;
  $total_sms_send_nok = 0;
  $tot_sms = 0;
  $tot_sms_send = 0;
  $tot_sms_send_ok = 0;
  $tot_sms_send_nok = 0;
	$flag_search = 0;
  
  $sql_spot = "SELECT s.spot_id, spot_name ".
			  "FROM ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ".
			  "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
			  "WHERE operator_id = '$operator_profile_id' AND access = 1 ".$where_spot;
  $ret_spot = pg_query($dbConnect, $sql_spot);
  
  while ($row_spot = pg_fetch_row($ret_spot)) {

		$spot_id = $row_spot[0];
		$sql_credit = "SELECT name, value FROM ".$esquema.".".$configValues['TBL_RWSETTINGS']." WHERE spot_id = '$spot_id' AND name='msg_limit'";
		$ret_values = pg_query($dbConnect, $sql_credit);
		$row_credit = pg_fetch_row($ret_values);
		$total_sms += $row_credit[1];	

		$sql_msg = "SELECT s.spot_name, status, COUNT(username) ".
				   "FROM ".$esquema.".".$configValues['TBL_RWMESSAGESDETAIL']." AS md ".
				   "JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON md.spot_id = s.spot_id ".
				   "JOIN ".$esquema.".".$configValues['TBL_RWMESSAGES']." AS m ON message_id = m.id ".
				   "WHERE DATE_PART('month', acctstartdate) = DATE_PART('month', '$datestart'::date) AND md.spot_id::text = '$row_spot[0]' ".
				   "GROUP BY s.spot_name, status";
		$ret_msg = pg_query($dbConnect, $sql_msg);

		while ($row_msg = pg_fetch_row($ret_msg)) {

		  $status_msg = $row_msg[1];
		  $msg_total = $row_msg[2];

		  $total_sms_send += $msg_total;
  
		  if ($status_msg == '0') $total_sms_send_ok += $msg_total;
		  else $total_sms_send_nok += $msg_total;

		}	
		$total_balance = $total_sms - $total_sms_send;
  }	

	$arr_message_month[] = array("total_sms" => $total_sms, "balance" => $total_balance, "ok" => $total_sms_send_ok, "nok" => $total_sms_send_nok);


  $sql_detail = "SELECT s.spot_name, m.name, username, ".
										"acctstartdate, status, devicehashmac, md.description ".
								"FROM ".$esquema.".".$configValues['TBL_RWMESSAGESDETAIL']." AS md ".
								"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON md.spot_id = s.spot_id ".
								"JOIN ".$esquema.".".$configValues['TBL_RWMESSAGES']." AS m ON message_id = m.id ".
								"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = md.spot_id ".
								"WHERE operator_id = '$operator_profile_id' AND access = 1 AND ".  
								 "(DATE(acctstartdate) BETWEEN '$datestart' AND '$dateend') ".
								$where_spot_2." ".$where_message." ".$where_status;
  $ret_detail = pg_query($dbConnect, $sql_detail);
  $tot_sms_send = pg_num_rows($ret_detail);

  while ($row_detail = pg_fetch_row($ret_detail)) {

		// $descriptionSMS = "";
		// if (strlen($row_detail[6]) > 19) $descriptionSMS = stateWorldLine(substr($row_detail[6], -19));
		$descriptionSMS = $row_detail[6];

	  if ($row_detail[4] == '0') {
			$tot_sms_send_ok += 1;	  	
			$status = 'OK';
	  } else {
			$tot_sms_send_nok += 1;
			$status = 'NOK';			  	
	  }
		
		$devicehashmac = $row_detail[5];
		if ($row_detail[5] == '-1000000') $devicehashmac = '';
		
		// $key_a = array_search($descriptionSMS, array_column($arr_status, 'description'));
		// if ($key_a === FALSE) {
		// 	$arr_status[$y]['description'] = $descriptionSMS;
		// 	$arr_status[$y]['total'] = 1;
		// 	$y = $y + 1;
		// } else {
		// 	$arr_status[$key_a]['description'] = $descriptionSMS;
		// 	$arr_status[$key_a]['total'] += 1;
		// }
		
		$arr_messages_table[] = array("spot_id" => $row_detail[0], "campaign_name" => $row_detail[1], "username" => $row_detail[2], "device" => $devicehashmac, "date" => $row_detail[3], "status" => $status, "description" => $descriptionSMS);			
  }
	$arr_messages_per[] = array("total_send" => $tot_sms_send, "ok" => $tot_sms_send_ok, "nok" => $tot_sms_send_nok);			
  include('../../library/closedb.php');
	
	$arr_result[] = array("section" => 'month', "data" => $arr_message_month);
	$arr_result[] = array("section" => 'period', "data" => $arr_messages_per);
	// $arr_result[] = array("section" => 'status', "data" => $arr_status);
	$arr_result[] = array("section" => 'table', "data" => $arr_messages_table);
	
	echo json_encode($arr_result);
													
?>
