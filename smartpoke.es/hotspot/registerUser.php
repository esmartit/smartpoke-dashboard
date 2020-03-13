<?php

// ini_set('display_errors','On');
// error_reporting(E_ALL);

$arr_result = array(); // Array result

if (isset($_REQUEST['hotspotmac'])) $hotspotmac = $_REQUEST['hotspotmac'];
if (isset($_REQUEST['spot_id'])) $spot_id = $_REQUEST['spot_id'];
if (isset($_REQUEST['countrycode'])) $countrycode = $_REQUEST['countrycode'];
if (isset($_REQUEST['mobilephone'])) $mobilephone = $_REQUEST['mobilephone'];
if (isset($_REQUEST['hotspot_name'])) $hotspot_name = $_REQUEST['hotspot_name'];
if (isset($_REQUEST['username'])) $username = $_REQUEST['username'];
if (isset($_REQUEST['password'])) $password = $_REQUEST['password'];
if (isset($_REQUEST['email'])) $email = $_REQUEST['email'];
if (isset($_REQUEST['firstname'])) $firstname = $_REQUEST['firstname'];
if (isset($_REQUEST['lastname'])) $lastname = $_REQUEST['lastname'];
if (isset($_REQUEST['bdate'])) $birthdate = $_REQUEST['bdate'];
if (isset($_REQUEST['gender'])) $gender = $_REQUEST['gender'];
if (isset($_REQUEST['zipcode'])) $zip = $_REQUEST['zipcode'];
if (isset($_REQUEST['groupname'])) $groupname = $_REQUEST['groupname'];
if (isset($_REQUEST['lang'])) $lang = $_REQUEST['lang'];

$pin = $password;
include('lang/es.conf.php');
if ($lang == 'en')
    include('lang/en.conf.php');

$currDate = date('Y-m-d H:i:s');

include('library/common.php');
include('library/opendb.php');

$sql_user = "SELECT username FROM ".$configValues['TBL_RSUSERINFO']." ".
    "WHERE spot_id = '$spot_id' AND username = '$username'";
$ret_user = pg_query($dbConnect, $sql_user);
$row_user = pg_fetch_assoc($ret_user);
$user = $row_user['username'];

$sql_country = "SELECT country_phone_code FROM ".$configValues['TBL_RWCOUNTRY']." ".
    "WHERE country_code_ISO3 = '$countrycode'";
$ret_country = pg_query($dbConnect, $sql_country);
$row_country = pg_fetch_assoc($ret_country);
$countryphonecode = $row_country['country_phone_code'];

$mobilephonenumber = $countryphonecode.$mobilephone;

$sql_ins_ui = "INSERT INTO ".$configValues['TBL_RSUSERINFO']." ".
    "(spot_id, username, firstname, lastname, email, mobilephone, birthdate, gender, zip, creationdate, creationby, updatedate, updateby) ".
    "VALUES ('$spot_id', '$username', '$firstname', '$lastname', '$email', '$mobilephonenumber', '$birthdate', '$gender', '$zip', '$currDate', '$hotspotmac', '$currDate', '$hotspotmac')";
$ret_ins_ui = pg_query($dbConnect, $sql_ins_ui);

$sql_sel_user = "SELECT username FROM ".$configValues['TBL_RADCHECK']." ".
    "WHERE username = '$username'";
$ret_sel_user = pg_query($dbConnect, $sql_sel_user);
$row_sel_user = pg_fetch_assoc($ret_sel_user);
$user = $row_sel_user['username'];

if ($username != $user) {
    $sql_ins_rc = "INSERT INTO ".$configValues['TBL_RADCHECK']." ".
        "(username, attribute, op, value) ".
        "VALUES ('$username', 'Cleartext-Password', ':=', '$password')";
    $ret_ins_rc = pg_query($dbConnect, $sql_ins_rc);

    /* adding the user to the default group defined */
    $sql_ins_rug = "INSERT INTO ".$configValues['TBL_RADUSERGROUP']." ".
            "(username, groupname, priority) ".
            "VALUES ('$username', '$groupname', '".$configValues['CONFIG_GROUP_PRIORITY']."')";
    $ret_ins_rug = pg_query($dbConnect, $sql_ins_rug);
} else {
    $sql_upd_rc = "UPDATE ".$configValues['TBL_RADCHECK']." ".
        "SET value = '$password' ".
        "WHERE username = '$username'";
    $ret_upd_rc = pg_query($dbConnect, $sql_upd_rc);

    /* updating the user to the default group defined */
//    if (isset($configValues['CONFIG_GROUP_NAME']) && $configValues['CONFIG_GROUP_NAME'] != "") {
//        $sql_upd_rug = "UPDATE ".$configValues['TBL_RADUSERGROUP']." ".
//            "SET groupname =  '".$configValues['CONFIG_GROUP_NAME']."' ".
//            "WHERE username = '$username'";
//        $ret_upd_rug = pg_query($dbConnect, $sql_upd_rug);
//    }
    $sql_upd_rug = "UPDATE ".$configValues['TBL_RADUSERGROUP']." ".
            "SET groupname =  'groupname' ".
            "WHERE username = '$username'";
    $ret_upd_rug = pg_query($dbConnect, $sql_upd_rug);
}

$sql_msg = "SELECT id, description FROM ".$configValues['TBL_RWMESSAGES']." ".
    "WHERE spot_id = '$spot_id' AND name = 'Login' AND validdate >= '$currDate'";
$ret_msg = pg_query($dbConnect, $sql_msg);
$row_msg = pg_fetch_assoc($ret_msg);
$message_id = $row_msg['id'];
$message_description = $row_msg['description'];

$status = 0;
if ($message_id != '' ) {

    $phoneSMS = $mobilephonenumber;
    $messageSMS = $message_description;
    $senderSMS = $hotspot_name;

    $resultSMS = trim(sendWorldLine($phoneSMS, $messageSMS, $senderSMS)); // WorldLine Web SMS
    $resultSMS = 'OK';

    $status = 1;
    if (substr($resultSMS, 0, 2) == 'OK') $status = 0;
    $user_mac = substr($umac, 9, 8)."-".hashmac($umac);

    $sql_ins_msg = "INSERT INTO ".$configValues['TBL_RWMESSAGESDETAIL']." (spot_id, message_id, devicehashmac, username, acctstartdate, status, description) ".
        "VALUES ('$spot_id', $message_id, '$user_mac', '$username', '$currDate', '$status', '$resultSMS')";
    $ret_ins_msg = pg_query($dbConnect, $sql_ins_msg);
}

include('library/closedb.php');
if ($status == 0) $arr_result[] = array("section" => "go", "data" => $password);
else $arr_result[] = array("section" => "error", "data" => $l_errorSMS);

echo json_encode($arr_result);
?>
