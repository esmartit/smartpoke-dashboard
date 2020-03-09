

<?php
switch($_SERVER['REQUEST_METHOD']) {
	case 'GET': echo "mIb5zJQuNTj7MRkHZ8-UpyrAz4xqMsaF81A4lfRCOME"; break;
	case 'POST': $content = trim(file_get_contents("php://input"));
			$data = json_decode($content, true);
	
			$name = "esmartit"; // Cambiar nombre del cliente por cada establecimiento
//			$date = date("Ymd");

//			$datafile = "/rocotowifi/PROD/".$date."-".$name.".csv";

//			if (file_exists($datafile) != 1) {
//			  $fh = fopen($datafile, 'w') or die('nok');
//			} else {
//			  $fh = fopen($datafile, 'a');
//			}

			$sensorname = "esmartit0102"; // Cambiar nombre del sensor por cada sensor en el establecimiento

			include('../library/pages_common.php');
			include('../library/opendb.php');

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

			$sql_sensor = "SELECT spot_id ".
						  "FROM ".$esquema.".rw_sensor ".
						  "WHERE sensorname = '$sensorname'";
			$ret_sensor = pg_query($dbConnect, $sql_sensor);
			$row_sensor = pg_fetch_row($ret_sensor);

			$spot_id = $row_sensor[0];

			$mac_ignite = strtoupper(substr($data['client_mac'], 0, 12));
			$macvendor = substr($mac_ignite,0,2).":".substr($mac_ignite,2,2).":".substr($mac_ignite,4,2);
			$macdevice = substr($mac_ignite,6,2).":".substr($mac_ignite,8,2).":".substr($mac_ignite,10,2);
			$mac = $macvendor.":".$macdevice;
			$sensordate = $data['timestamp'];
			$sensordatestart = date('Y-m-d H:i:s', $sensordate);
			$power = (int)$data['rssi'];

			$machashed = hashmac($mac);
			$devicehashmac = $macdevice.'-'.$machashed;
			$sensordatestop = date('Y-m-d H:i:s', strtotime('+15 seconds', strtotime($sensordatestart)));

			$val = ((27.55-(20*log10(2412))+abs($power))/20);
			$meters = pow(10, $val);
			$distance = round($meters,2);

			$datestart = date('Y-m-d', strtotime($sensordatestart));
			$timestart = date('H:i:s', strtotime($sensordatestart));
			$datestop = date('Y-m-d', strtotime($sensordatestop));
			$timestop = date('H:i:s', strtotime($sensordatestop));

			// Aqui vienen los inserts a las tablas rw_sensoracct

			if ($power < -1) {

				$sensoracct = "SELECT ".$esquema.".ins_sensoracct('$sensorname',
													'$macvendor',
													'$devicehashmac',
													'$datestart',
													'$timestart',
													'$datestop',
													'$timestop',
													15,
													$power,
													$distance)";

				$result = pg_exec($dbConnect, $sensoracct);
				
				// Aqui genero el fichero de text... .CSV
//				$string =$spot_id.",".$sensorname.",".$macvendor.",".$vendor.",".$mac.",".$devicehashmac.",".$datestart." ".$timestart.",".$datestop." ".$timestop.",15,".$power.",".$distance."\r\n";
				// echo $string;

//				fwrite($fh, $string);
			}

			$totalizar = "SELECT ".$esquema.".totalizar()";
			$result = pg_exec($dbConnect, $totalizar);

			// $res_view = pg_exec($dbConnect, "REFRESH MATERIALIZED VIEW $esquema.sensor_acct_aggregate_view");

			include('../library/closedb.php');

	break;
	default:
}


?>