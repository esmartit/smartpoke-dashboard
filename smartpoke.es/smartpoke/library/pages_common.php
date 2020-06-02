<?php

  #-----------------------------------------------------------------------------------
  function stats_val($totalact, $totalant) {

    $icon = "fa fa-arrow-down";
    $color = "red";
    $percent = " 100%";

    if ($totalact > 0) {
      if ($totalant > 0) {
        $result=$totalact/$totalant;

        if ($result < 2) {
          if ($result > 1) {
            $icon = "fa fa-arrow-up";
            $color = "green";
            $percent = " ".ROUND((($result-intval($result))*100),1)."%";
          } else {
            if (($result > 0) && ($result < 1)) {
              $icon = "fa fa-arrow-down";
              $color = "red";
              $percent = " ".ROUND(((1-$result)*100),1)."%";
            } else {
              $icon = "fa fa-stop";
              $color = "blue";
              $percent = " 0%";
            }
          }
        } else {
          $icon = "fa fa-arrow-up";
          $color = "green";
          $result=($totalact-$totalant)/$totalant;
          $percent = " ".ROUND(($result*100),1)."%";
        } 
      } else {
        $icon = "fa fa-arrow-up";
        $color = "green";
        //$percent = " ".$totalact."%";
        $percent = " 100%";
      }
    } else {
      if (($totalact == 0) && ($totalant == 0)) {
        $icon = "fa fa-stop";
        $color = "blue";
        $percent = " 0%";
      }
    }
    $arr_data[0] = number_format($totalact);
    $arr_data[1] = $color;
    $arr_data[2] = $icon;
    $arr_data[3] = $percent;

    return $arr_data;
  }

  function percent_val($totalact, $totalant) {

    $percent = 0;

    if ($totalact > 0) {
      if ($totalant > 0) {
        $result=$totalact/$totalant;

        if ($result < 2) {
          if ($result > 1) {
            $percent = " ".ROUND((($result-intval($result))*100),1)."%";
          } else {
            if (($result > 0) && ($result < 1)) {
              $percent = " ".ROUND(((1-$result)*100),1)."%";
            } else {
              $percent = 0;
            }
          }
        } else {
          $result=($totalact-$totalant)/$totalant;
          $percent = " ".ROUND(($result*100),1)."%";
        }       
      } else {
        $percent = $totalact;
      }
    } else {
      if (($totalact == 0) && ($totalant == 0)) {
        $percent = 0;
      }
    }
    return ROUND($percent*100,1);
  }

#-----------------------------------------------------------------------------------

  function toxbyte($size) {

    // Terabytes
    if ( $size > 1099511627776 ) {
      $ret = $size / 1099511627776;
      $ret = round($ret,2)." Tb";
      return $ret;
    }

    // Gigabytes
    if ( $size > 1073741824 ) {
      $ret = $size / 1073741824;
      $ret = round($ret,2)." Gb";
      return $ret;
    }

    // Megabytes
    if ( $size > 1048576 ) {
      $ret = $size / 1048576;
      $ret = round($ret,2)." Mb";
      return $ret;
    }

    // Kilobytes
    if ($size > 1024 ) {
      $ret = $size / 1024;
      $ret = round($ret,2)." Kb";
      return $ret;
    }

    // Bytes
    if ( ($size != "") && ($size <= 1024 ) ) {
      $ret = $size." B";
      return $ret;
    }

  }

  function time2str($time) {

    $str = "";				// initialize variable
    $time = floor($time);
    
    if (!$time)
      return "0 s";

    $d = $time/86400;
    $d = floor($d);

    if ($d) {
      $str .= "$d d, ";
      $time = $time % 86400;
    }

    $h = $time/3600;
    $h = floor($h);
    if ($h) {
      $str .= "$h h, ";
      $time = $time % 3600;
    }

    $m = $time/60;
    $m = floor($m);

    if ($m) {
      $str .= "$m m, ";
      $time = $time % 60;
    }

    if ($time)
      $str .= "$time s, ";

    $str = preg_replace("/, $/",'',$str);
    return $str;
  }

