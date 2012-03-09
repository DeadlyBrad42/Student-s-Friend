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
