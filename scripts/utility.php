<?php
// Constants
// Having issues with relative pathing, will figure out later -awardi
define('ABS_PATH', dirname(__FILE__));
define('IP', '71.31.181.51');
define('USER', 'root');
define('PW','denim');
define('DB','sf');
// End Constants

if (isset($_POST['action']) && !empty($_POST['action']))
{
  $a = $_POST['action'];

  switch($a)
  {
    case "logout":
      doLogout();
      break;
  }
}

if (isset($_POST['Upload']))
{
  doUpload();
}

function doUpload() {
  global $msg;
  if (isset($_GET['c']) && !empty($_GET['c']))
  {
    $ownerID = $_GET['c'];
    UserStorage::setDir($ownerID, 1); 
  }
  else
  {
    $ownerID = $_SESSION['userID'];
    UserStorage::setDir($ownerID, 0);
  }

  $file = $_FILES['file']['name'];
  $path = getcwd() . "/" . UserStorage::getDir() . "/" . $file;
  if ($_FILES["file"]["error"] > 0)
  {
    $msg = "Error Uploading file: " . $_FILES["file"]["error"] . "<br />"; 
  }
  else if (file_exists($path))
  {
    $msg = "{$file} already exists.<br />";
  }
  else
  {
    if (is_uploaded_file($_FILES['file']['tmp_name']))
    {
      move_uploaded_file($_FILES['file']['tmp_name'], $path);
      UserStorage::addItem($ownerID, $file);
    }

    $msg = $file . " was successfully uploaded.<br />";
  }
    //chdir('../');
}

function doLogout()
{
  session_start();
  $_SESSION = array();
  if (isset($_COOKIE[session_name()]))
  {
    setcookie(session_name(),null,time()-10000, '/');
  } 
  session_destroy();
  echo "logout success!";
}

?>
