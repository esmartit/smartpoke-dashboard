<?php
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
function curl_station($dir, $momtoken, $token) {

  $ch = curl_init();

  $dir_req = 'https://cloud.galgus.net:8443/'.$dir;

  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_URL, $dir_req);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $headers = array();
  $headers[] = "Authorization: Bearer ".$token;
  $headers[] = "Content-Type: application/json";
  $headers[] = "Mom-Auth: ".$momtoken;
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = curl_exec($ch);
  if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
  }
  curl_close ($ch);
  return $result;

}
?>