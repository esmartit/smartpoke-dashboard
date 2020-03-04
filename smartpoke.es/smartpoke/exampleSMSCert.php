<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

//certificado pem extraido de un pkcs12 con la ruta completa absoluta
$cert = "/var/www/smartpoke.es/certs_sms/esmartit.pem";
$key = "/var/www/smartpoke.es/certs_sms/esmartit_key.pem";

//password del certificado pem
$passwd = "QsRam4C6";

$param='user=ESMARTIT'.
	'&company=ESMARTIT'.
	'&passwd=P45_m61X'.
	'&gsm=%2B34635951262'.
	'&type=plus'.
  '&msg=ESTO ES UNA PRUEBA c/CERT'.
  '&sender=eSmartIT';

$url = 'https://push.tempos21.com/mdirectnx-trust/send?';	 
$ch = curl_init();

// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

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

echo $output;

?>