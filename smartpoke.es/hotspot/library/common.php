<?php

/* returns a random alpha-numeric string of length $length */
	function createPassword($length, $chars) {
	
	  if (!$chars)
	    $chars = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789";
		
	  if (!$length)
	    $length = 8;
	
	  srand((double)microtime()*1000000);
	  $i = 0;
	  $pass = '' ;

	  while ($i <= ($length - 1)) {
	    $num = rand() % 33;
	    $tmp = substr($chars, $num, 1);
	    $pass = $pass . $tmp;
	    $i++;
	  }

	  return $pass;

	}

#----------------------------------- HASH MAC --------------------------------------

  function hashmac($hashmac) {

    $machashed=1000000;
    $j=0;
    $i = 1;

    while ($i<=17) {
      $strchar = substr($hashmac, $j, 1);
      $asciichar = ord($strchar);
      $machashed = $machashed + ($asciichar * $i);

      $i++;
      $j++;
				
    }
    return $machashed;
  }
	#----------------------------------------------------------------------------------

	
	function qq($text) {return str_replace('`','"',$text); }
	function printq($text) { print qq($text); }
	function printqn($text) { print qq($text)."\n"; }

	#------------------------ Validate Mobile Number -----------------------------------
	function validatemobile($code, $phonenumber) {
  
	  $phoneok = 0;  
	  switch($code) {
	    case "COL":
	      if (preg_match("/^[3]{1}[0125]{1}[0-9]{1}[0-9]{7}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "CRI":
	      if (preg_match("/^[5678]{1}[0-9]{3}[0-9]{4}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "DEU":
	      if (preg_match("/^[1]{1}[567]{1}[0-9]{8}$/", $phonenumber) || preg_match("/^[1]{1}[567]{1}[0-9]{9}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "ESP":
	      if (preg_match("/^[67]{1}[0-9]{2}[0-9]{6}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "FRA":
	      if (preg_match("/^[6]{1}[0-9]{2}[0-9]{6}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "GBR":
	      if (preg_match("/^[7]{1}[0-9]{2}[0-9]{7}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "GTM":
	      if (preg_match("/^[45]{1}[0-9]{3}[0-9]{4}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "ITA":
	      if (preg_match("/^[3]{1}[0-9]{2}[0-9]{7}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "NLD":
	      if (preg_match("/^[6]{1}[0-9]{2}[0-9]{6}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "PER":
	      if (preg_match("/^[9]{1}[0-9]{2}[0-9]{6}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "POR":
	      if (preg_match("/^[9]{1}[0-9]{2}[0-9]{6}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "RUS":
	      if (preg_match("/^[9]{1}[0-9]{2}[0-9]{7}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "USA":
	      if (preg_match("/^[1-9]{1}[0-9]{2}[0-9]{7}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;
	    case "VEN":
	      if (preg_match("/^[4]{1}[0-9]{2}[0-9]{7}$/", $phonenumber)) {
	        $phoneok = 1;
	      }  
	      break;      
	  }
	  return $phoneok;
	}
	#----------------------------------------------------------------------------------

	function sendWorldLine($phone, $message, $sender) {

	  $param='user=ESMARTIT'.
			'&company=ESMARTIT'.
			'&passwd=P45_m61X'.
			'&gsm=%2B'.$phone.
			'&type=plus'.
	    '&msg='.$message.
	    '&sender='.$sender;

		$url = 'https://push.tempos21.com/mdirectnx-trust/send?';	 
	  $ch = curl_init();
  
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($ch, CURLOPT_URL, $url);   
	  curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
  
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  $output = curl_exec($ch);
   
	  if (curl_errno($ch)) {
	    $output = 'Error:' . curl_error($ch);
	  }
	  curl_close($ch);

	  return $output;
	} 

?>
