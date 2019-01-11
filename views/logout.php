<?php 

  require_once("../config/connection.php");

  session_destroy();

  header("Location".Connect::route()."views/ndex.php");
  exit();

?>