<?php
  require_once("classes/Event.php");
  session_start();

  if (isset($_GET['crs']) && isset($_GET['id']))
  {
    $id = $_GET['id'];
    $i = 1;
  }
  else
  {
    $id = $_SESSION['userID'];
    $i = 0;
  }

  echo Event::getEvents($id, $i);
?>
