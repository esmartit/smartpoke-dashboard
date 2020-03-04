<?php

switch($_SERVER['REQUEST_METHOD'])
{
	case 'GET': echo "62e40df287340cfe5407eb6e1146fc30d86de272"; break;
	case 'POST': $content = trim(file_get_contents("php://input"));
		$data = json_decode($content);

//		$name = $data->data->apTags[1];
		$name = 'esmartit';
		$date = date("Ymd");

//		$datafile = "/rocotowifi/PROD/".$date."-".$name.".csv";
//
//		if (file_exists($datafile) != 1) {
//		  $fh = fopen($datafile, 'w') or die('nok');
//		} else {
//		  $fh = fopen($datafile, 'a');
//		}
		
    $sensorname = $data->data->apTags[2];

		echo $datafile." - ".$sensorname;
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

		$devices = count($data->data->observations);
		for ($i=0; $i<$devices; $i++) {

			$mac = strtoupper($data->data->observations[$i]->clientMac);
			$sensordate = $data->data->observations[$i]->seenTime;
			$sensordatestart = date('Y-m-d H:i:s', strtotime($sensordate));
			$power = $data->data->observations[$i]->rssi - 95;
			$m_distance = $data->data->observations[$i]->location->unc;
			$m_power = $data->data->observations[$i]->rssi;

			$machashed = hashmac($mac);
			$macdevice = substr($mac, 9, 17);
			$macvendor = substr($mac, 0, 8);
			$devicehashmac = $macdevice.'-'.$machashed;

			$vendor = $data->data->observations[$i]->manufacturer;
			$sensordatestop = date('Y-m-d H:i:s', strtotime('+60 seconds', strtotime($sensordatestart)));

			//Calculating distence
			if ($m_distance < 49) {
				$distance = $m_distance;				
			} else {
				$val = ((27.55-(20*log10(2412))+abs($power))/20);
				$meters = pow(10, $val);
				$distance = round($meters,2);				
			}

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
													60,
													$power,
													$distance)";

				$result = pg_exec($dbConnect, $sensoracct);

				// Aqui genero el fichero de text... .CSV
//				$string =$spot_id.",".$sensorname.",".$macvendor.",".$vendor.",".$mac.",".$devicehashmac.",".$datestart." ".$timestart.",".$datestop." ".$timestop.",60,".$power.",".$distance.",".$m_power."\r\n";
				// echo $string;

//				fwrite($fh, $string);
 			}
		}

		$totalizar = "SELECT ".$esquema.".totalizar()";
		$result = pg_exec($dbConnect, $totalizar);

		// $res_view = pg_exec($dbConnect, "REFRESH MATERIALIZED VIEW $esquema.sensor_acct_aggregate_view");

		include('../library/closedb.php');
		
	break;
	default:
}
	
?>