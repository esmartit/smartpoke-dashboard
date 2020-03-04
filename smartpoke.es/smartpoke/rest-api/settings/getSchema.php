<?php 
  // $loginpath = $_SERVER['PHP_SELF'];
  include ('../../library/checklogin.php');
  include('../../library/opendb.php');

  $sql_sel_schema = "SELECT client, esquema, name ".
         "FROM ".$configValues['TBL_RWCLIENT'];
	$ret_sel_schema = pg_query($dbConnect, $sql_sel_schema);
	$schema_arr = array();

  while ($row_sel_schema = pg_fetch_row($ret_sel_schema)) {
  	
		$client = $row_sel_schema[0];
		$schema = $row_sel_schema[1];
		$name = $row_sel_schema[2];
	
		$schema_arr[] = array("id" => $client, "schema" => $schema, "name" => $name);
  }
	include('../../library/closedb.php');
  echo json_encode($schema_arr);
?>
