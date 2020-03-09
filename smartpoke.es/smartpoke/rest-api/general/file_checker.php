<?php
	include ('../../library/checklogin.php');
	include('../../library/pages_common.php');

	$session_id = $_SESSION['id'];

	$myfile = "../../datatables/mp_detailed-".$session_id.".txt";
	if (file_exists($myfile)) echo "true";
	
?>
