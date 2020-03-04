<?php

	ini_set('display_errors','On');
	error_reporting(E_ALL);

	$dirfile = "/rocotowifi/PROD/files/*.csv";

	  function startdataprocess($file_x) {
		$files = glob($file_x);
		foreach($files as $file_name) {
			readfile_name($file_name);
		}
	  }

	  function readfile_name($file) {

		$handle = fopen($file, "r") or die("Couldn't get handle");

		$f =  substr($file, strlen($file)-20, 20);
		$c =  substr($f, 9, 7);
		if (substr($f, 15, 1) == 'i') $c =  substr($f, 9, 7)."t";

		include('library/opendb.php');
		$sql_esquema = "SELECT esquema ".
					  "FROM esmartit.rw_client ".
					  "WHERE client = '$c'";
	    $ret_esquema = pg_query($dbConnect, $sql_esquema);
		if(!$ret_esquema) {
	      echo "ERROR: ".pg_last_error($dbConnect)."</br>";
			exit;
		}
		if (pg_num_rows($ret_esquema) == 0) {
	      echo "ERROR: VERIFICAR CLIENTE / ESQUEMA </br>";
			exit;
		} else {
			$row = pg_fetch_assoc($ret_esquema);
			$esquema = $row['esquema'];
		}

		$num_row = 0;
		if ($handle) {
		  while (!feof($handle)) {
				$buffer = fgetcsv($handle, ",");

				$num_col = count($buffer);
				$sensorname = $buffer[2];

				if ($sensorname != '') {

					$sql_pwr_out = "SELECT pwr_out ".
								  "FROM $esquema.rw_sensor ".
								  "WHERE sensorname = '$sensorname'";
				  $ret_pwr_out = pg_query($dbConnect, $sql_pwr_out);
					$row_pwr_out = pg_fetch_assoc($ret_pwr_out);
					$pwr_out = $row_pwr_out['pwr_out'];

					$devicemac = $buffer[3];
					$devicehashmac = $buffer[5];
					$acctstartdate = $buffer[13];
					$acctstopdate = $buffer[14];
					$acctsessiontime = $buffer[15];
					$acctpower = $buffer[16];
					$acctdistance = $buffer[17];
					if ($num_col == 19) {
						$devicehashmac = $buffer[6];
						$acctstartdate = $buffer[14];
						$acctstopdate = $buffer[15];
						$acctsessiontime = $buffer[16];
						$acctpower = $buffer[17];
						$acctdistance = $buffer[18];
					}
					if ($num_col == 20) {
						$devicehashmac = $buffer[7];
						$acctstartdate = $buffer[15];
						$acctstopdate = $buffer[16];
						$acctsessiontime = $buffer[17];
						$acctpower = $buffer[18];
						$acctdistance = $buffer[19];
					}
				  $datestart = date('Y-m-d', strtotime($acctstartdate));
					$timestart = date('H:i:s', strtotime($acctstartdate));
				  $datestop = date('Y-m-d', strtotime($acctstopdate));
					$timestop = date('H:i:s', strtotime($acctstopdate));
					
					if ($acctpower < -1 && $acctpower >= $pwr_out) {

						// Aqui vienen los inserts a las tablas rw_sensoracct
						$sensoracct = "SELECT $esquema.ins_sensoracct('$sensorname',
															'$devicemac',
															'$devicehashmac',
															'$datestart',
															'$timestart',
															'$datestop',
															'$timestop',
															$acctsessiontime,
															$acctpower,
															$acctdistance)";

						$result = pg_exec($dbConnect, $sensoracct);
					}
				}
		  }
		  fclose($handle);
			$totalizar = "SELECT $esquema.totalizar()";
			$result = pg_exec($dbConnect, $totalizar);
		}
		$result = pg_exec($dbConnect, "REFRESH MATERIALIZED VIEW $esquema.sensor_acct_aggregate_view");
		include('library/closedb.php');
	  }

	echo date('Y-m-d H:i:s')."</br>";
	startdataprocess($dirfile);
	// include('library/opendb.php');
	//
	// $sql_sel = "SELECT DISTINCT acctstartdate ".
	// 	"FROM eatoutg.rw_sensoracct ".
	// 		"WHERE acctstartdate BETWEEN '2019-05-03' AND '2019-08-31' ".
	// 			"ORDER BY acctstartdate";
	//   $ret_sel = pg_query($dbConnect, $sql_sel);
	// while ($row_sel = pg_fetch_row($ret_sel)) {
	// 	$date = $row_sel[0];
	//
	// 	$totalizar = "SELECT eatoutg.totalizar_by_date('$date')";
	// 	$result = pg_exec($dbConnect, $totalizar);
	// }
	// pg_exec($dbConnect, "REFRESH MATERIALIZED VIEW ibacp18.sensor_acct_aggregate_view");
	// include('library/closedb.php');
	echo date('Y-m-d H:i:s');
  
?>