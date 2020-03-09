<?php
// ini_set('display_errors','On');
// error_reporting(E_ALL);

	include ('../../library/checklogin.php');
	
	$session_id = $_SESSION['id'];
 
	$uploadDir = '../../datatables/'; 
	$response = array( 
	    'status' => 0, 
	    'message' => 'Form submission failed, please try again.' 
	); 
 
	$uploadStatus = 1; 
  $uploadedFile = '';
	$file_name = $_FILES["file"]["name"];
	$file_temp = $_FILES["file"]["tmp_name"];
	
	
  if (!empty($_FILES["file"]["name"])){ 
     
	  $fileName = "smartpokeFile-".$session_id.".json"; 
	  $targetFilePath = $uploadDir . $fileName; 

	  if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) { 
	    $uploadedFile = $fileName; 
	  } else { 
	    $uploadStatus = 0; 
	    $response['message'] = 'Sorry, there was an error uploading your file.'; 
	  } 
  } 
 
  if($uploadStatus == 1){ 
    $response['status'] = 1; 
    $response['message'] = 'Form data submitted successfully!'; 
  } 
 
	// Return response 
	echo json_encode($file_name);


?>