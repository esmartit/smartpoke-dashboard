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
		case "DNK":
			if (preg_match("/^[23456789]{1}[0-9]{1}[0-9]{6}$/", $number)) {
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
	    case "MEX":
			  if (preg_match("/^[5]{1}[2]{1}[1]{1}[0-9]{8}$/", $number)) {
				  $res = 1;
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

	//  certificado pem extraido de un pkcs12 con la ruta completa absoluta
		$cert = "/certs_sms/esmartit.pem";
		$key = "/certs_sms/esmartit_key.pem";

	//  password del certificado pem
		$passwd = "Te2pp2so";

		$param='user=ESMARTIT'.
			'&company=ESMARTIT'.
			'&passwd=P45_m61X'.
			'&gsm=%2B'.$phone.
			'&type=plus'.
			'&msg='.$message.
			'&sender='.$sender;

	//    $url = 'https://push.tempos21.com/mdirectnx-trust/send?'; Ruta con IP
		$url = 'https://push.tempos21.com/mdirectnx/send?';
		$ch = curl_init();

	//  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	//  curl_setopt($ch, CURLOPT_URL, $url);
	//  curl_setopt($ch, CURLOPT_POST, 1);
	//  curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSLVERSION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSLCERT, $cert);
		curl_setopt($ch, CURLOPT_SSLKEY, $key);
		curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $passwd);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);

		if (curl_errno($ch)) {
			$output = 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		return $output;
	}

?>
