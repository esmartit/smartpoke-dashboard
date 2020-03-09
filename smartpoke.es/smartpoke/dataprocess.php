<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

  include('library/pages_common.php');
  $dirfiletxt = "/rocotowifi/PROD/*.txt";
  
  function startdataprocess($dir) {
	$files = glob($dir);
		foreach($files as $file_name) {
		  readfiletxt($file_name);
		}
  }

  function readfiletxt($file) {

		$name = substr($file, 17, 8);
		if (substr($name, 7, 1) == '-') $name =  substr($file, 17, 7);		
		$date = date("Ymd");
	
		$datafile = "/rocotowifi/PROD/".$date."-".$name.".csv";
	
		if (file_exists($datafile) != 1) {
		  $fh = fopen($datafile, 'w') or die('nok');
		} else {
		  $fh = fopen($datafile, 'a');
		}

    $sensorname = substr($file, 17, 12);

		include('library/opendb.php');
		$sql_esquema = "SELECT esquema ".
					  "FROM esmartit.rw_client ".
					  "WHERE client = '$name'";
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

		$sql_sensor = "SELECT spot_id, pwr_out ".
					  "FROM ".$esquema.".rw_sensor ".
					  "WHERE sensorname = '$sensorname'";
    $ret_sensor = pg_query($dbConnect, $sql_sensor);
		$row_sensor = pg_fetch_row($ret_sensor);
	
		$spot_id = $row_sensor[0];
		$pwr_out = $row_sensor[1];
	
		$handle = fopen($file, "r") or die("Couldn't get handle");
		if ($handle) {
		  while (!feof($handle)) {
				$buffer = fgetcsv($handle, ",");
				$var1 = "BSSID";
				$var2 = "Station MAC";

				$mac = $buffer[0];
				
				if ($mac == $var1) $flag = 1;
				if ($mac == $var2) $flag = 0;
	
				$sensordatestart = $buffer[1];
				$power = $buffer[3];
				if ($flag == 0 && strlen($mac) == 17 && ($power < -1 && $power >= $pwr_out)) {
				  $machashed = hashmac($mac);
				  $macdevice = substr($mac, 9, 17);
				  $macvendor = substr($mac, 0, 8);
					$devicehashmac = $macdevice.'-'.$machashed;

					$vendor = 'No vendor';		  
				  $sensordatestop = date('Y-m-d H:i:s', strtotime('+60 seconds', strtotime($sensordatestart)));

		          //Calculating distence
				  $val = ((27.55-(20*log10(2412))+abs($power))/20);
				  $meters = pow(10, $val);
				  $distance = round($meters,2);
		  
				  $datestart = date('Y-m-d', strtotime($sensordatestart));
					$timestart = date('H:i:s', strtotime($sensordatestart));
				  $datestop = date('Y-m-d', strtotime($sensordatestop));
					$timestop = date('H:i:s', strtotime($sensordatestop));
		  
					// Aqui vienen los inserts a las tablas rw_sensoracct
					$sensoracct = "SELECT ".$esquema.".ins_sensoracct('$sensorname',
														'$macvendor',
														'$devicehashmac',
														'$datestart',
														'$timestart',
														'$datestop',
														'$timestop',
														60,
														$power,
														$distance)";

						$result = pg_exec($dbConnect, $sensoracct);

	          // Aqui genero el fichero de text... .CSV
			   $string =$spot_id.",".$sensorname.",".$macvendor.",".$devicehashmac.",".$datestart." ".$timestart.",".$datestop."".$timestop.",60,".$power.",".$distance."\r\n";
				  fwrite($fh, $string);
				}
				unlink($file);  	  
		  }
		  fclose($handle);
			$totalizar = "SELECT ".$esquema.".totalizar()";
			$result = pg_exec($dbConnect, $totalizar);

			// $res_view = pg_exec($dbConnect, "REFRESH MATERIALIZED VIEW $esquema.sensor_acct_day_aggregate_view");
		}
		include('library/closedb.php');
  }

  startdataprocess($dirfiletxt);
  
?>