<?php
	include('library/opendb.php');

	$res_view = pg_exec($dbConnect, "REFRESH MATERIALIZED VIEW smartpoke.sensor_acct_aggregate_view");

	include('library/closedb.php');
	
?>