<?php

  function build_sorter($key) {
    return function ($a, $b) use ($key) {
      //return strnatcmp($a[$key], $b[$key]);
      if($a[$key]==$b[$key]) return 0;
      return $a[$key] < $b[$key] ? 1: -1;      
    };
  }

  $loginpath = $_SERVER['PHP_SELF'];
  include ('library/checklogin.php');
  $page = '$sb_dashboard1';

  $operator_id = $_SESSION['operator_id'];
  $operator_user = $_SESSION['operator_user'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $client_id = $_SESSION['client_id'];
  $lang = $_SESSION['lang'];
  $currDate = date('Y-m-d H:i:s');

  $session_id = $_SESSION['id'];
  include('lang/main.php');

  include('library/pages_common.php');
  $show_access = opt_buttons($dbSocket, $page, $operator_profile_id, 'show_btn');
  
  if (isset($_POST['spot_id']))
    $spot_id = $_POST['spot_id'];
  elseif (isset($_GET['spot_id']))
    $spot_id = $_GET['spot_id'];
  else
    $spot_id = '%';
    
  if (isset($_POST['id_client']))
    $id_client = $_POST['id_client'];
  elseif (isset($_GET['id_client']))
    $id_client = $_GET['id_client'];
  else
    $id_client = $client_id;
    
  $sensor_name = $_SESSION['sensor_name'];
  if (isset($_POST['sensor_name'])) {
    $_SESSION['sensor_name'] = $_POST['sensor_name'];
    $sensor_name = $_SESSION['sensor_name'];
  }

  if (isset($_POST['radio_checkdate'])) {
    $_SESSION['radio_checkdate'] = $_POST['radio_checkdate'];
    $radio_checkdate = $_SESSION['radio_checkdate'];
  } elseif (isset($_GET['radio_checkdate']))
    $radio_checkdate = $_GET['radio_checkdate'];
  else
    $radio_checkdate = $_SESSION['radio_checkdate'];

  $checked_1 = 'checked';
  $checked_2 = '';
  $show_range = 0;
  if ($radio_checkdate == '1') {
    $checked_1 = '';
    $checked_2 = 'checked';
    $show_range = 1;
  }

  $datestart = $_SESSION['datestart'];
  if (isset($_POST['datestart'])) {
    $_SESSION['datestart'] = $_POST['datestart'];
    $datestart = $_SESSION['datestart'];
  }
  $datestartspan = date("d M Y", strtotime($datestart));

  $dateend = $_SESSION['dateend'];;
  if (isset($_POST['dateend'])) {
    $_SESSION['dateend'] = $_POST['dateend'];
    $dateend = $_SESSION['dateend'];
  }
  $dateendspan = date("d M Y", strtotime($dateend));

  $datestart2 = $_SESSION['datestart2'];
  if (isset($_POST['datestart2'])) {
    $_SESSION['datestart2'] = $_POST['datestart2'];
    $datestart2 = $_SESSION['datestart2'];
  }
  $datestartspan2 = date("d M Y", strtotime($datestart2));

  $dateend2 = $_SESSION['dateend2'];;
  if (isset($_POST['dateend2'])) {
    $_SESSION['dateend2'] = $_POST['dateend2'];
    $dateend2 = $_SESSION['dateend2'];
  }
  $dateendspan2 = date("d M Y", strtotime($dateend2));

  $timestart=$_SESSION['timestart'];
  if (isset($_POST['timestart'])) {
    $_SESSION['timestart'] = $_POST['timestart'];
    $timestart = $_SESSION['timestart'];
  }

  $timeend=$_SESSION['timeend'];
  if (isset($_POST['timeend'])) {
    $_SESSION['timeend'] = $_POST['timeend'];
    $timeend = $_SESSION['timeend'];
  }

  if (isset($_POST['button']))
    $button = $_POST['button'];
  elseif (isset($_GET['button']))
    $button = $_GET['button'];
  else
    $button = '';

  $totalbigdata = 0; 
  $totalbigdata_o = 0;
  $totalbigdata_in = 0; 
  $totalbigdata_in_o = 0;
  $totalbigdatavisits_in = 0; 
  $totalbigdatavisits_in_o = 0;

  $bigdata = stats_val($totalbigdata, $totalbigdata_o);
  $bigdata_o = stats_val($totalbigdata_o, 0);
  $bigdata_in = stats_val($totalbigdata_in, $totalbigdata_in_o);
  $bigdata_in_o = stats_val($totalbigdata_in_o, 0);
  $bigdatavisits_in = stats_val($totalbigdatavisits_in, $totalbigdatavisits_in_o);
  $bigdatavisits_in_o = stats_val($totalbigdatavisits_in_o, 0);

  $gdbigdata = percent_val($totalbigdata_in/$totalbigdata);
  $gdbigdata_o = percent_val($totalbigdata_in_o/$totalbigdata_o);
  $gdbigdatavisits = percent_val($totalbigdatavisits_in/$totalbigdata_in);
  $gdbigdatavisits_o = percent_val($totalbigdatavisits_in_o/$totalbigdata_in_o);
  
  $totalvisitsrows = 0; 
  $totalvisitsrows_o = 0;

  $totalacctrow = 0; 
  $totalacctrow_o = 0;
  $totalinrow = 0; 
  $totalinrow_o = 0;
  $totallimitrow = 0; 
  $totallimitrow_o = 0;
  $totaloutrow = 0; 
  $totaloutrow_o = 0;

  $visits = stats_val($totalvisitsrows, $totalvisitsrows_o);
  $visits_o = stats_val($totalvisitsrows_o, 0);

  $totalacct = stats_val($totalacctrow, $totalacctrow_o);
  $totalacct_o = stats_val($totalacctrow_o, 0);
  $in = stats_val($totalinrow, $totalinrow_o);
  $in_o = stats_val($totalinrow_o, 0);
  $limit = stats_val($totallimitrow, $totallimitrow_o);
  $limit_o = stats_val($totallimitrow_o, 0);
  $out = stats_val($totaloutrow, $totaloutrow_o);
  $out_o = stats_val($totaloutrow_o, 0);

  $gdin = percent_val($totalinrow/$totalacctrow);
  $gdin_o = percent_val($totalinrow_o/$totalacctrow_o);
  $gdlimit = percent_val($totallimitrow/$totalacctrow);
  $gdlimit_o = percent_val($totallimitrow_o/$totalacctrow_o);
  $gdout = percent_val($totaloutrow/$totalacctrow);
  $gdout_o = percent_val($totaloutrow_o/$totalacctrow_o);

  $dateselect = date('Y-m-d', strtotime($currDate));
  if (($datestart == $dateend) && ($datestart == $dateselect))
    $file_1 = 'rw_sensoracct_1';
  else   
    $file_1 = 'rw_sensoracct_2';
    
  if (($datestart2 == $dateend2) && ($datestart2 == $dateselect))
    $file_2 = 'rw_sensoracct_1';
  else   
    $file_2 = 'rw_sensoracct_2';    

  if ($button == 'submit') {

    $arr_device_bd = array(); // BigData
    $arr_device_bd_o = array(); // BigData Anterior
    $arr_device_bdin = array(); // BigData IN
    $arr_device_bdin_o = array(); // BigData IN Anterior
    $arr_device_bdvisitsin = array(); // BigData Visits IN
    $arr_device_bdvisitsin_o = array(); // BigData Visits IN Anterior

    $arr_device = array(); // Total Visits
    $arr_device_o = array(); // Total Visits Anterior
    $arr_device_act = array(); // Total Activity - Status
    $arr_device_act_o = array(); // Total Activity Anterior - Status
    
    $totalacctdevice = 0;
    $x = 0; //Count devices;
    
    for ($i = 1; $i <= 7; $i++) {
      $tot_in[$i] = 0;
      $tot_limit[$i] = 0;
      $tot_out[$i] = 0;
      $tot_in_o[$i] = 0;
      $tot_limit_o[$i] = 0;
      $tot_out_o[$i] = 0;
    }      

    include('library/opendb.php');
    $sql_spot = "SELECT s.id, spot_name ".
                "FROM ".$configValues['TBL_RWSPOT']." AS s ".
                "JOIN ".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON spot_id = s.id ".
                "WHERE s.client_id = '$id_client' AND s.id LIKE '$spot_id' AND operator_id = '$operator_profile_id' AND access = 1";
    $res_spot = $dbSocket->query($sql_spot);
    include('library/closedb.php');
		
    while ($row_spot = $res_spot->fetchRow()) {
      
      include('library/opendb.php');
      $sql_status = "SELECT sensorname, pwr_in, pwr_limit, pwr_out ".
                    "FROM ".$configValues['TBL_RWSENSOR']." AS se ".
                    "JOIN ".$configValues['TBL_RWSPOT']." AS s ON s.id = se.spot_id ".
                    "JOIN ".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = se.spot_id ".
                    "WHERE se.client_id = '$id_client' AND se.spot_id LIKE '$row_spot[0]' AND sensorname LIKE '$sensor_name' AND operator_id = '$operator_profile_id' AND access = 1";
      $res_status = $dbSocket->query($sql_status);
      include('library/closedb.php');
      
      $_SESSION['ret'] = setting_values($dbSocket, $id_client, $row_spot[0], 'ret');
      $_SESSION['time_ini'] = setting_values($dbSocket, $id_client, $row_spot[0], 'time_ini');
      $_SESSION['time_end'] = setting_values($dbSocket, $id_client, $row_spot[0], 'time_end');
        
      while ($row_status = $res_status->fetchRow()) {
        
        $sensor = $row_status[0]; 
        $pwr_in = $row_status[1];
        $pwr_limit = $row_status[2];
        $pwr_out = $row_status[3];
		
        $acctpower="(acctpower < -1 AND acctpower >= ".$pwr_out.")";

        $acctpower_in="(acctpower < -1 AND acctpower >= ".$pwr_in.")";
        $acctpower_limit="(acctpower < ".$pwr_in." AND acctpower >= ".$pwr_limit.")";
        $acctpower_out="(acctpower < ".$pwr_limit." AND acctpower >= ".$pwr_out.")";
          
        $activity="IF(acctpower >= ".$pwr_in.", 'IN', IF(acctpower >= ".$pwr_limit.", 'LIMIT', 'OUT'))";
      
        include('library/opendb.php');
        
        #----------------- total bigdata ----------------------
        $sql_bigdata = "SELECT DISTINCT devicehashmac ". 
                       "FROM ".$file_1." ".
                       "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                       		  "(acctstartdate BETWEEN '$datestart' AND '$dateend') AND ".
                              "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                              "(acctsessiontime > 0) AND ".
                              "$acctpower AND ".
                              "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ";
        $res_bigdata = $dbSocket->query($sql_bigdata);
        while ($row_bigdata = $res_bigdata->fetchRow()) {
        
          $arr_device_bd[] = $row_bigdata[0];
        }
            
        #----------------- total bigdata IN ----------------------
        $sql_bigdata_in = "SELECT DISTINCT devicehashmac ". 
                          "FROM ".$file_1." ".
                          "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                      		     "(acctstartdate BETWEEN '$datestart' AND '$dateend') AND ".
                                 "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                                 "(acctsessiontime > 0) AND ".
                                 "$acctpower_in AND ".
                                 "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ";
        $res_bigdata_in = $dbSocket->query($sql_bigdata_in);
        while ($row_bigdata_in = $res_bigdata_in->fetchRow()) {
        
          $arr_device_bdin[] = $row_bigdata_in[0];
        }
            
        #----------------- total bigdata Visits Q IN ----------------------
        $sql_bigdatavisits_in = "SELECT DISTINCT devicehashmac, SUM(acctsessiontime) AS time ". 
                          "FROM ".$file_1." ".
                          "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                      		     "(acctstartdate BETWEEN '$datestart' AND '$dateend') AND ".
                                 "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                                 "(acctsessiontime > 0) AND ".
                                 "$acctpower_in AND ".
                                 "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ".
                          "GROUP BY devicehashmac ".
                          "HAVING (time >= ".$_SESSION['time_ini']." AND time <= ".$_SESSION['time_end'].") ".
                          "ORDER BY devicehashmac";
        $res_bigdatavisits_in = $dbSocket->query($sql_bigdatavisits_in);
        while ($row_bigdatavisits_in = $res_bigdatavisits_in->fetchRow()) {
        
          $device = $row_bigdatavisits_in[0];
          if (!in_array($device, $arr_device_bdvisitsin)) {
            $arr_device_bdvisitsin[] = $device;
          }
          $totaltime = $totaltime + $row_bigdatavisits_in[1];
        }
            
        #----------------- total visits ----------------------
        $sql_visits = "SELECT DISTINCT acctdayweek AS day, devicehashmac, COUNT(devicehashmac) AS total, SUM(acctsessiontime) AS time ". 
                      "FROM ".$file_1." ".
                      "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                      		 "(acctstartdate BETWEEN '$datestart' AND '$dateend') AND ".
                             "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                             "(acctsessiontime > 0) AND ".
                             "$acctpower AND ".
                             "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ".
                      "GROUP BY day, devicehashmac ".
                      "HAVING (time >= ".$_SESSION['time_ini']." AND time <= ".$_SESSION['time_end'].") ".
                      "ORDER BY devicehashmac, day";
                      
        $res_visits = $dbSocket->query($sql_visits);
        while ($row_visits = $res_visits->fetchRow()) {
        
          $device = $row_visits[1];
          if (!in_array($device, $arr_device)) {
            $arr_device[] = $device;
            $totalvisitsrows = $totalvisitsrows + 1;
          }
        }    
              
        #----------------- total activity ----------------------
        $sql_activity = "SELECT acctdayweek AS day, $activity AS pos, devicehashmac, COUNT(devicehashmac) AS total, SUM(acctsessiontime) AS time ".
                        "FROM ".$file_1." ".
                        "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                      		   "(acctstartdate BETWEEN '$datestart' AND '$dateend') AND ".
                               "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                               "(acctsessiontime > 0) AND ".
                               "$acctpower AND ".
                               "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ".
                        "GROUP BY day, pos, devicehashmac ".
                        "HAVING (time >= ".$_SESSION['time_ini']." AND time <= ".$_SESSION['time_end'].") ".
                        "ORDER BY pos, devicehashmac, day";
        $res_activity = $dbSocket->query($sql_activity);
        while ($row_activity = $res_activity->fetchRow()) {
        
          $day = $row_activity[0];
          $pos = $row_activity[1];
          $device = $row_activity[2];
          if (!in_array($device, $arr_device_act)) {
            $arr_device_act[] = $device;
            $totalacctrow = $totalacctrow + 1;
            switch($pos) {
              case "IN":
                $tot_in[$day] = $tot_in[$day] + 1;
                $totalinrow = $totalinrow + 1;
                break;
              case "LIMIT":
                $tot_limit[$day] = $tot_limit[$day] + 1;
                $totallimitrow = $totallimitrow + 1;
                break;
              case "OUT":
                $tot_out[$day] = $tot_out[$day] + 1;
                $totaloutrow = $totaloutrow + 1;
                break;
            }            
          }
        }    
        
        #------------------- Total Devices ---------------------
        $sql_device = "SELECT DISTINCT devicemac, IFNULL(description, 'UNKNOWN') AS description, COUNT( devicemac ) AS total, SUM(acctsessiontime) AS time ".
                      "FROM ".$file_1." ".
                      "LEFT JOIN ".$configValues['TBL_RWPROVIDERS']." ON LEFT(devicemac, 8) = providermac ".
                      "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                        	 "(acctstartdate BETWEEN '$datestart' AND '$dateend') AND ".
                             "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                             "(acctsessiontime > 0) AND ".
                             "$acctpower AND ".
                             "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ".
                      "GROUP BY devicemac ".
                      "HAVING (time >= ".$_SESSION['time_ini']." AND time <= ".$_SESSION['time_end'].") ".
                      "ORDER BY total DESC";
        $res_device = $dbSocket->query($sql_device);

        while($row_device = $res_device->fetchRow()) {
        
          $total_arr = $row_device[2];
          $totalacctdevice = $totalacctdevice + $row_device[2];

          if ($row_device[1] == "UNKNOWN") 
            $vendor = MacVendor($row_device[0]);
          else
            $vendor = $row_device[1];
            
          if ($x == 0) {
            $a_device[$x]['vendor'] = $vendor;
            $a_device[$x]['total'] = $total_arr;
            $x = $x + 1;
          } else {
            $key = array_search($vendor, array_column($a_device, 'vendor'));
            if ($key === FALSE) {
              $a_device[$x]['vendor'] = $vendor;
              $a_device[$x]['total'] = $total_arr;
              $x = $x + 1;
            } else {
              $a_device[$key]['total'] = $a_device[$key]['total'] + $total_arr;          
            }
          }

        } 
        #------------------- Total Devices ---------------------

        if ($show_range == 1 ) {
          #----------------- total bigdata ----------------------
          $sql_bigdata_o = "SELECT DISTINCT devicehashmac ". 
                           "FROM ".$file_2." ".
                           "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                       		      "(acctstartdate BETWEEN '$datestart2' AND '$dateend2') AND ".
                                  "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                                  "(acctsessiontime > 0) AND ".
                                  "$acctpower AND ".
                                  "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ";
          $res_bigdata_o = $dbSocket->query($sql_bigdata_o);
          while ($row_bigdata_o = $res_bigdata_o->fetchRow()) {
        
            $arr_device_bd_o[] = $row_bigdata_o[0];
          }    

          #----------------- total bigdata IN ----------------------
          $sql_bigdata_in_o = "SELECT DISTINCT devicehashmac ". 
                              "FROM ".$file_2." ".
                              "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                       		         "(acctstartdate BETWEEN '$datestart2' AND '$dateend2') AND ".
                                     "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                                     "(acctsessiontime > 0) AND ".
                                     "$acctpower_in AND ".
                                     "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ";
          $res_bigdata_in_o = $dbSocket->query($sql_bigdata_in_o);
          while ($row_bigdata_in_o = $res_bigdata_in_o->fetchRow()) {
        
            $arr_device_bdin_o[] = $row_bigdata_in_o[0];
          }    

          #----------------- total bigdata Visits Q IN ----------------------
          $sql_bigdatavisits_in_o = "SELECT DISTINCT devicehashmac, SUM(acctsessiontime) AS time ". 
                                  "FROM ".$file_2." ".
                                  "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                           		         "(acctstartdate BETWEEN '$datestart2' AND '$dateend2') AND ".
                                         "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                                         "(acctsessiontime > 0) AND ".
                                         "$acctpower_in AND ".
                                         "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ".
                                  "GROUP BY devicehashmac ".
                                  "HAVING (time >= ".$_SESSION['time_ini']." AND time <= ".$_SESSION['time_end'].") ".
                                  "ORDER BY devicehashmac";
          $res_bigdatavisits_in_o = $dbSocket->query($sql_bigdatavisits_in_o);
          while ($row_bigdatavisits_in_o = $res_bigdatavisits_in_o->fetchRow()) {
        
            $device = $row_bigdatavisits_in_o[0];
            if (!in_array($device, $arr_device_bdvisitsin_o)) {
              $arr_device_bdvisitsin_o[] = $device;
            }
            $totaltime_o = $totaltime_o + $row_bigdatavisits_in_o[1];
          }
            
          #----------------- total visits ----------------------
          $sql_visits_o = "SELECT acctdayweek AS day, COUNT(devicehashmac) AS total, SUM(acctsessiontime) AS time ".
                          "FROM ".$file_2." ".
                          "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                       		     "(acctstartdate BETWEEN '$datestart2' AND '$dateend2') AND ".
                                 "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                                 "(acctsessiontime > 0) AND ".
                                 "$acctpower AND ".
                                 "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ".
                          "GROUP BY day, devicehashmac ".
                          "HAVING (time >= ".$_SESSION['time_ini']." AND time <= ".$_SESSION['time_end'].")";
          $res_visits_o = $dbSocket->query($sql_visits_o);
          while ($row_visits_o = $res_visits_o->fetchRow()) {
        
            $device = $row_visits_o[1];
            if (!in_array($device, $arr_device_o)) {
              $arr_device_o[] = $device;
              $totalvisitsrows_o = $totalvisitsrows_o + 1;
            }
          }    

          #----------------- total activity ----------------------
          $sql_activity_o = "SELECT acctdayweek AS day, $activity AS pos, devicehashmac, COUNT(devicehashmac) AS total, SUM(acctsessiontime) AS time ".
                            "FROM ".$file_2." ".
                            "WHERE (client_id = '$id_client') AND (spot_id LIKE '$row_spot[0]') AND (sensorname LIKE '$sensor') AND ". 
                      		       "(acctstartdate BETWEEN '$datestart2' AND '$dateend2') AND ".
                                   "(acctstarttime BETWEEN '$timestart' AND '$timeend') AND ".
                                   "(acctsessiontime > 0) AND ".
                                   "$acctpower AND ".
                                   "devicehashmac NOT IN (SELECT devicehashmac FROM ".$configValues['TBL_RWDEVICES']." WHERE client_id = '$id_client' AND spot_id LIKE '$row_spot[0]') ".
                            "GROUP BY day, pos, devicehashmac ".
                            "HAVING (time >= ".$_SESSION['time_ini']." AND time <= ".$_SESSION['time_end'].")";
          $res_activity_o = $dbSocket->query($sql_activity_o);
          while ($row_activity_o = $res_activity_o->fetchRow()) {
        
            $day = $row_activity_o[0];
            $pos = $row_activity_o[1];
            $device = $row_activity_o[2];
            if (!in_array($device, $arr_device_act_o)) {
              $arr_device_act[] = $device;
              $totalacctrow_o = $totalacctrow_o + 1;
              switch($pos) {
                case "IN":
                  $tot_in_o[$day] = $tot_in_o[$day] + 1;
                  $totalinrow_o = $totalinrow_o + 1;
                  break;
                case "LIMIT":
                  $tot_limit_o[$day] = $tot_limit_o[$day] + 1;
                  $totallimitrow_o = $totallimitrow_o + 1;
                  break;
                case "OUT":
                  $tot_out_o[$day] = $tot_out_o[$day] + 1;
                  $totaloutrow_o = $totaloutrow_o + 1;
                  break;
              }            
            }
          }    
        }
        include('library/closedb.php');        
      }          
      if ($show_range == 1 ) {
        $totalbigdata_o = COUNT(array_unique($arr_device_bd_o));
        $totalbigdata_in_o = COUNT(array_unique($arr_device_bdin_o));
        $totalbigdatavisits_in_o = COUNT($arr_device_bdvisitsin_o);
        $totaltimevisits_o = ($totaltime_o/$totalbigdatavisits_in_o);

        $bigdata_o = stats_val($totalbigdata_o, 0);
        $bigdata_in_o = stats_val($totalbigdata_in_o, 0);      
        $bigdatavisits_in_o = stats_val($totalbigdatavisits_in_o, 0);      
        $gdbigdata_o = percent_val($totalbigdata_in_o/$totalbigdata_o);
        $gdbigdatavisits_o = percent_val($totalbigdatavisits_in_o/$totalbigdata_in_o);
        
        $visits_o = stats_val($totalvisitsrows_o, 0);

        $totalacct_o = stats_val($totalacctrow_o, 0);
        $in_o = stats_val($totalinrow_o, 0);
        $limit_o = stats_val($totallimitrow_o, 0);
        $out_o = stats_val($totaloutrow_o, 0);

        $gdin_o = percent_val($totalinrow_o/$totalacctrow_o);
        $gdlimit_o = percent_val($totallimitrow_o/$totalacctrow_o);
        $gdout_o = percent_val($totaloutrow_o/$totalacctrow_o);
        
      }

      $totalbigdata = COUNT(array_unique($arr_device_bd));
      $totalbigdata_in = COUNT(array_unique($arr_device_bdin));      
      $totalbigdatavisits_in = COUNT($arr_device_bdvisitsin);
      $totaltimevisits = ($totaltime/$totalbigdatavisits_in);
    
      $bigdata = stats_val($totalbigdata, $totalbigdata_o);
      $bigdata_in = stats_val($totalbigdata_in, $totalbigdata_in_o);
      $bigdatavisits_in = stats_val($totalbigdatavisits_in, $totalbigdatavisits_in_o);      
      $gdbigdata = percent_val($totalbigdata_in/$totalbigdata);
      $gdbigdatavisits = percent_val($totalbigdatavisits_in/$totalbigdata_in);

      $visits = stats_val($totalvisitsrows, $totalvisitsrows_o);

      $totalacct = stats_val($totalacctrow, $totalacctrow_o);
      $in = stats_val($totalinrow, $totalinrow_o);
      $limit = stats_val($totallimitrow, $totallimitrow_o);
      $out = stats_val($totaloutrow, $totaloutrow_o);

      $gdin = percent_val($totalinrow/$totalacctrow);
      $gdlimit = percent_val($totallimitrow/$totalacctrow);
      $gdout = percent_val($totaloutrow/$totalacctrow);

    }    
  }      
  
echo"<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset=\"utf-8\"/>
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"/>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>

    <title>$l_title</title>

    <!-- Bootstrap -->
    <link href=\"../vendors/bootstrap/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
    <!-- Font Awesome -->
    <link href=\"../vendors/font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\">

    <!-- Custom Theme Style -->
    <link href=\"../build/css/custom.css\" rel=\"stylesheet\">
  </head>

  <body class='nav-md'>
    <div class='container body'>
      <div class='main_container'>
        <div class='col-md-3 left_col'>
          <div class='left_col scroll-view'>";
            include('headersidebar.php');
            include('sidebarmenu.php');

            echo "
        <!-- page content -->
        <div class='right_col' role='main'>
          <div class='row x_title'>

          </div>

          <div class=''>
            <div class='row'>
              <div class='col-md-6 col-sm-6 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_query</h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>
                  <form id='select_form' name='select_form' method='post' action='$loginpath' data-parsley-validate class='form-horizontal form-label-left'>
                    <div class='form-group'>
                      <label class='control-label col-md-3 col-sm-3 col-xs-12'></label>
                      <div class='radio'>
                        <label>
                          <input type='radio' value='0' $checked_1 name='radio_checkdate' onclick=this.form.submit()>$l_checkdate_range_s
                        </label>
                        <label>
                        </label>
                        <label>
                          <input type='radio' value='1' $checked_2 name='radio_checkdate' onclick=this.form.submit()>$l_checkdate_range_c
                        </label>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label class='control-label col-md-3 col-sm-3 col-xs-12'>$l_select_date</label>
                      <div class='col-md-6 col-sm-6 col-xs-12'>
                        <div id='reportrange' class='pull-left' style='background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc'>
                          <i class='glyphicon glyphicon-calendar fa fa-calendar'></i>
                          <span>$datestartspan - $dateendspan</span> <b class='caret'></b>
                        </div>
                        <input type='hidden' name='datestart' id='datestart' value='$datestart'/>
                        <input type='hidden' name='dateend' id='dateend' value='$dateend'/>
                      </div>
                    </div>";

                    if ($show_range == 1 ){
                      echo  "<div class='form-group'>
                        <label class='control-label col-md-3 col-sm-3 col-xs-12'></label>
                        <div class='col-md-6 col-sm-6 col-xs-12'>
                          <div id='reportrange2' class='pull-left' style='background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc'>
                            <i class='glyphicon glyphicon-calendar fa fa-calendar'></i>
                            <span>$datestartspan2 - $dateendspan2</span> <b class='caret'></b>
                          </div>
                          <input type='hidden' name='datestart2' id='datestart2' value='$datestart2'/>
                          <input type='hidden' name='dateend2' id='dateend2' value='$dateend2'/>
                        </div>
                      </div>";
                    }

                    echo "<div class='form-group'>
                      <label class='control-label col-md-3 col-sm-3 col-xs-12'>$l_timestart</label>
                      <div class='col-md-3 col-sm-3 col-xs-12'>$autovalue
                        <input type='text' name='timestart' $show_access id='timestart' class='form-control col-md-10' value='$timestart' />
                      </div>
                      <label class='control-label col-md-3 col-sm-3 col-xs-12'>$l_timeend</label>
                      <div class='col-md-3 col-sm-3 col-xs-12'>$autovalue
                        <input type='text' name='timeend' $show_access id='timeend' class='form-control col-md-10' value='$timeend' />
                      </div>                    
                    </div>
                    
                    <div class='form-group'>
                      <label class='control-label col-md-3 col-sm-3 col-xs-12'>$l_select_client</label>
                      <div class='col-md-6 col-sm-6 col-xs-12'>
                        <select class='form-control' $enabled_cli name='id_client' onChange=this.form.submit()>
                          <option value='%' selected=$selected>$l_select_client </option>";

                            include('library/opendb.php');
                            $sql = "SELECT client, name FROM ".$configValues['TBL_RWCLIENT'];
                            $res = $dbSocket->query($sql);
                            include('library/closedb.php');
		
                            while ($row = $res->fetchRow()) {

                              $row_client = utf8_encode($row[1]);
                              $selected = '';
                              if ($id_client == $row[0]) $selected = 'selected = $id_client';
                                echo "<option value=$row[0] $selected>$row_client</option>";
                            }
                        echo "</select>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label class='control-label col-md-3 col-sm-3 col-xs-12'>$l_spots</label>
                      <div class='col-md-6 col-sm-6 col-xs-12'>
                        <select class='form-control' $show_access name='spot_id' onChange=this.form.submit()>
                          <option value='%' selected=$selected>$l_all_spot </option>";

                            include('library/opendb.php');
                            $sql = "SELECT s.id, spot_name FROM ".$configValues['TBL_RWSPOT']." AS s ".
                                   "JOIN ".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON spot_id = s.id ".
                                   "WHERE s.client_id = '$id_client' AND operator_id = '$operator_profile_id' AND access = 1";
                            $res = $dbSocket->query($sql);
                            include('library/closedb.php');
		
                            while ($row = $res->fetchRow()) {

                              $row_spot = utf8_encode($row[1]);
                              $selected = '';
                              if ($spot_id == $row[0]) $selected = 'selected = $spot_id';
                                echo "<option value=$row[0] $selected>$row_spot</option>";
                            }
                        echo "</select>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label class='control-label col-md-3 col-sm-3 col-xs-12'>$l_select_sensor</label>
                      <div class='col-md-3 col-sm-3 col-xs-12'>
                        <select class='form-control' $show_access name='sensor_name' onChange=this.form.submit()>
                          <option value='%' selected=$selected>$l_all_sensor </option>";

                            include('library/opendb.php');
                            $sql = "SELECT sensorname, location FROM ".$configValues['TBL_RWSENSOR']." AS s ".
                                   "JOIN ".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
                                   "WHERE s.client_id='$id_client' AND s.spot_id LIKE '$spot_id' AND operator_id = '$operator_profile_id' AND access = 1";
                            $res = $dbSocket->query($sql);
                            include('library/closedb.php');
		
                            while ($row = $res->fetchRow()) {

                              $row_sensor = $row[1];
                              $selected = '';
                              if ($sensor_name == $row[0]) $selected = 'selected = $sensor_name';
                                echo "<option value=$row[0] $selected>$row_sensor</option>";
                            }
                        echo "</select>
                      </div>
                    </div>
                    <div align='right'>
                      <button name='button' type='submit' $show_access class='btn btn-primary' value='submit'>$l_search</button>
                    </div>
                  </form>
                    
                </div>
              </div>
              <div class='clearfix'></div>
            </div>            
            <div class='row'>";

            if ($show_range == 1) {
              echo "<div class='col-md-6 col-sm-6 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_titlelinebigdata - $l_actual<small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>

                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bd</span>
                      <div class='count'>$bigdata[0]</div>
                      <span class='count_bottom'><i class='$bigdata[1]'><i class='$bigdata[2]'></i>$bigdata[3] </i></span>
                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bd_in</span>
                      <div class='count'>$bigdata_in[0]</div>
                      <span class='count_bottom'><i class='$bigdata_in[1]'><i class='$bigdata_in[2]'></i>$bigdata_in[3] </i></span>
                    </div>
                    <div class='col-md-4 col-xs-12'>
                      <div id='bigdata' style='width:50%; height:150px;'></div>
                    </div>
                  </div>
                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bdvisits_in</span>
                      <div class='count'>$bigdatavisits_in[0]</div>
                      <span class='count_bottom'><i class='$bigdatavisits_in[1]'><i class='$bigdatavisits_in[2]'></i>$bigdatavisits_in[3] </i></span>
                    </div>
                    <div class='col-md-4 col-xs-12'>
                      <div id='bigdatavisits' style='width:50%; height:150px;'></div>
                    </div>
                  </div>  
                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_qualifiedavgtime</span>
                      <div class='count'>".time2str($totaltimevisits)."</div>
                    </div>
                  </div>
                  <div class='x_content'>
                    <div id='echart_bar_bigdata' style='height:350px;'></div>
                  </div>
                </div>
              </div>
              <div class='col-md-6 col-sm-6 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_titlelinebigdata - $l_preview<small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>
                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bd</span>
                      <div class='count'>$bigdata_o[0]</div>
                      <span class='count_bottom'><i class='$bigdata_o[1]'><i class='$bigdata_o[2]'></i>$bigdata_o[3] </i></span>
                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bd_in</span>
                      <div class='count'>$bigdata_in_o[0]</div>
                      <span class='count_bottom'><i class='$bigdata_in_o[1]'><i class='$bigdata_in_o[2]'></i>$bigdata_in_o[3] </i></span>
                    </div>
                    <div class='col-md-4 col-xs-12'>
                      <div id='bigdata_o' style='width:50%; height:150px;'></div>
                    </div>
                  </div>
                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bdvisits_in</span>
                      <div class='count'>$bigdatavisits_in_o[0]</div>
                      <span class='count_bottom'><i class='$bigdatavisits_in_o[1]'><i class='$bigdatavisits_in_o[2]'></i>$bigdatavisits_in_o[3] </i></span>
                    </div>
                    <div class='col-md-4 col-xs-12'>
                      <div id='bigdatavisits_o' style='width:50%; height:150px;'></div>
                    </div>
                  </div>  
                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_qualifiedavgtime</span>
                      <div class='count'>".time2str($totaltimevisits_o)."</div>
                    </div>
                  </div>
                  <div class='x_content'>
                    <div id='echart_bar_bigdata_o' style='height:350px;'></div>
                  </div>
                </div>
              </div>";
            } else {
              echo "<div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_titlelinebigdata <small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>
                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bd</span>
                      <div class='count'>$bigdata[0]</div>
                      <span class='count_bottom'><i class='$bigdata[1]'><i class='$bigdata[2]'></i>$bigdata[3] </i></span>
                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bd_in</span>
                      <div class='count'>$bigdata_in[0]</div>
                      <span class='count_bottom'><i class='$bigdata_in[1]'><i class='$bigdata_in[2]'></i>$bigdata_in[3] </i></span>
                    </div>
                    <div class='col-md-4 col-xs-12'>
                      <div id='bigdata' style='width:50%; height:150px;'></div>
                    </div>
                  </div>
                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors_bdvisits_in</span>
                      <div class='count'>$bigdatavisits_in[0]</div>
                      <span class='count_bottom'><i class='$bigdatavisits_in[1]'><i class='$bigdatavisits_in[2]'></i>$bigdatavisits_in[3] </i></span>
                    </div>
                    <div class='col-md-4 col-xs-12'>
                      <div id='bigdatavisits' style='width:50%; height:150px;'></div>
                    </div>
                  </div>  
                  <div class='row tile_count'>
                    <div class='col-md-3 col-sm-6 col-xs-9 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_qualifiedavgtime</span>
                      <div class='count'>".time2str($totaltimevisits)."</div>
                    </div>
                  </div>
                  <div class='x_content'>
                    <div id='echart_bar_bigdata' style='height:350px;'></div>
                  </div>
                </div>
              </div>";
            }                 
            echo "</div>           
            <div class='row'>";
                        
            if ($show_range == 1) {
              echo "<div class='col-md-6 col-sm-6 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_visits - $l_actual <small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>

                  <div class='row tile_count'>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors</span>
                      <div class='count'>$visits[0]</div>
                      <span class='count_bottom'><i class='$visits[1]'><i class='$visits[2]'></i>$visits[3] </i></span>
                    </div>
                  </div>
                  <div class='row tile_count'>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-bar-chart'></i> $l_total_acct</span>
                      <div class='count'>$totalacct[0]</div>
                      <span class='count_bottom'><i class='$totalacct[1]'><i class='$totalacct[2]'></i>$totalacct[3] </i></span>
                    </div>
                    <!-- pie chart -->
                    <div class='col-md-4 col-xs-12'>
                      <div id='graph_status' style='width:50%; height:150px;'></div>
                    </div>
                    <!-- /Pie chart -->
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-download'></i> $l_in</span>
                      <div class='count'>$in[0]</div>
                      <span class='count_bottom'><i class='$in[1]'><i class='$in[2]'></i>$in[3] </i></span>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-minus'></i> $l_limit</span>
                      <div class='count'>$limit[0]</div>
                      <span class='count_bottom'><i class='$limit[1]'><i class='$limit[2]'></i>$limit[3] </i></span>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-upload'></i> $l_out</span>
                      <div class='count'>$out[0]</div>
                      <span class='count_bottom'><i class='$out[1]'><i class='$out[2]'></i>$out[3] </i></span>
                    </div>
                  </div>
                </div>  
              </div>
              <div class='col-md-6 col-sm-6 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_visits - $l_preview<small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>

                  <div class='row tile_count'>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors</span>
                      <div class='count'>$visits_o[0]</div>
                      <span class='count_bottom'><i class='$visits_o[1]'><i class='$visits_o[2]'></i>$visits_o[3] </i></span>
                    </div>
                  </div>
                  <div class='row tile_count'>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-bar-chart'></i> $l_total_acct</span>
                      <div class='count'>$totalacct_o[0]</div>
                      <span class='count_bottom'><i class='$totalacct_o[1]'><i class='$totalacct_o[2]'></i>$totalacct_o[3] </i></span>
                    </div>
                    <!-- pie chart -->
                    <div class='col-md-4 col-xs-12'>
                      <div id='graph_status_o' style='width:50%; height:150px;'></div>
                    </div>
                    <!-- /Pie chart -->
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-download'></i> $l_in</span>
                      <div class='count'>$in_o[0]</div>
                      <span class='count_bottom'><i class='$in_o[1]'><i class='$in_o[2]'></i>$in_o[3] </i></span>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-minus'></i> $l_limit</span>
                      <div class='count'>$limit_o[0]</div>
                      <span class='count_bottom'><i class='$limit_o[1]'><i class='$limit_o[2]'></i>$limit_o[3] </i></span>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-upload'></i> $l_out</span>
                      <div class='count'>$out_o[0]</div>
                      <span class='count_bottom'><i class='$out_o[1]'><i class='$out_o[2]'></i>$out_o[3] </i></span>
                    </div>
                  </div>
                </div>  
              </div>";       
            } else {
              echo "<div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_visits <small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>

                  <div class='row tile_count'>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-users'></i> $l_visitors</span>
                      <div class='count'>$visits[0]</div>
                      <span class='count_bottom'><i class='$visits[1]'><i class='$visits[2]'></i>$visits[3] </i></span>
                    </div>
                  </div>
                  <div class='row tile_count'>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-bar-chart'></i> $l_total_acct</span>
                      <div class='count'>$totalacct[0]</div>
                      <span class='count_bottom'><i class='$totalacct[1]'><i class='$totalacct[2]'></i>$totalacct[3] </i></span>
                    </div>
                    <!-- pie chart -->
                    <div class='col-md-4 col-xs-12'>
                      <div id='graph_status' style='width:50%; height:150px;'></div>
                    </div>
                    <!-- /Pie chart -->
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-download'></i> $l_in</span>
                      <div class='count'>$in[0]</div>
                      <span class='count_bottom'><i class='$in[1]'><i class='$in[2]'></i>$in[3] </i></span>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-minus'></i> $l_limit</span>
                      <div class='count'>$limit[0]</div>
                      <span class='count_bottom'><i class='$limit[1]'><i class='$limit[2]'></i>$limit[3] </i></span>
                    </div>
                    <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>
                      <span class='count_top'><i class='fa fa-upload'></i> $l_out</span>
                      <div class='count'>$out[0]</div>
                      <span class='count_bottom'><i class='$out[1]'><i class='$out[2]'></i>$out[3] </i></span>
                    </div>
                  </div>
                </div>  
              </div>";       
            }
            echo "</div>            
            <div class='row'>";

            if ($show_range == 1) {
              echo "<div class='col-md-6 col-sm-6 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_titlelineactivity <small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>
                    <div id='echart_activity' style='height:350px;'></div>                  
                  </div>
                </div>
              </div>
              <div class='col-md-6 col-sm-6 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_titlelineactivity <small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>
                    <div id='echart_activity_o' style='height:350px;'></div>                
                  </div>
                </div>
              </div>";
            } else {
              echo "<div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_titlelineactivity <small></small></h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>
                    <div id='echart_activity' style='height:350px;'></div>                 
                  </div>
                </div>
              </div>";
            }                 
            echo "</div>

            <div class='row'>
              <div class='col-md-12 col-sm-12 col-xs-12'>
                <div class='x_panel'>
                  <div class='x_title'>
                    <h2>$l_devices</h2>
                    <ul class='nav navbar-right panel_toolbox'>
                      <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a></li>
                    </ul>
                    <div class='clearfix'></div>
                  </div>
                  <div class='x_content'>
                    <table class='' style='width:100%'>
                      <tr>
                        <th style='width:37%;'>
                          <p>$l_top</p>
                        </th>
                        <th>
                          <div class='col-lg-7 col-md-7 col-sm-7 col-xs-7'>
                            <p class=''>$l_device</p>
                          </div>
                          <div class='col-lg-5 col-md-5 col-sm-5 col-xs-5'>
                            <p class='' align='center'>$l_progress</p>
                          </div>
                        </th>
                      </tr>
                      <tr>
                        <td>
                          <canvas id='devices' height='200' width='200' style='margin: 10px 10px 10px 10px'></canvas>
                        </td>
                        <td>
                          <table class='tile_info'>";

                            $count=0;
                            $totalother = 0;

                            usort($a_device, build_sorter('total'));
                            foreach ($a_device as $item) {

                              if ($count <= 8) {

                                $totalpercentdevice = ROUND(($item['total']/$totalacctdevice)*100,2);
                                $percent[$count] = $totalpercentdevice;
                                $val[$count] = $item['vendor'];
                                echo "<tr>
                                        <td><p><i class='fa fa-mobile'></i>".$item['vendor']."</p></td>
                                        <td>$totalpercentdevice%</td>
                                     </tr>
                                   </tr>";
                                $count = $count + 1;
                                     
                              } else {
                                    
                                $totalother = $totalother + $item['total'];
                              }
                            }

                            if ($totalother > 0) {
                              $totalpercentdevice = ROUND(($totalother/$totalacctdevice)*100,2);
                              $percent[9] = $totalpercentdevice;
                              $val[9] = $l_others;
                              echo "<tr>
                                      <td><p><i class='fa fa-mobile'></i>$l_others </p></td>
                                      <td>$totalpercentdevice%</td>
                                    <tr>
                                  </tr>";
                            }
                            
                      echo "</table>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>  
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class='pull-right'>
            $l_footer2 
          </div>
          <div class='clearfix'></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src='../vendors/jquery/dist/jquery.min.js'></script>
    <!-- Bootstrap -->
    <script src='../vendors/bootstrap/dist/js/bootstrap.min.js'></script>
    <!-- FastClick -->
    <script src='../vendors/fastclick/lib/fastclick.js'></script>
    <!-- NProgress -->
    <script src='../vendors/nprogress/nprogress.js'></script>
    <!-- Chart.js -->
    <script src='../vendors/Chart.js/dist/Chart.min.js'></script>
    <!-- bootstrap-progressbar -->
    <script src='../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'></script>
    <!-- iCheck -->
    <script src='../vendors/iCheck/icheck.min.js'></script>
    <!-- DateJS -->
    <script src='../vendors/DateJS/build/date.js'></script>
    <!-- bootstrap-daterangepicker -->
    <script src='js/moment/moment.min.js'></script>
    <script src='js/datepicker/daterangepicker.js'></script>
    <!-- morris.js -->
    <script src='../vendors/raphael/raphael.min.js'></script>
    <script src='../vendors/morris.js/morris.min.js'></script>
    <!-- gauge.js -->
    <script src='../vendors/gauge.js/dist/gauge.min.js'></script>
    <!-- ECharts -->
    <script src='../vendors/echarts/dist/echarts.min.js'></script>

    <!-- Custom Theme Scripts -->
    <script src='../build/js/custom.min.js'></script>

    <!-- Doughnut Chart -->
    <script>
      $(document).ready(function(){
        var options = {
          legend: false,
          responsive: false
        };

        new Chart(document.getElementById('devices'), {
        type: 'doughnut',
        tooltipFillColor: 'rgba(51, 51, 51, 0.55)',
          data: {
            labels: [
              '$val[0]',
              '$val[1]',
              '$val[2]',
              '$val[3]',
              '$val[4]',
              '$val[5]',
              '$val[6]',
              '$val[7]',
              '$val[8]',
              '$val[9]',
            ],
            datasets: [{
              data: [$percent[0], $percent[1], $percent[2], $percent[3], $percent[4], $percent[5], $percent[6], $percent[7], $percent[8], $percent[9]],
              backgroundColor: [
                '#3498DB',
                '#1ABB9C',
                '#9B59B6',
                '#9CC2CB',
                '#34495E',
                '#E74C3C',
                '#26B99A',
                '#8abb6f',
                '#BDC3C7',
                '#759c6a'
              ],
              hoverBackgroundColor: [
                '#3498DB',
                '#1ABB9C',
                '#9B59B6',
                '#9CC2CB',
                '#34495E',
                '#E74C3C',
                '#26B99A',
                '#8abb6f',
                '#BDC3C7',
                '#759c6a'
              ]
            }]
          },
          options: options
        });
      });
    </script>
    <!-- /Doughnut Chart -->
    
    <!-- theme -->
    <script>
      var theme = {
          color: [
            '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
            '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
          ],

          title: {
            itemGap: 8,
            textStyle: {
              fontWeight: 'normal',
              color: '#408829'
            }
          },

          dataRange: {
            color: ['#1f610a', '#97b58d']
          },

          toolbox: {
            color: ['#408829', '#408829', '#408829', '#408829']
          },

          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.5)',
            axisPointer: {
              type: 'line',
              lineStyle: {
                color: '#408829',
                type: 'dashed'
              },
              crossStyle: {
                color: '#408829'
              },
              shadowStyle: {
                color: 'rgba(200,200,200,0.3)'
              }
            }
          },

          dataZoom: {
            dataBackgroundColor: '#eee',
            fillerColor: 'rgba(64,136,41,0.2)',
            handleColor: '#408829'
          },
          grid: {
            borderWidth: 0
          },

          categoryAxis: {
            axisLine: {
              lineStyle: {
                color: '#408829'
              }
            },
            splitLine: {
              lineStyle: {
                color: ['#eee']
              }
            }
          },

          valueAxis: {
            axisLine: {
              lineStyle: {
                color: '#408829'
              }
            },
            splitArea: {
              show: true,
              areaStyle: {
                color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
              }
            },
            splitLine: {
              lineStyle: {
                color: ['#eee']
              }
            }
          },
          timeline: {
            lineStyle: {
              color: '#408829'
            },
            controlStyle: {
              normal: {color: '#408829'},
              emphasis: {color: '#408829'}
            }
          },

          k: {
            itemStyle: {
              normal: {
                color: '#68a54a',
                color0: '#a9cba2',
                lineStyle: {
                  width: 1,
                  color: '#408829',
                  color0: '#86b379'
                }
              }
            }
          },
          map: {
            itemStyle: {
              normal: {
                areaStyle: {
                  color: '#ddd'
                },
                label: {
                  textStyle: {
                    color: '#c12e34'
                  }
                }
              },
              emphasis: {
                areaStyle: {
                  color: '#99d2dd'
                },
                label: {
                  textStyle: {
                    color: '#c12e34'
                  }
                }
              }
            }
          },
          force: {
            itemStyle: {
              normal: {
                linkStyle: {
                  strokeColor: '#408829'
                }
              }
            }
          },
          chord: {
            padding: 4,
            itemStyle: {
              normal: {
                lineStyle: {
                  width: 1,
                  color: 'rgba(128, 128, 128, 0.5)'
                },
                chordStyle: {
                  lineStyle: {
                    width: 1,
                    color: 'rgba(128, 128, 128, 0.5)'
                  }
                }
              },
              emphasis: {
                lineStyle: {
                  width: 1,
                  color: 'rgba(128, 128, 128, 0.5)'
                },
                chordStyle: {
                  lineStyle: {
                    width: 1,
                    color: 'rgba(128, 128, 128, 0.5)'
                  }
                }
              }
            }
          },
          gauge: {
            startAngle: 225,
            endAngle: -45,
            axisLine: {
              show: true,
              lineStyle: {
                color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                width: 8
              }
            },
            axisTick: {
              splitNumber: 10,
              length: 12,
              lineStyle: {
                color: 'auto'
              }
            },
            axisLabel: {
              textStyle: {
                color: 'auto'
              }
            },
            splitLine: {
              length: 18,
              lineStyle: {
                color: 'auto'
            }
          },
          pointer: {
            length: '90%',
            color: 'auto'
          },
          title: {
            textStyle: {
              color: '#333'
            }
          },
          detail: {
            textStyle: {
              color: 'auto'
            }
          }
        },
        textStyle: {
          fontFamily: 'Arial, Verdana, sans-serif'
        }
      };
      <!-- theme -->
      <!-- Echart Line -->

        <!-- Bar Big Data -->
        var echartBar_bd = echarts.init(document.getElementById('echart_bar_bigdata'), theme);

        echartBar_bd.setOption({
          title: {
            text: '$l_actual',
            subtext: '$datestart - $dateend'
          },
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            x: 100,
            data: ['$l_visitors_bd_in', '$l_visitors_bd']
          },
          toolbox: {
            show: true,
            feature: {
              saveAsImage: {
                show: true,
                title: 'Save Image'
              }
            }
          },
          calculable: true,
          xAxis: [{
            type: 'value',
            boundaryGap: [0, 1]
          }],
          yAxis: [{
            type: 'category',
            data: ['# Macs']
          }],
          series: [{
            name: '$l_visitors_bd_in',
            type: 'bar',
            data: [$totalbigdata_in]
          }, {
            name: '$l_visitors_bd',
            type: 'bar',
            data: [$totalbigdata]
          }]
        });

        <!-- Line Graph Activity -->

        var echartLine_act = echarts.init(document.getElementById('echart_activity'), theme);

        echartLine_act.setOption({
          title: {
            text: '$l_actual',
            subtext: '$datestart - $dateend'
          },
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            x: 220,
            y: 40,
            data: ['$l_in', '$l_limit', '$l_out']
          },
          toolbox: {
            show: true,
            feature: {
              magicType: {
                show: true,
                title: {
                  line: 'Line',
                  bar: 'Bar',
                  stack: 'Stack',
                  tiled: 'Tiled'
                },
                type: ['line', 'bar', 'stack', 'tiled']
              },
              restore: {
                show: true,
                title: 'Restore'
              },
              saveAsImage: {
                show: true,
                title: 'Save Image'
              }
            }
          },
          calculable: true,
          xAxis: [{
            type: 'category',
            boundaryGap: false,
            data: ['$l_Mo', '$l_Tu', '$l_We', '$l_Th', '$l_Fr', '$l_Sa', '$l_Su']
          }],
          yAxis: [{
            type: 'value'
          }],
          series: [{
            name: '$l_out',
            type: 'line',
            smooth: true,
            itemStyle: {
              normal: {
                areaStyle: {
                  type: 'default'
                }
              }
            },
            data: [$tot_out[2], $tot_out[3], $tot_out[4], $tot_out[5], $tot_out[6], $tot_out[7], $tot_out[1]]
          }, {
            name: '$l_limit',
            type: 'line',
            smooth: true,
            itemStyle: {
              normal: {
                areaStyle: {
                  type: 'default'
                }
              }
            },
            data: [$tot_limit[2], $tot_limit[3], $tot_limit[4], $tot_limit[5], $tot_limit[6], $tot_limit[7], $tot_limit[1]]
          }, {
            name: '$l_in',
            type: 'line',
            smooth: true,
            itemStyle: {
              normal: {
                areaStyle: {
                  type: 'default'
                }
              }
            },
            data: [$tot_in[2], $tot_in[3], $tot_in[4], $tot_in[5], $tot_in[6], $tot_in[7], $tot_in[1]]
          }]
        });
        
        <!-- Bar Big Data Anterior -->
        var echartBar_bd_o = echarts.init(document.getElementById('echart_bar_bigdata_o'), theme);

        echartBar_bd_o.setOption({
          title: {
            text: '$l_preview',
            subtext: '$datestart2 - $dateend2'
          },
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            x: 100,
            data: ['$l_visitors_bd_in', '$l_visitors_bd']
          },
          toolbox: {
            show: true,
            feature: {
              saveAsImage: {
                show: true,
                title: 'Save Image'
              }
            }
          },
          calculable: true,
          xAxis: [{
            type: 'value',
            boundaryGap: [0, 1]
          }],
          yAxis: [{
            type: 'category',
            data: ['# Macs']
          }],
          series: [{
            name: '$l_visitors_bd_in',
            type: 'bar',
            data: [$totalbigdata_in_o]
          }, {
            name: '$l_visitors_bd',
            type: 'bar',
            data: [$totalbigdata_o]
          }]
        });

        <!-- Line Graph Activity Anterior -->

        var echartLine_act_o = echarts.init(document.getElementById('echart_activity_o'), theme);

        echartLine_act_o.setOption({
          title: {
            text: '$l_preview',
            subtext: '$datestart2 - $dateend2'
          },
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            x: 220,
            y: 40,
            data: ['$l_in', '$l_limit', '$l_out']
          },
          toolbox: {
            show: true,
            feature: {
              magicType: {
                show: true,
                title: {
                  line: 'Line',
                  bar: 'Bar',
                  stack: 'Stack',
                  tiled: 'Tiled'
                },
                type: ['line', 'bar', 'stack', 'tiled']
              },
              restore: {
                show: true,
                title: 'Restore'
              },
              saveAsImage: {
                show: true,
                title: 'Save Image'
              }
            }
          },
          calculable: true,
          xAxis: [{
            type: 'category',
            boundaryGap: false,
            data: ['$l_Mo', '$l_Tu', '$l_We', '$l_Th', '$l_Fr', '$l_Sa', '$l_Su']
          }],
          yAxis: [{
            type: 'value'
          }],
          series: [{
            name: '$l_out',
            type: 'line',
            smooth: true,
            itemStyle: {
              normal: {
                areaStyle: {
                  type: 'default'
                }
              }
            },
            data: [$tot_out_o[2], $tot_out_o[3], $tot_out_o[4], $tot_out_o[5], $tot_out_o[6], $tot_out_o[7], $tot_out_o[1]]
          }, {
            name: '$l_limit',
            type: 'line',
            smooth: true,
            itemStyle: {
              normal: {
                areaStyle: {
                  type: 'default'
                }
              }
            },
            data: [$tot_limit_o[2], $tot_limit_o[3], $tot_limit_o[4], $tot_limit_o[5], $tot_limit_o[6], $tot_limit_o[7], $tot_limit_o[1]]
          }, {
            name: '$l_in',
            type: 'line',
            smooth: true,
            itemStyle: {
              normal: {
                areaStyle: {
                  type: 'default'
                }
              }
            },
            data: [$tot_in_o[2], $tot_in_o[3], $tot_in_o[4], $tot_in_o[5], $tot_in_o[6], $tot_in_o[7], $tot_in_o[1]]
          }]
        });

      <!-- Echart Line -->		
    </script>
        
    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {

        var datestart;
        var dateend;
        var datestart2;
        var dateend2;

        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('$l_dateformat') + ' - ' + end.format('$l_dateformat'));
          datestart = start.format('YYYY-MM-DD');
          dateend = end.format('YYYY-MM-DD');
          $('#datestart').val(datestart);
          $('#dateend').val(dateend);
        };

        var cb2 = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange2 span').html(start.format('$l_dateformat') + ' - ' + end.format('$l_dateformat'));
          datestart2 = start.format('YYYY-MM-DD');
          dateend2 = end.format('YYYY-MM-DD');
          $('#datestart2').val(datestart2);
          $('#dateend2').val(dateend2);

        };

        var optionSet1 = {
          startDate: moment(),
          endDate: moment(),
          minDate: '01/01/1900',
          maxDate: '12/31/2050',
          dateLimit: {
            days: 365
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: false,
          ranges: {
            '$l_Today': [moment(), moment()],
            '$l_Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '$l_This_Month': [moment().startOf('month'), moment().endOf('month')],
            '$l_Last_Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'right',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: '$l_Submit',
            cancelLabel: '$l_Clear',
            fromLabel: '$l_From',
            toLabel: '$l_To',
            customRangeLabel: '$l_Custom',
            daysOfWeek: ['$l_Su', '$l_Mo', '$l_Tu', '$l_We', '$l_Th', '$l_Fr', '$l_Sa'],
            monthNames: ['$l_January', '$l_February', '$l_March', '$l_April', '$l_May', '$l_June', '$l_July', '$l_August', '$l_September', '$l_October', '$l_November', '$l_December'],
            firstDay: 1
          }
        };

        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log('show event fired');
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log('hide event fired');
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log('apply event fired, start/end dates are ' + picker.startDate.format('$l_dateformat') + ' to ' + picker.endDate.format('$l_dateformat'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log('cancel event fired');
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });

        $('#reportrange2').daterangepicker(optionSet1, cb2);
        $('#reportrange2').on('show.daterangepicker', function() {
          console.log('show event fired');
        });
        $('#reportrange2').on('hide.daterangepicker', function() {
          console.log('hide event fired');
        });
        $('#reportrange2').on('apply.daterangepicker', function(ev, picker) {
          console.log('apply event fired, start/end dates are ' + picker.startDate.format('$l_dateformat') + ' to ' + picker.endDate.format('$l_dateformat'));
        });
        $('#reportrange2').on('cancel.daterangepicker', function(ev, picker) {
          console.log('cancel event fired');
        });
        $('#options1').click(function() {
          $('#reportrange2').data('daterangepicker').setOptions(optionSet1, cb2);
        });
        $('#options2').click(function() {
          $('#reportrange2').data('daterangepicker').setOptions(optionSet2, cb2);
        });
        $('#destroy').click(function() {
          $('#reportrange2').data('daterangepicker').remove();
        });

      });
    </script>
    <!-- /bootstrap-daterangepicker -->

    <!-- morris.js -->
    <script>
      $(document).ready(function() {
        Morris.Donut({
          element: 'graph_status',
          data: [
            {label: '$l_in', value: $gdin},
            {label: '$l_limit', value: $gdlimit},
            {label: '$l_out', value: $gdout},
          ],
          colors: ['#26B99A', '#34495E', '#ACADAC'],
          formatter: function (y) {
            return y + '%';
          },
          resize: true
        });
      });

    </script>
    <!-- /morris.js -->

    <!-- morris.js -->
    <script>
      $(document).ready(function() {
        Morris.Donut({
          element: 'bigdata',
          data: [
            {label: '$l_in', value: $gdbigdata},
          ],
          colors: ['#26B99A'],
          formatter: function (y) {
            return y + '%';
          },
          resize: true
        });
      });

    </script>
    <!-- /morris.js -->

    <!-- morris.js -->
    <script>
      $(document).ready(function() {
        Morris.Donut({
          element: 'bigdatavisits',
          data: [
            {label: '$l_in', value: $gdbigdatavisits},
          ],
          colors: ['#34495E'],
          formatter: function (y) {
            return y + '%';
          },
          resize: true
        });
      });

    </script>
    <!-- /morris.js -->

    <!-- morris.js -->
    <script>
      $(document).ready(function() {
        Morris.Donut({
          element: 'graph_status_o',
          data: [
            {label: '$l_in', value: $gdin_o},
            {label: '$l_limit', value: $gdlimit_o},
            {label: '$l_out', value: $gdout_o},
          ],
          colors: ['#26B99A', '#34495E', '#ACADAC'],
          formatter: function (y) {
            return y + '%';
          },
          resize: true
        });
      });

    </script>
    <!-- /morris.js -->

    <!-- morris.js -->
    <script>
      $(document).ready(function() {
        Morris.Donut({
          element: 'bigdata_o',
          data: [
            {label: '$l_in', value: $gdbigdata_o},
          ],
          colors: ['#26B99A'],
          formatter: function (y) {
            return y + '%';
          },
          resize: true
        });
      });

    </script>
    <!-- /morris.js -->

    <!-- morris.js -->
    <script>
      $(document).ready(function() {
        Morris.Donut({
          element: 'bigdatavisits_o',
          data: [
            {label: '$l_in', value: $gdbigdatavisits_o},
          ],
          colors: ['#34495E'],
          formatter: function (y) {
            return y + '%';
          },
          resize: true
        });
      });

    </script>
    <!-- /morris.js -->


  </body>
</html>
";

?>
