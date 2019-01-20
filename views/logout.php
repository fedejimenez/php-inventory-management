<?php 

  require_once("../config/connection.php");

  header("Location:".Connect::route()."index.php");

  session_destroy();
  exit();

?>