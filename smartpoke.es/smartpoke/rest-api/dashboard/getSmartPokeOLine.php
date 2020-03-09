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

  if (isset($_POST['radio_campaign']))
    $radio_campaign = $_POST['radio_campaign'];
	elseif (isset($_GET['radio_campaign']))
    $radio_campaign = $_GET['radio_campaign'];

  if (isset($_POST['datestart']))
		$datestart = $_POST['datestart'];
  elseif (isset($_GET['datestart']))
    $datestart = $_GET['datestart'];

  if (isset($_POST['dateend']))
		$dateend = $_POST['dateend'];
  elseif (isset($_GET['dateend']))
    $dateend = $_GET['dateend'];

  if (isset($_POST['datestart2']))
		$datestart2 = $_POST['datestart2'];
  elseif (isset($_GET['datestart2']))
    $datestart2 = $_GET['datestart2'];

  if (isset($_POST['dateend2']))
		$dateend2 = $_POST['dateend2'];
  elseif (isset($_GET['dateend2']))
    $dateend2 = $_GET['dateend2'];

  if (isset($_POST['timestart']))
		$timestart = $_POST['timestart'];
	elseif (isset($_GET['timestart']))
		$timestart = $_GET['timestart'];
	$time_ini = (int)substr($timestart, 0, 2);

  if (isset($_POST['timeend']))
		$timeend = $_POST['timeend'];
	elseif (isset($_GET['timeend']))
		$timeend = $_GET['timeend'];
	$time_end = (int)substr($timeend, 0, 2);

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

  if (isset($_POST['sensor_name']))
		$sensor_name = $_POST['sensor_name'];
  elseif (isset($_GET['sensor_name']))
		$sensor_name = $_GET['sensor_name'];

  if (isset($_POST['idstatus']))
		$status_id = $_POST['idstatus'];
  elseif (isset($_GET['idstatus']))
		$status_id = $_GET['idstatus'];

  switch($status_id) {
    case "IN":
			$where_pos = "AND pos = 'IN' ";
      break;
    case "LIMIT":
			$where_pos = "AND pos = 'LIMIT' ";
      break;
    case "OUT":
			$where_pos = "AND pos = 'OUT' ";
      break;
    default:
			$where_pos = "AND pos = 'TOTAL' ";
      break;
  }

  if (isset($_POST['time_min']))
    $time_min = $_POST['time_min'];
  elseif (isset($_GET['time_min']))
    $time_min = $_GET['time_min'];

  if (isset($_POST['time_max']))
    $time_max = $_POST['time_max'];
  elseif (isset($_GET['time_max']))
    $time_max = $_GET['time_max'];

  if (isset($_POST['presence']))
    $presence = $_POST['presence'];
  elseif (isset($_GET['presence']))
    $presence = $_GET['presence'];

	// Filter Presence
	$filter_presence = '';
	if ($presence > 1) {
		$filter_presence = "AND callingstationid IN (
							SELECT DISTINCT b.callingstationid AS device
							FROM ".$esquema.".rw_smartpoketotal AS b ".
							"WHERE (b.acctdate BETWEEN '$datestart2' AND '$dateend2') AND pos = 'TOTAL' ".
							"GROUP BY device ".
							"HAVING SUM(numto) >= $presence) ";
	}

	if (isset($_POST['brand_list']))
		$brand_list = $_POST['brand_list'];
	elseif (isset($_GET['brand_list']))
		$brand_list = $_GET['brand_list'];

	$sql_provider_list = "";
	  if ($brand_list != "0") {
		$x = array(",");
		$y = array("','");
		$provider = str_replace($x, $y, $brand_list);
		$sql_provider_list = "AND brand IN ('$provider') ";
	  }

  $arr_device_act = array(); // Total Activity - Status
	$arr_device_radact = array(); // Total Activity Hotspot   

	$arr_activity = array(); // Activity
	$arr_online = array(); // Online Array
	$y = 0; //Count activity;
  $z = 0; //Count activity hotspot;

	$where_state = "";
	if ($idstate != '%') $where_state = "AND state_id = '$idstate'";

	$where_city = "";
	if ($idcity != '%') $where_city = "AND city_id = '$idcity'";

	$where_location = "";
	if ($idlocation != '%') $where_location = "AND location_id = '$idlocation'";

	$where_spot = '';
	$where_spot_id2 = '';
	if ($idspot != '%') {
		$where_spot = "AND s.spot_id = '$idspot' ";
		$where_spot_id2 = "WHERE spot_id = '$idspot'";
	}

	$where_sensor = "";
	if ($sensor_name != '%') $where_sensor = "AND sensorname = '$sensor_name'";

	  include('../../library/opendb.php');

	for ($x = 0; $x <= 23; $x++) {
		$time_hr[$x] = $x;
	}

  $sql_activity = "SELECT pos, callingstationid, brand, ".
  													"SUM(tim00), SUM(tim01), SUM(tim02), SUM(tim03), SUM(tim04), SUM(tim05), SUM(tim06), ".
  													"SUM(tim07), SUM(tim08), SUM(tim09), SUM(tim10), SUM(tim11), SUM(tim12), SUM(tim13), SUM(tim14), ".
  													"SUM(tim15), SUM(tim16), SUM(tim17), SUM(tim18), SUM(tim19), SUM(tim20), SUM(tim21), SUM(tim22), ".
  													"SUM(tim23), SUM(timto), SUM(numto) ".
  								  "FROM ".$esquema.".".$configValues['TBL_RWSMARTPOKETOTAL']." AS smt ".
  									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = smt.spot_id, ".
  													$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
  									"WHERE sp.spot_id = s.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
  											$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".$where_pos." ".
  											"AND (acctdate BETWEEN '$datestart' AND '$dateend') ".$sql_provider_list." ".$filter_presence." ".
  											"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
										"GROUP BY pos, callingstationid, brand ".
  									"ORDER BY pos, callingstationid";
	
  $ret_activity = pg_query($dbConnect, $sql_activity);

  while ($row_activity = pg_fetch_row($ret_activity)) {

		$pos = $row_activity[0];
		$callingstationid = $row_activity[1];
		$device = substr($callingstationid, 9, 8)."-".hashmac($row_activity[1]);
		$brand = $row_activity[2];
		$tim00 = $row_activity[3];
		$tim01 = $row_activity[4];
		$tim02 = $row_activity[5];
		$tim03 = $row_activity[6];
		$tim04 = $row_activity[7];
		$tim05 = $row_activity[8];
		$tim06 = $row_activity[9];
		$tim07 = $row_activity[10];
		$tim08 = $row_activity[11];
		$tim09 = $row_activity[12];
		$tim10 = $row_activity[13];
		$tim11 = $row_activity[14];
		$tim12 = $row_activity[15];
		$tim13 = $row_activity[16];
		$tim14 = $row_activity[17];
		$tim15 = $row_activity[18];
		$tim16 = $row_activity[19];
		$tim17 = $row_activity[20];
		$tim18 = $row_activity[21];
		$tim19 = $row_activity[22];
		$tim20 = $row_activity[23];
		$tim21 = $row_activity[24];
		$tim22 = $row_activity[25];
		$tim23 = $row_activity[26];
		$timto = $row_activity[27];
		$numto = $row_activity[28];

		$tot_time = 0;
		$atime = 0;
		$tot_hours = 0;
		$first = 'F';

		if ($time_ini == 0 && $time_end == 23) $atime = $timto;
		else {
			
			for ($i = $time_ini; $i <= $time_end; $i++) {
				if ($time_hr[$i] == 0) {
					if ($tim00 > 0) {
						$hour_first = 0;
						$hour_last = 0;
						$first = 'T';
						$tot_time = $tim00;
					}
				}
				if ($time_hr[$i] == 1) {
					if ($tim01 > 0) {
						if ($first == 'F') {
							$hour_first = 1;
							$hour_last = 1;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 1;
						}
						$tot_time = $tot_time + $tim01;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
						$tot_hours = $tot_hours + ($hour_last - $hour_first);
					}
				}
				if ($time_hr[$i] == 2) {
					if ($tim02 > 0) {
						if ($first == 'F') {
							$hour_first = 2;
							$hour_last = 2;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 2;
						}
						$tot_time = $tot_time + $tim02;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 3) {
					if ($tim03 > 0) {
						if ($first == 'F') {
							$hour_first = 3;
							$hour_last = 3;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 3;
						}
						$tot_time = $tot_time + $tim03;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 4) {
					if ($tim04 > 0) {
						if ($first == 'F') {
							$hour_first = 4;
							$hour_last = 4;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 4;
						}
						$tot_time = $tot_time + $tim04;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 5) {
					if ($tim05 > 0) {
						if ($first == 'F') {
							$hour_first = 5;
							$hour_last = 5;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 5;
						}
						$tot_time = $tot_time + $tim05;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 6) {
					if ($tim06 > 0) {
						if ($first == 'F') {
							$hour_first = 6;
							$hour_last = 6;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 6;
						}
						$tot_time = $tot_time + $tim06;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 7) {
					if ($tim07 > 0) {
						if ($first == 'F') {
							$hour_first = 7;
							$hour_last = 7;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 7;
						}
						$tot_time = $tot_time + $tim07;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 8) {
					if ($tim08 > 0) {
						if ($first == 'F') {
							$hour_first = 8;
							$hour_last = 8;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 8;
						}
						$tot_time = $tot_time + $tim08;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 9) {
					if ($tim09 > 0) {
						if ($first == 'F') {
							$hour_first = 9;
							$hour_last = 9;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 9;
						}
						$tot_time = $tot_time + $tim09;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 10) {
					if ($tim10 > 0) {
						if ($first == 'F') {
							$hour_first = 10;
							$hour_last = 10;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 10;
						}
						$tot_time = $tot_time + $tim10;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 11) {
					if ($tim11 > 0) {
						if ($first == 'F') {
							$hour_first = 11;
							$hour_last = 11;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 11;
						}
						$pr11 = $pr11 + $numto;
						$tot_time = $tot_time + $tim11;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 12) {
					if ($tim12 > 0) {
						if ($first == 'F') {
							$hour_first = 12;
							$hour_last = 12;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 12;
						}
						$tot_time = $tot_time + $tim12;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 13) {
					if ($tim13 > 0) {
						if ($first == 'F') {
							$hour_first = 13;
							$hour_last = 13;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 13;
						}
						$tot_time = $tot_time + $tim13;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 14) {
					if ($tim14 > 0) {
						if ($first == 'F') {
							$hour_first = 14;
							$hour_last = 14;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 14;
						}
						$tot_time = $tot_time + $tim14;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 15) {
					if ($tim15 > 0) {
						if ($first == 'F') {
							$hour_first = 15;
							$hour_last = 15;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 15;
						}
						$tot_time = $tot_time + $tim15;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 16) {
					if ($tim16 > 0) {
						if ($first == 'F') {
							$hour_first = 16;
							$hour_last = 16;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 16;
						}
						$tot_time = $tot_time + $tim16;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 17) {
					if ($tim17 > 0) {
						if ($first == 'F') {
							$hour_first = 17;
							$hour_last = 17;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 17;
						}
						$tot_time = $tot_time + $tim17;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 18) {
					if ($tim18 > 0) {
						if ($first == 'F') {
							$hour_first = 18;
							$hour_last = 18;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 18;
						}
						$tot_time = $tot_time + $tim18;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 19) {
					if ($tim19 > 0) {
						if ($first == 'F') {
							$hour_first = 19;
							$hour_last = 19;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 19;
						}
						$tot_time = $tot_time + $tim19;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 20) {
					if ($tim20 > 0) {
						if ($first == 'F') {
							$hour_first = 20;
							$hour_last = 20;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 20;
						}
						$tot_time = $tot_time + $tim20;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 21) {
					if ($tim21 > 0) {
						if ($first == 'F') {
							$hour_first = 21;
							$hour_last = 21;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 21;
						}
						$tot_time = $tot_time + $tim21;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 22) {
					if ($tim22 > 0) {
						if ($first == 'F') {
							$hour_first = 22;
							$hour_last = 22;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 22;
						}
						$tot_time = $tot_time + $tim22;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
				if ($time_hr[$i] == 23) {
					if ($tim23 > 0) {
						if ($first == 'F') {
							$hour_first = 23;
							$hour_last = 23;
							$first = 'T';
						} else {
							$hour_first = $hour_last;
							$hour_last = 23;
						}
						$tot_time = $tot_time + $tim23;
						// $tot_hours = $tot_hours + (($hour_last - $hour_first) * 3600);
					}
				}
			}
			$atime = $tot_time;
			// if ($tot_hours > 0) $atime = $tot_hours;
		}
		// $clave = $acctyear.$acctmonth.$acctday.$device;
		if (($pos == $status_id) || ($status_id == '%')) {
	      $key_a = array_search($device, array_column($arr_device_act, 'device'));
	      if ($key_a === FALSE) {
				// $arr_device_act[$y]['clave'] = $clave;
					$arr_device_act[$y]['device'] = $device;

	        switch($pos) {
	          case "IN":
	            $arr_device_act[$y]['IN'] = 1;
	            $arr_device_act[$y]['time_in'] = $atime;
	            $arr_device_act[$y]['LIMIT'] = 0;
	            $arr_device_act[$y]['time_limit'] = 0;
	            $arr_device_act[$y]['OUT'] = 0;
	            $arr_device_act[$y]['time_out'] = 0;
	            break;
	          case "LIMIT":
	            $arr_device_act[$y]['IN'] = 0;
	            $arr_device_act[$y]['time_in'] = 0;
	            $arr_device_act[$y]['LIMIT'] = 1;
	            $arr_device_act[$y]['time_limit'] = $atime;
	            $arr_device_act[$y]['OUT'] = 0;
	            $arr_device_act[$y]['time_out'] = 0;
	            break;
	          case "OUT":
	            $arr_device_act[$y]['IN'] = 0;
	            $arr_device_act[$y]['time_in'] = 0;
	            $arr_device_act[$y]['LIMIT'] = 0;
	            $arr_device_act[$y]['time_limit'] = 0;
	            $arr_device_act[$y]['OUT'] = 1;
	            $arr_device_act[$y]['time_out'] = $atime;
	            break;
	          case "TOTAL":
	            $arr_device_act[$y]['IN'] = 1;
	            $arr_device_act[$y]['time_in'] = $atime;
	            $arr_device_act[$y]['LIMIT'] = 0;
	            $arr_device_act[$y]['time_limit'] = 0;
	            $arr_device_act[$y]['OUT'] = 0;
	            $arr_device_act[$y]['time_out'] = 0;
	            break;
	        }
	        $arr_device_act[$y]['time_total'] = $arr_device_act[$y]['time_total'] + $atime;
					$y = $y + 1;
	      } else {
	        switch($pos) {
	          case "IN":
	            $arr_device_act[$key_a]['time_in'] = $arr_device_act[$key_a]['time_in'] + $atime;
	            if ($arr_device_act[$key_a]['IN'] == 0) $arr_device_act[$key_a]['IN'] = 1;
						if ($arr_device_act[$key_a]['LIMIT'] == 1) $arr_device_act[$key_a]['LIMIT'] = 0;
						if ($arr_device_act[$key_a]['OUT'] == 1) $arr_device_act[$key_a]['OUT'] = 0;
	            break;
	          case "LIMIT":
	            $arr_device_act[$key_a]['time_limit'] = $arr_device_act[$key_a]['time_limit'] + $atime;
	            if ($arr_device_act[$key_a]['IN'] == 0) {
	              if ($arr_device_act[$key_a]['LIMIT'] == 0) $arr_device_act[$key_a]['LIMIT'] = 1;
						if ($arr_device_act[$key_a]['OUT'] == 1) $arr_device_act[$key_a]['OUT'] = 0;
	            }
	            break;
	          case "OUT":
	            $arr_device_act[$key_a]['time_out'] = $arr_device_act[$key_a]['time_out'] + $atime;
	            if ($arr_device_act[$key_a]['IN'] == 0) {
	              if ($arr_device_act[$key_a]['LIMIT'] == 0) {
	                if ($arr_device_act[$key_a]['OUT'] == 0) $arr_device_act[$key_a]['OUT'] = 1;
	              }
	            }
	            break;
	          case "TOTAL":
	            $arr_device_act[$key_a]['time_in'] = $arr_device_act[$key_a]['time_in'] + $atime;
	            if ($arr_device_act[$key_a]['IN'] == 0) $arr_device_act[$key_a]['IN'] = 1;
						if ($arr_device_act[$key_a]['LIMIT'] == 1) $arr_device_act[$key_a]['LIMIT'] = 0;
						if ($arr_device_act[$key_a]['OUT'] == 1) $arr_device_act[$key_a]['OUT'] = 0;
	            break;
	        }
	        $arr_device_act[$key_a]['time_total'] = $arr_device_act[$key_a]['time_total'] + $atime;
	      }
		}
	  #------------------------------ Datos HotSpot --------------------------------------

	  $sql_user = "SELECT DISTINCT ud.username, calledstationid, h.spot_id, ".
																"ui.firstname, ui.lastname, ui.mobilephone, traffic ".
								"FROM ".$esquema.".".$configValues['TBL_RSUSERDEVICE']." AS ud ".
								"JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ud.username = ui.username ".
								"JOIN ".$esquema.".".$configValues['TBL_RADACCT']." AS r ON ud.username = r.username ".
								"JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS h ON mac = calledstationid ".
								"WHERE  ud.callingstationid = '$callingstationid'";
	  $ret_user = pg_query($dbConnect, $sql_user);

	    while ($row_user = pg_fetch_row($ret_user)) {
			$username = $row_user[0];
			$hotspot = $row_user[1];
			$hsspot_id = $row_user[2];
			$first_name = $row_user[3];
			$last_name = $row_user[4];
			$mobile = $row_user[5];
			$totaltraffic = $row_user[6];

			if ($totaltraffic >= $traffic) {

				$key_ar = array_search($device, array_column($arr_device_radact, 'device'));
				if ($key_ar === FALSE) {
				  $arr_device_radact[$z]['device'] = $device;
				  $arr_device_radact[$z]['username'] = $username;
				  $arr_device_radact[$z]['firstname'] = $first_name;
				  $arr_device_radact[$z]['lastname'] = $last_name;
				  $arr_device_radact[$z]['mobile'] = $mobile;
				  $arr_device_radact[$z]['traffic'] = $totaltraffic;
				  $arr_device_radact[$z][$hsspot_id] = $hsspot_id;
				  $z = $z + 1;
				} else {
				  $arr_device_radact[$key_ar]['device'] = $device;
				  $arr_device_radact[$key_ar]['username'] = $username;
				  $arr_device_radact[$key_ar]['firstname'] = $first_name;
				  $arr_device_radact[$key_ar]['lastname'] = $last_name;
				  $arr_device_radact[$key_ar]['mobile'] = $mobile;
				  $arr_device_radact[$key_ar]['traffic'] = $totaltraffic;
				  $arr_device_radact[$key_ar][$hsspot_id] = $hsspot_id;
				}
			}
	  }
  }

  $sql_loc = "SELECT se.spot_id, sensorname ".
             "FROM ".$esquema.".".$configValues['TBL_RWSENSOR']." AS se ".
  						 	"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = se.spot_id, ".
  						 					$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ".
  						 	"WHERE sp.spot_id = se.spot_id AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
  						 			$where_state." ".$where_city." ".$where_location." ".$where_spot." ".$where_sensor." ".
  							"ORDER BY se.spot_id, sensorname";
  $ret_loc = pg_query($dbConnect, $sql_loc);
	$n = 0;

	for ($i = 0; $i <= COUNT($arr_device_act); $i++) {
	  // $clave = $arr_device_act[$i]['clave'];
	  $device = $arr_device_act[$i]['device'];
	  $pos_in = $arr_device_act[$i]['IN'];
	  $pos_limit = $arr_device_act[$i]['LIMIT'];
	  $pos_out = $arr_device_act[$i]['OUT'];

	  if ($pos_in == 1) $time_total = $arr_device_act[$i]['time_in'];
	  if ($pos_limit == 1) $time_total = $arr_device_act[$i]['time_limit'];
	  if ($pos_out == 1) $time_total = $arr_device_act[$i]['time_out'];

	  if ($time_total >= $time_min && $time_total <= $time_max) {
	    $key_sp = array_search($device, array_column($arr_device_radact, 'device'));
	    if ($key_sp !== FALSE) {
			  $username = $arr_device_radact[$key_sp]['username'];
			  $first_name = trim($arr_device_radact[$key_sp]['firstname']);
			  $last_name = trim($arr_device_radact[$key_sp]['lastname']);
			  $mobile = $arr_device_radact[$key_sp]['mobile'];
			  $totaltraffic = $arr_device_radact[$key_sp]['traffic'];

				$line = '<b>'.$first_name.', '.$last_name.'<br>+'.$mobile.'<br>'.toxbyte($totaltraffic).'</b>';
				$arr_activity[$n] = array("0" => $mobile.'-'.$first_name, "1" => $device, "2" => $line);

				$cols_sensor = 3;

				$ret_sensor = pg_query($dbConnect, $sql_loc);
				while ($row_sensor = pg_fetch_row($ret_sensor)) {

				  $spotid = $row_sensor[0];
				  $sensorname = $row_sensor[1];

				  $sql_sensoracct = "SELECT DISTINCT devicehashmac, spot_id ".
									"FROM ".$esquema.".".$configValues['TBL_RWSENSORTOTAL']." ".
									"WHERE (spot_id = '$spotid' ) AND (sensorname = '$sensorname') AND ".
											   "(acctdate BETWEEN '$datestart' AND '$dateend') AND ".
											   "(devicehashmac = '$device') AND pos = 'TOTAL'";
				  $ret_sensoracct = pg_query($dbConnect, $sql_sensoracct);
				  $sensorrows = pg_num_rows($ret_sensoracct);

				  $local = "<span class='glyphicon glyphicon-remove' style='color:#FF0000'>";
				  if ($sensorrows > 0) {
						$row_sensoracct = pg_fetch_row($ret_sensoracct);
						$spot_idsensor = $row_sensoracct[1];

						$local = "<span class='glyphicon glyphicon-ok' style='color:#00FF00'>";
						if ($arr_device_radact[$key_sp][$spotid] != $spot_idsensor) $local = "<span class='glyphicon glyphicon-ok' style='color:#FF9900'>";

				  }
					$arr_activity[$n][$cols_sensor] = $local;
					$cols_sensor = $cols_sensor +  1;
					$local='';
				}
				$n = $n + 1;		
	    }
		}
	}
	include('../../library/closedb.php');

	$arr_online['data'] = $arr_activity;
	$myfile = "../../datatables/smartpokeOline-".$session_id.".json";
	if (file_exists($myfile)) unlink($myfile);
	try {
		//Convert updated array to JSON
		$jsondata = json_encode($arr_online, JSON_PRETTY_PRINT);

		//write json data into data.json file
		if (file_put_contents($myfile, $jsondata)) {
			echo 'Data successfully saved';
		}
		else echo "error";

	}
	catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}		
	echo json_encode($arr_online);

?>