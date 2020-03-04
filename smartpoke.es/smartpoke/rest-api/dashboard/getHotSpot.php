<?php
// ini_set('display_errors','On');
// error_reporting(E_ALL);

	include ('../../library/checklogin.php');
	include('../../library/pages_common.php');
	
	$lang = $_SESSION['lang'];
	
	if ($lang == 'es') include('../../lang/es.php');
	else include('../../lang/en.php');

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
	
  if (isset($_POST['radio_chkgraph'])) 
    $radio_chkgraph = $_POST['radio_chkgraph'];
	elseif (isset($_GET['radio_chkgraph']))
    $radio_chkgraph = $_GET['radio_chkgraph'];
	
  $totalusers = 0;
  $totalnewusers = 0;
  $totalonline = 0;
  $totalhits = 0;
  $totalnologged = 0;

  $bdbwtotal = "0";
  $bdbwupload = "0";
  $bdbwdownload = "0";
  $btbwtotal = "0";

	$arr_busydayuser = array(); // Busy Day User
	$arr_busydayhotspot = array(); // Busy Day Hotspot
	$arr_busydaytime = array(); // Busy Day Time
	$arr_maxusedday = array(); // Max Used Day
	$arr_maxusedtime = array(); // Max Used Time
	
	$arr_bandwidth = array(); // Bandwidth
	$arr_usershits = array(); // User & Connections
	$arr_timeconnect = array(); // Time Connections

  $arr_hotspot = array(); // HotSpot Array
		
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

  $where_newusers = "(DATE(ui.creationdate) BETWEEN '$datestart' AND '$dateend') AND ";
  $where_online = "(DATE(ra.acctstarttime) BETWEEN '$datestart' AND '$dateend') AND (ra.acctstoptime IS NULL OR cast(ra.acctstoptime as character varying) = '0000-00-00 00:00:00') AND ";
  $where_hits = "(DATE(ra.acctstarttime) BETWEEN '$datestart' AND '$dateend') AND (ra.acctstoptime IS NOT NULL) AND ";
  $where_days = "(DATE(ra.acctstarttime) BETWEEN '$datestart' AND '$dateend') AND ";

  include('../../library/opendb.php');

  #----------------- total users ----------------------
  $sql_totuser = "SELECT COUNT(username) AS users ".
                 "FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".	
									"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
									"WHERE operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".
												$where_state." ".$where_city." ".$where_location." ".$where_spot;
  $ret_totuser = pg_query($dbConnect, $sql_totuser);
  $row_totuser = pg_fetch_row($ret_totuser);
  $totalusers = $row_totuser[0];

  #----------------- total new users ----------------------
  $sql_newuser = "SELECT COUNT(username) AS users ".
								"FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ".
								"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
								"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
								"WHERE ".$where_newusers." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot;
  $ret_newuser = pg_query($dbConnect, $sql_newuser);
  $row_newuser = pg_fetch_row($ret_newuser);
  $totalnewusers = $row_newuser[0];

  #----------------- total online ----------------------
  $sql_online = "SELECT COUNT(ra.username) ".
                "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
                "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
                "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
							"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
                "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
                "WHERE ".$where_online." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
							"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)";
  $ret_online = pg_query($dbConnect, $sql_online);
  $row_online = pg_fetch_row($ret_online);
  $totalonline = $row_online[0];

  #----------------- total hits ----------------------
  $sql_hits = "SELECT COUNT(DISTINCT(ra.username)) ".
				    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
						"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
				    "WHERE ".$where_hits." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
						"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2)";
  $ret_hits = pg_query($dbConnect, $sql_hits);
  $row_hits = pg_fetch_row($ret_hits);
  $totalhits = $row_hits[0];

  #----------------- total nologged ----------------------
  $sql_nologged = "SELECT COUNT(username) AS users ".
								"FROM ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ".
								"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
								"JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
								"WHERE username NOT IN (SELECT username FROM ".$esquema.".".$configValues['TBL_RADACCT'].") AND operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot;

  $ret_nologged = pg_query($dbConnect, $sql_nologged);
  $row_nologged = pg_fetch_row($ret_nologged);
  $totalnologged = $row_nologged[0];

  #---------------- Busy Day Users -------------------------
  $sql_bdayusers = "SELECT DATE_PART('isodow', ra.acctstarttime) AS day ".
							    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
							    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
							    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
							    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
							    "WHERE ".$where_days." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
									"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
									"GROUP BY day, ra.username ".
										"ORDER BY day";
  $ret_bdayusers = pg_query($dbConnect, $sql_bdayusers);

  while ($row_bdayusers = pg_fetch_row($ret_bdayusers)) {
    $day = $row_bdayusers[0];
    $cant = 1;
		$arr_busydayuser[] = array("day" => $day, "total" => $cant);
  }

	#-------------------------- Busy Day HotSpot ---------------------
	$sql_bdayhs = "SELECT DATE_PART('isodow', ra.acctstarttime) AS day, COUNT(ra.username) as total ".
					    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
					    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
					    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
							"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
					    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
					    "WHERE ".$where_days." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
							"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
	              "GROUP BY day ".
	              "ORDER BY day";
	
	$ret_bdayhs = pg_query($dbConnect, $sql_bdayhs);

  while ($row_bdayhs = pg_fetch_row($ret_bdayhs)) {
    $day = $row_bdayhs[0];
    $cant = $row_bdayhs[1];
		$arr_busydayhotspot[] = array("day" => $day, "total" => $cant);
  }

	#--------------------------- Busy Day Time --------------------------
	$sql_bdaytime = "SELECT DATE_PART('isodow', ra.acctstarttime) AS day, DATE_PART('hour', ra.acctstarttime) AS hour, COUNT(ra.username) as total ".
						    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
								"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
						    "WHERE ".$where_days." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
								"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
	                "GROUP BY day, hour ".
	                "ORDER BY hour";
	$ret_bdaytime = pg_query($dbConnect, $sql_bdaytime);

  while ($row_bdaytime = pg_fetch_row($ret_bdaytime)) {
    $day = $row_bdaytime[0];
		$hour = $row_bdaytime[1];
    $cant = $row_bdaytime[2];
		$arr_busydaytime[] = array("day" => $day, "hour" => $hour, "total" => $cant);
  }

	#------------------------- Max Used Day --------------------------------------
	$sql_used = "SELECT DATE_PART('isodow', ra.acctstarttime) AS day, SUM(ra.acctinputoctets) AS upload, SUM(ra.acctoutputoctets) AS download, SUM(ra.acctinputoctets+ra.acctoutputoctets) as total ".
				    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
						"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
				    "WHERE ".$where_days." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
						"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
	            "GROUP BY day ".
	            "ORDER BY total DESC ".
	            "LIMIT 1";
	$ret_used = pg_query($dbConnect, $sql_used);
	$row_used = pg_fetch_assoc($ret_used);

	$day_mud = $row_used['day'];
	$bdbwtotal = $row_used['total'];
	$bdbwupload = $row_used['upload'];
	$bdbwdownload = $row_used['download'];
	
	$arr_maxusedday[] = array("day" => $l_weekday[$day_mud], "bandwidth" => toxbyte($bdbwtotal), "bwupload" => toxbyte($bdbwupload), "bwdownload" => toxbyte($bdbwdownload));

	#------------------------- Max Used Time --------------------------------------
	$sql_usedtime = "SELECT DATE_PART('isodow', ra.acctstarttime) AS day, DATE_PART('hour', ra.acctstarttime) AS hour, SUM(ra.acctinputoctets+ra.acctoutputoctets) as total ".
						    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
								"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
						    "WHERE ".$where_days." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
								"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
	                "GROUP BY day, hour ".
	                "ORDER BY total DESC ".
	                "LIMIT 1";
	$ret_usedtime = pg_query($dbConnect, $sql_usedtime);
	$row_usedtime = pg_fetch_assoc($ret_usedtime);

	$day_mut = $row_usedtime['day'];
	$houri = IS_NULL($row_usedtime['hour']) ? "" : $row_usedtime['hour'].":00";
	$houre = IS_NULL($row_usedtime['hour']) ? "" : $row_usedtime['hour'].":59";
	$btbwtotal = $row_usedtime['total'];

	if (IS_NULL($btbwtotal)) {
	  $btbwtotal = "0";
	}

	$arr_maxusedtime[] = array("day" => $l_weekday[$day_mut], "hour" => $houri.'-'.$houre, "total" => toxbyte($btbwtotal));

	switch ($radio_chkgraph) {
		case '1':
			$graph_type = "date_part('day', ra.acctstarttime) AS day_part, ";
			break;
		case '2':
			$graph_type = "date_part('isodow', ra.acctstarttime) AS day_part, ";
			break;
		case '3':
			$graph_type = "date_part('week', ra.acctstarttime) AS day_part, ";
			break;
		case '4':
			$graph_type = "date_part('month', ra.acctstarttime) AS day_part, ";
			break;
		case '5':
			$graph_type = "date_part('year', ra.acctstarttime) AS day_part, ";
			break;
	}

	#----------------- echart_bandwidth ----------------------
	$sql_bandwidth = "SELECT ".$graph_type."SUM(ra.acctinputoctets) AS upload, SUM(ra.acctoutputoctets) AS download, SUM(ra.acctinputoctets+ra.acctoutputoctets) AS total ".
							    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
							    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
							    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
									"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
							    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
							    "WHERE ".$where_days." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
									"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
                  "GROUP BY day_part ".
									"ORDER BY day_part";
	$ret_bandwidth = pg_query($dbConnect, $sql_bandwidth);

	while ($row_bandwidth = pg_fetch_row($ret_bandwidth)) {
	  $day = $row_bandwidth[0];
	  $tot_lg_up = $row_bandwidth[1];
	  $tot_lg_down = $row_bandwidth[2];
	  $tot_lg_bw = $row_bandwidth[3];
	  $tot_lg_upload = ROUND(($tot_lg_up/1073741824),2);
	  $tot_lg_download = ROUND(($tot_lg_down/1073741824),2);
	  $tot_lg_bandwidth = ROUND(($tot_lg_bw/1073741824),2);
		$arr_bandwidth[] = array("day_part" => $day, "bandwidth" => $tot_lg_bandwidth, "bwupload" => $tot_lg_upload, "bwdownload" => $tot_lg_download);
	}
	

	#---------------------------------- echart_users ----------------------Ω
	$sql_userlog = "SELECT ".$graph_type."1 as cant, COUNT(ra.username) as total ".	
						    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
								"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
						    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
						    "WHERE ".$where_days." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
								"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
               "GROUP BY day_part, ra.username ".
								"ORDER BY day_part";
	$ret_userlog = pg_query($dbConnect, $sql_userlog);
	
	while ($row_userlog = pg_fetch_row($ret_userlog)) {

	  $day = $row_userlog[0];
	  $tot_users = $row_userlog[1];
	  $tot_hits = $row_userlog[2];

		$arr_usershits[] = array("day_part" => $day, "cant" => $tot_users, "hits" => $tot_hits);
	}

	#-------------------------- echart_bar_timeconnect --------------------------------
	$sql_dist = "SELECT DATE_PART('day', ra.acctstarttime) as day, ra.username, SUM(ROUND(ra.acctsessiontime/60)) as min ".
				    "FROM ".$esquema.".".$configValues['TBL_RADACCT']." AS ra ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSHOTSPOTS']." AS hs ON mac = calledstationid ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSUSERINFO']." AS ui ON ui.username = ra.username ".
						"JOIN ".$esquema.".".$configValues['TBL_RWSPOT']." AS s ON s.spot_id = ui.spot_id ".
				    "JOIN ".$esquema.".".$configValues['TBL_RSSPOTOPERATORS']." AS sp ON sp.spot_id = s.spot_id ".
				    "WHERE ".$where_days." operator_id = '$operator_profile_id' AND access = 1 AND country_id = '$idcountry' ".$where_state." ".$where_city." ".$where_location." ".$where_spot." ".
						"AND callingstationid NOT IN (SELECT devicemac FROM ".$esquema.".".$configValues['TBL_RWDEVICES']." $where_spot_id2) ".
	            "GROUP BY day, ra.username ".
	            "ORDER BY min DESC";
	$ret_dist = pg_query($dbConnect, $sql_dist);

	while ($row_dist = pg_fetch_row($ret_dist)) {
	  $min = $row_dist[2];

	  switch($min) {
	    case ($min <= 5):
				$arr_timeconnect[] = array("pos" => '1', "cant" => 1);
	      break;
	    case (($min >= 6) && ($min <= 15)):
				$arr_timeconnect[] = array("pos" => '2', "cant" => 1);
	      break;
	    case (($min >= 16) && ($min <= 30)):
				$arr_timeconnect[] = array("pos" => '3', "cant" => 1);
	      break;
	    case (($min >= 31) && ($min <= 60)):
				$arr_timeconnect[] = array("pos" => '4', "cant" => 1);
	      break;
	    case (($min >= 61) && ($min <= 120)):
				$arr_timeconnect[] = array("pos" => '5', "cant" => 1);
	      break;
	    case ($min >= 121):
				$arr_timeconnect[] = array("pos" => '6', "cant" => 1);
	      break;
	  }
	}

  include('../../library/closedb.php');
	
	$arr_hotspot[] = array("section" => 'totalusers', "data" => $totalusers);
	$arr_hotspot[] = array("section" => 'totalnewusers', "data" => $totalnewusers);
	$arr_hotspot[] = array("section" => 'totalonline', "data" => $totalonline);
	$arr_hotspot[] = array("section" => 'totalhits', "data" => $totalhits);
	$arr_hotspot[] = array("section" => 'totalnologged', "data" => $totalnologged);
	$arr_hotspot[] = array("section" => 'busydayuser', "data" => $arr_busydayuser);
	$arr_hotspot[] = array("section" => 'busydayhotspot', "data" => $arr_busydayhotspot);
	$arr_hotspot[] = array("section" => 'busydaytime', "data" => $arr_busydaytime);
	$arr_hotspot[] = array("section" => 'maxusedday', "data" => $arr_maxusedday);
	$arr_hotspot[] = array("section" => 'maxusedtime', "data" => $arr_maxusedtime);
	$arr_hotspot[] = array("section" => 'bandwidth', "data" => $arr_bandwidth);
	$arr_hotspot[] = array("section" => 'usershits', "data" => $arr_usershits);
	$arr_hotspot[] = array("section" => 'timeconnect', "data" => $arr_timeconnect);

	echo json_encode($arr_hotspot);		
	
?>