<?php

  switch($lang) {
    case "es":
      include ("lang/es.conf.php");
      break;
    case "en":
      include ("lang/en.conf.php");
      break;
    default:
      include ("lang/es.conf.php");
      break;
  }

?>
