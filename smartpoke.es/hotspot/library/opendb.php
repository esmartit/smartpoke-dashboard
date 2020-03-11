<?php


	include (dirname(__FILE__).'/config_read.php');
	// include (dirname(__FILE__).'/tableConventions.php');

	$mydbUser = "user = ".$configValues['DB_USER'];
	$mydbPass = "password = ".$configValues['DB_PASS'];
	$mydbHost = "host = ".$configValues['DB_HOST'];
	$mydbPort = "port = ".$configValues['DB_PORT'];
	$mydbName = "dbname = ".$configValues['DB_NAME'];

	if (!$mydbPort)
	  $mydbPort = '5432';

	$dbConnect = pg_pconnect("$mydbHost $mydbPort $mydbName $mydbUser $mydbPass");

?>