#------------------- Permisos Botones ---------------------------------------
  function opt_buttons($page, $ope_profile_id, $button) {

    include('library/opendb.php');
    $sql = "SELECT ".$button." ".
           "FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." AS mop ".
           "INNER JOIN ".$configValues['TBL_RSMENUOPTIONS']." AS mo ON mop.section = mo.section ".
           "WHERE profile_id = $ope_profile_id AND title = '$page'";

		$sql_button = pg_query($dbConnect, $sql);
		if(!$sql_button) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$res_button = pg_num_rows($sql_button);

    $btn_access = 'disabled';
    if ($res_button == 1) {
      $row = pg_fetch_row($sql_button);
      $access = $row[0];
      if ($access == 1) {
        $btn_access = 'enabled';
      }
    }
    include('library/closedb.php');

    return $btn_access;

  }
  
#--------------- Check All Access / ADD / EDIT / DELETE / SHOW -------------
   
  function check_all($profile_id, $button, $value, $ret) {

    include('library/opendb.php');

    $sql = "SELECT ".$button." ".
           "FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
           "WHERE profile_id = '$profile_id' AND ".$button." = $value";

		$sql_check = pg_query($dbConnect, $sql);
		if(!$sql_check) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$numrowsmenuoptionsprofiles = pg_num_rows($sql_check);
 
    $sql = "SELECT * ".
           "FROM ".$configValues['TBL_RSMENUOPTIONS'];

		$sql_checkall = pg_query($dbConnect, $sql);
		if(!$sql_checkall) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$numrowsmenuoptions = pg_num_rows($sql_checkall);
 
    $check_all = '';
    $val_all = 0;
    if ($numrowsmenuoptions == $numrowsmenuoptionsprofiles) {
      $check_all = 'checked';
      $val_all = 1;
    }   
    include('library/closedb.php');

    if ($ret == 1) 
        $check_all = $val_all;

    return $check_all;
  }

#--------------- UPDATE All Access / ADD / EDIT / DELETE / SHOW -------------
   
  function update_all($profile_id, $button, $value) {

    $currDate = date('Y-m-d H:i:s');
    $operator_user = $_SESSION['operator_user'];

    include('library/opendb.php');

    $sql = "UPDATE ".$configValues['TBL_RSMENUOPTIONSPROFILES']." ".
           "SET ".$button." = $value, updatedate = '$currDate', updateby='$operator_user' ".
           "WHERE profile_id = '$profile_id'";
		$sql_update = pg_query($dbConnect, $sql);
		if(!$sql_update) {
			echo pg_last_error($dbConnect);
			exit;
		}

    include('library/closedb.php');

    $check_all = 0;
    if ($value == 1) 
      $check_all = 1; 

    return $check_all;
  }

#--------------- Get ZIPCODE -------------
   
  function get_zipcode($country, $state, $city, $location) {

    include('library/opendb.php');

    $sql = "SELECT zip_code ".
           "FROM ".$configValues['TBL_RWZIPCODE']." ".
           "WHERE country_id = '$country' AND state_id = '$state' AND city_id = '$city' AND location_id = '$location' ".
					 "LIMIT 1";
		$sql_zipcode = pg_query($dbConnect, $sql);
		if(!$sql_zipcode) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$res_zipcode = pg_num_rows($sql_zipcode);
    $zip_code = '';
    
    if ($res_zipcode != 0) {
      $row = pg_fetch_row($sql_zipcode);
      $zip_code = $row[0];
    }

    include('library/closedb.php');
    return $zip_code;
  }

	#--------------- Get Esquema -------------
   
	  function get_esquema($client) {

	    include('library/opendb.php');

	    $sql = "SELECT esquema ".
	           "FROM ".$configValues['TBL_RWCLIENT']." ".
	           "WHERE client = '$client'";
			$sql_esquema = pg_query($dbConnect, $sql);
			if(!$sql_esquema) {
				echo pg_last_error($dbConnect);
				exit;
			}
			$res_esquema = pg_num_rows($sql_esquema);
	    $esquema = '';
    
	    if ($res_esquema != 0) {
	      $row = pg_fetch_row($sql_esquema);
	      $esquema = $row[0];
	    }

	    include('library/closedb.php');
	    return $esquema;
	  }

#----------------------------- Checked Botones ---------------------------
  function btn_check($value) {

    $button = '';
    if ($value == 1) {
        $button = 'checked';
    }
    return $button;
  }

