<?php

session_start();

// if the user is logged in, unset the session
if (isset($_SESSION['esmartit_logged_in'])) {
   unset($_SESSION['esmartit_logged_in']);
}

// completely destory the session and all it's variables

$session_id = $_SESSION['id'];

session_destroy();

// now that the user is logged out,
// go to login page
header('Location: login.php');
?>
