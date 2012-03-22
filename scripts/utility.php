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
      refreshCourseStorageDiv();
      break;
    case "refreshUserUp":
      if (isset($_REQUEST['uid']))
      {
        refreshUserStorageDiv($_REQUEST['uid']);
      }
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

function refreshCourseStorageDiv()
{

}

function refreshUserStorageDiv($uid)
{
  UserStorage::setDir($uid, 0);
  UserStorage::makeStoreScript($uid);
  UserStorage::makePage($_SESSION['userID']);
}

?>