#------------------- Get File Name ---------------------------------------
  function get_file($page, $ope_profile_id) {

    include('library/opendb.php');
    $sql = "SELECT file ".
           "FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." AS mop ".
           "INNER JOIN ".$configValues['TBL_RSMENUOPTIONS']." AS mo ON mop.section = mo.section ".
           "WHERE profile_id = $ope_profile_id AND title = '$page'";
           
		$sql_file = pg_query($dbConnect, $sql);
		if(!$sql_file) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$res_file = pg_num_rows($sql_file);
    $ret_file = '';
    
    if ($res_file == 1) {
      $row = pg_fetch_row($sql_file);
      $ret_file = $row[0];
    }

    include('library/closedb.php');
    return $ret_file;
  }

#------------------- Get User name ---------------------------------------
  function get_username($esq, $spot, $mobile) {

    include('library/opendb.php');
    $sql = "SELECT DISTINCT username ".
           "FROM ".$esq.".".$configValues['TBL_RSUSERINFO']." ".
           "WHERE spot_id LIKE '$spot' AND mobilephone = '$mobile'";
           
		$sql_username = pg_query($dbConnect, $sql);
		if(!$sql_username) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$res_username = pg_num_rows($sql_username);
    $ret_username = '';
    
    if ($res_username >= 1) {
      $row = pg_fetch_row($sql_username);
      $ret_username = $row[0];
    }

    include('library/closedb.php');
    return $ret_username;
  }

#------------------- Get First name ---------------------------------------
  function get_firstname($esq, $spot, $mobile) {

    include('library/opendb.php');
    $sql = "SELECT DISTINCT firstname ".
           "FROM ".$esq.".".$configValues['TBL_RSUSERINFO']." ".
           "WHERE spot_id LIKE '$spot' AND mobilephone = '$mobile'";
           
		$sql_name = pg_query($dbConnect, $sql);
		if(!$sql_name) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$res_name = pg_num_rows($sql_name);
    $ret_name = '';
    
    if ($res_name >= 1) {
      $row = pg_fetch_row($sql_name);
      $ret_name = $row[0];
    }

    include('library/closedb.php');
    return $ret_name;
  }

#------------------- Get Spot Name ---------------------------------------
  function get_spotname($esq, $spot) {

    include('library/opendb.php');
    $sql = "SELECT spot_name ".
           "FROM ".$esq.".".$configValues['TBL_RWSPOT']." ".
           "WHERE spot_id = '$spot'";
           
		$sql_spotname = pg_query($dbConnect, $sql);
		if(!$sql_spotname) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$res_spotname = pg_num_rows($sql_spotname);
    $ret_spotname = '';
    
    if ($res_spotname == 1) {
      $row = pg_fetch_row($sql_spotname);
      $ret_spotname = $row[0];
    }
		
    include('library/closedb.php');
    return $ret_spotname;
  }

#------------------- Get Message Description ---------------------------------------
  function get_msgdescription($esq, $spot, $messageid) {

    include('library/opendb.php');
    $sql = "SELECT description ".
           "FROM ".$esq.".".$configValues['TBL_RWMESSAGES']." ".
           "WHERE spot_id = '$spot' AND id = '$messageid'";
           
		$sql_msgdescription = pg_query($dbConnect, $sql);
		if(!$sql_msgdescription) {
			echo pg_last_error($dbConnect);
			exit;
		}
		$res_msgdescription = pg_num_rows($sql_msgdescription);
    $ret_msgdescription = '';
    
    if ($res_msgdescription == 1) {
      $row = pg_fetch_row($sql_msgdescription);
      $ret_msgdescription = $row[0];
    }
		
    include('library/closedb.php');
    return $ret_msgdescription;
  }

