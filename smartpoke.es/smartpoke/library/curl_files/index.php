<?php

include('login.php');
include('manufacturer.php');
include('register.php');
include('backend.php');
include('manager_rest.php');
include('ap_controller.php');
include('station.php');
include('manager_map_layout.php');
include('manager_map_location.php');

$accesstoken = curl_login('login');
$manufacturer = curl_manufacturer('manufacturer/tree/all', $accesstoken);
$arr_manufacturer = json_decode($manufacturer);

$_id = $arr_manufacturer[0]->_id;
$name = $arr_manufacturer[0]->name;
echo "MANUFACTURER INFO: <br>";
echo "ID :".$_id."<br>";
echo "name :".$name."<br><br>";

$register = curl_register('register/all', $accesstoken, $_id);
$arr_register = json_decode($register);
$arr_status = $arr_register[0]->status;

$numProbAps = $arr_status->numProbAps;
$numClients = $arr_status->numClients;
$numAps = $arr_status->numAps;

echo "REGISTER INFO: <br>";
echo "Prob Aps :".$numProbAps."<br>";
echo "Aps :".$numAps."<br><br>";

$backend_token = curl_backend('backend/access', $accesstoken, $name);

$managerrest = curl_manager_rest('manager-rest/v1/group/root/list', $accesstoken, $backend_token);
$arr_managerrest = json_decode($managerrest);
$long_mr = count($arr_managerrest);

$ap_controller = curl_ap_controller('manager-rest/v1/ap/all', $accesstoken, $backend_token);
$arr_ap_controller = json_decode($ap_controller);

$long_ac = count($arr_ap_controller);

echo "1.) MANAGER REST: <br>";
for ($i = 0; $i < $long_mr; $i++) {
  $id_mr = $arr_managerrest[$i]->id;
  $name = $arr_managerrest[$i]->name;
  echo "<b>ID: ".$id_mr." GROUP: ".$name."</b><br>";
  
  echo "2.) AP CONTROLLER : <br>";
  for ($j = 0; $j < $long_ac; $j++) {
    $group = $arr_ap_controller[$j]->group;
    $id_ap = $arr_ap_controller[$j]->id;
    $alias = $arr_ap_controller[$j]->alias;
    $status = $arr_ap_controller[$j]->status;
    if ($id_mr == $group->id) {
      echo "   ID ".$id_ap."<br>    Alias: ".$alias."<br>    Status: ".$status."<br>";

      echo "3.) STATIONS : <br>";
      
      $ap_clients = curl_ap_clients('manager-rest/v1/group/'.$id_mr.'/clients', $accesstoken, $backend_token);
      $arr_ap_client = json_decode($ap_clients);  
      $long = count($arr_ap_client);

      for ($k = 0; $k < $long; $k++) {

        $id_client = $arr_ap_client[$k]->id;
        $station = curl_station('manager-rest/v1/station/'.$id_client.'/client/detail', $accesstoken, $backend_token);
        $obj_station = json_decode($station);
        $arr_station = (array) $obj_station;

        $mac = $arr_station['mac'];
        $transferPack = $arr_station['transferPack'];
        $transferPackOk = $arr_station['transferPackOk'];
        echo "   AP:".$ap."<br>    MAC: ".$mac."<br>    Transfer Pack: ".$transferPack."<br>    Transfer Pack Ok: ".$transferPackOk."<br>";        
      }

      //if ($status == "ONLINE") {
      //    $maplayout = curl_map_layout('manager-rest/v1/group/'.$id_mr.'/map/layout', $accesstoken, $backend_token);
      //    $arr_maplayout = json_decode($maplayout);
      //    echo "4.) MAP LAYOUT : <br>";
      //    var_dump($arr_maplayout);
      //    echo "<br>";
      //}   
    }  
  }
}



?>