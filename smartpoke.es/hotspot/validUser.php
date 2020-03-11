<?php

	// ini_set('display_errors','On');
	// error_reporting(E_ALL);

	$arr_result = array(); // Result Array
	$arr_mobile = array(); // Array mobile
 
  if (isset($_REQUEST['spot_id'])) $spot_id = $_REQUEST['spot_id'];  
  if (isset($_REQUEST['countrycode'])) $countrycode = $_REQUEST['countrycode'];
  if (isset($_REQUEST['mobilephone'])) $mobilephone = $_REQUEST['mobilephone'];
  if (isset($_REQUEST['hotspot_name'])) $hotspot_name = $_REQUEST['hotspot_name'];
  if (isset($_REQUEST['lang'])) $lang = $_REQUEST['lang'];

  include('lang/main.php');
  include('library/common.php');
  if (validatemobile($countrycode, $mobilephone) != 1 ) {
		$arr_result[] = array("section" => "error", "data" => $l_messagephone);
  } else {    
 
    $username = $countrycode.$mobilephone;

		include('library/opendb.php');
		
		$sql_ccphone = "SELECT	country_phone_code FROM	".$configValues['TBL_RWCOUNTRY']." WHERE country_code_iso3 = '$countrycode'";
		$ret_ccphone = pg_query($dbConnect, $sql_ccphone);
		$row_ccphone = pg_fetch_row($ret_ccphone);
		$countryphonecode = $row_ccphone[0];

    $sqluser = "SELECT rc.value ".
               "FROM ".$configValues['TBL_RSUSERINFO']." AS ui JOIN ".$configValues['TBL_RADCHECK']." AS rc ON rc.username = ui.username ".
               "WHERE spot_id = '$spot_id' AND ui.username = '$username'";
    $retuser = pg_query($dbConnect, $sqluser);
    $rowuser = pg_fetch_row($retuser);
    $password = $rowuser[0];
    
    if ($password != '') {
			$arr_result[] = array("section" => "go", "data" => $password);
    } else {
			
      $password = createPassword($configValues['CONFIG_PASSWORD_LENGTH'], $configValues['CONFIG_USER_ALLOWEDRANDOMCHARS']);
      $password = substr('1111'.$password,-4);

      $sql_msg = "SELECT id, description FROM ".$configValues['TBL_RWMESSAGES']." ".
		             "WHERE spot_id = '$spot_id' AND name = 'Registro'";
      $ret_msg = pg_query($dbConnect, $sql_msg);
      $row_msg = pg_fetch_assoc($ret_msg);
      $message_id = $row_msg['id'];
			
			$status = 0;
			if ($message_id != '' ) {
			
	      $message_description = $row_msg['description'];
      
        $phoneSMS = $countryphonecode.$mobilephone;
        $messageSMS = $message_description." $password";
        $senderSMS = $hotspot_name;
				$resultSMS = trim(sendWorldLine($phoneSMS, $messageSMS, $senderSMS)); // WorldLine Web SMS
				$resultSMS = 'OK';
				
				$status = 1;
				if (substr($resultSMS, 0, 2) == 'OK') $status = 0;
				$user_mac = substr($umac, 9, 8)."-".hashmac($umac);

				$currDate = date('Y-m-d H:i:s');

				$sql = "INSERT INTO ".$configValues['TBL_RWMESSAGESDETAIL']." ".
									"(spot_id, message_id, devicehashmac, username, acctstartdate, status, description) ".
									"VALUES ('$spot_id', $message_id, '$user_mac', '$username', '$currDate', '$status', '$resultSMS')";
	      $ret = pg_query($dbConnect, $sql);
			}

      if ($status == 0) $arr_result[] = array("section" => "ok", "data" => $password);
			else $arr_result[] = array("section" => "error", "data" => $l_errorSMS);
    }  
		include('library/closedb.php');
  } 
	echo json_encode($arr_result);
	 
?>