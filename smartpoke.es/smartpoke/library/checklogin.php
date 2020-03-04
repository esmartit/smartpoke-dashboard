<?php
  function session_verify() {
    session_start();

    $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
    if (substr(md5($REMOTE_ADDR), 0, 10+substr(session_id(), 0, 1)) == 
      substr(session_id(), 1, 10+substr(session_id(), 0, 1))) {
      $session_valid="yes";
    } else {
      $session_valid="no";
    }

    return $session_valid;
  }


  if (session_verify() == "yes") {
    if (!isset($_SESSION['esmartit_logged_in']) || $_SESSION['esmartit_logged_in'] != true) {
      header('Location: /smartpoke/login.php');
//      header('Location: login.php');
      exit;
    }
  } else {
      header('Location: /smartpoke/login.php');
//    header('Location: login.php');
    exit;
  }

?>
