<?php

switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET': echo "62e40df287340cfe5407eb6e1146fc30d86de272"; break;
    case 'POST': $content = trim(file_get_contents("php://input"));
        $data = json_decode($content);

        $aptag_1 = $data->data->apTags[1];
        $aptag_2 = $data->data->apTags[2];
        $aptag_3 = $data->data->apTags[3];
        $aptag_4 = $data->data->apTags[4];
        $aptag_5 = $data->data->apTags[5];

        $groupname = substr($aptag_1, strpos($aptag_1, ':')+1, strlen($aptag_1));
        $hotspot_name = substr($aptag_2, strpos($aptag_2, ':')+1, strlen($aptag_2));
        $esquema = substr($aptag_3, strpos($aptag_3, ':')+1, strlen($aptag_3));
        $sensorname = substr($aptag_4, strpos($aptag_4, ':')+1, strlen($aptag_4));
        $spot_id = substr($aptag_5, strpos($aptag_5, ':')+1, strlen($aptag_5));

        $devices = count($data->data->observations);

        include('../library/pages_common.php');
        include('../library/opendb.php');

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
            }
        }
        $totalizar = "SELECT ".$esquema.".totalizar()";
        $result = pg_exec($dbConnect, $totalizar);

        include('../library/closedb.php');

        break;
    default:
}

?>