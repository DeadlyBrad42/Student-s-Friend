<?php
  require_once("classes/Event.php");
  session_start();
  $id = $_SESSION['userID'];
  echo Event::getEvents($id);
?>
