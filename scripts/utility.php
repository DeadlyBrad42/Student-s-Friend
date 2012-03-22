<?php
session_start();
require_once("../classes/UserStorage.php");

if (isset($_REQUEST['action']) && !empty($_REQUEST['action']))
{
  $a = $_REQUEST['action'];

  switch($a)
  {
    case "logout":
      doLogout();
      break;
    case "refreshCourseUp":
      doRefresh();
      break;
    case "refreshUserUp":
      doRefresh();
      break;
  }
}

function doLogout()
{
  $_SESSION = array();
  if (isset($_COOKIE[session_name()]))
  {
    setcookie(session_name(),null,time()-10000, '/');
  } 
  session_destroy();
  echo "logout success!";
}

function doRefresh()
{
  UserStorage::makePage($_SESSION['userID']);
}

?>