#------------------- Setting Values ---------------------------------

  function setting_values($esq, $spot, $set) {

    include('library/opendb.php');

    $return = 240;

    $sql = "SELECT name, value FROM ".$esq.".".$configValues['TBL_RWSETTINGS']." WHERE spot_id = '$spot' AND name='$set'";
		$ret_values = pg_query($dbConnect, $sql);
		if(!$ret_values) {
			echo pg_last_error($dbConnect);
			exit;
		}
		
    while ($row = pg_fetch_row($ret_values)) {
      switch($row[0]) {
        case "ret":
          $return = $row[1];
          break;
        case "time_ini":
          $return = $row[1];
          break;
        case "time_end":
          $return = $row[1];
          break;
        case "msg_limit":
          $return = $row[1];
          break;
      }
    }
		
    include('library/closedb.php');
    return $return;
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

#----------------------------------VALIDA NIF CIF NIE -------------------------------

  function validate_docnumber($doctype, $docnumber) {
    //Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad

    $docnumber = strtoupper($docnumber);
    for ($i = 0; $i < 9; $i ++) {
      $num[$i] = substr($docnumber, $i, 1);
    }

    //si no tiene un formato valido devuelve error
    if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $docnumber)) {
      $nifcifnie = 0;
    }

    //algoritmo para comprobacion de codigos tipo CIF
    $digit = 10;
    $suma = $num[2] + $num[4] + $num[6];
    for ($i = 1; $i < 8; $i = $i + 2) {
      $suma = $suma + substr((2 * $num[$i]), 0, 1) + substr((2 * $num[$i]), 1, 1);
    }
    $len = strlen($suma) - 1;
    $control = substr($suma, $len, 1);
    $n = $digit - $control;

    if ($doctype == "NIF") {
      //comprobacion de NIFs estandar
      $ctrlNIF = substr($docnumber, 0, 8);    
      if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $docnumber)) {
        if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', $ctrlNIF % 23, 1)) {
          $nifcifnie = 1;
        } else {
          $nifcifnie = -1;
        }
      }

      //comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
      if (preg_match('/^[KLM]{1}/', $docnumber)) {
        $ctrlNIF = substr($docnumber, 1, 8);    
        if (($num[8] == chr(64 + $n)) || ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', $ctrlNIF % 23, 1))) {
          $nifcifnie = 1;
        } else {
          $nifcifnie = -1;
        }
      }
    }
  
    if ($doctype == "CIF") {
      //comprobacion de CIFs
      if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $docnumber)) {
        $len = strlen($n) - 1;
        $ctrlCIF = substr($n, $len, 1);    
        if (($num[8] == chr(64 + $n)) || ($num[8] == $ctrlCIF)) {
          $nifcifnie = 2;
        } else {
          $nifcifnie = -2;
        }
      }
    }
  
    if ($doctype == "NIE") {
      //comprobacion de NIEs
      if (preg_match('/^[XYZ]{1}/', $docnumber)) {
        if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $docnumber), 0, 8) % 23, 1)) {
          $nifcifnie = 3;
        } else {
          $nifcifnie = -3;
        }
      }
    }
  
    //si todavia no se ha verificado devuelve error
    return $nifcifnie;
  }
  
  function sendWebSMS($phone, $message, $sender) {
  
    $param='id=info@esmartit.es'.
	       '&phoneNumber=+'.$phone.
	       '&psw=eSmartIT2018'.
	       '&textSms='.$message.
	       '&remite='.$sender;
	
	$url = 'https://sms.arsys.es/smsarsys/accion/enviarSms2.jsp?';	 
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);   
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $xml_output = new SimpleXMLElement($output);
    $result = $xml_output->result;
		$result .= ' | '.$xml_output->idenvio;
    return $result;
  }

  function stateWebSMS($idenvio) {
  
    $param='id=info@esmartit.es'.
	       '&psw=eSmartIT2018'.
			'&idenvio='.$idenvio;

  	$url = 'https://sms.arsys.es/smsarsys/accion/estadoSms.jsp?';	 
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
  
  function stateWorldLine($uim) {
  
    $param='user=ESMARTIT'.
			'&company=ESMARTIT'.
			'&passwd=P45_m61X'.
			'&uim='.$uim;

  	$url = 'https://push.tempos21.com/mdirectnx/state?';	 
    $ch = curl_init();
    
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch2,CURLOPT_SSLVERSION, 3);
		curl_setopt($ch2,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch2,CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
     
    if (curl_errno($ch)) {
      $output = 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    return $output;
  }
  
  function MacVendor($mac_address) {

    //$url = "https://api.macvendors.com/" . urlencode($mac_address);
    $url = "https://macvendors.co/api/vendorname/" . urlencode($mac_address);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);

    // $macprovider = 'UNKNOWN';
    if($response) {
      $macprovider = $response;
    } 
    
    return $macprovider;
  }

?>