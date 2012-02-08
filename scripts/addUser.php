<?php
<<<<<<< HEAD
  session_start();
  require_once("../classes/Database.php");
  echo "included the database";
  $userID = $_GET['userID'];
  $_SESSION['userID'] = $userID;
  $fname = $_GET['fname'];
  $lname = $_GET['lname'];
=======
require_once("../classes/Database.php");
session_start();
echo "Got here";
$userID = $_GET["userID"];
$_SESSION["userID"] = $userID;
$fname = $_GET["fname"];
$lname = $_GET["lname"];
>>>>>>> 3c0dc91a8f8a34eff3b3032ec533d809e8e645d5

  echo "{$userID}, {$fname}, {$lname}";

  $result = $db->query("SELECT COUNT(*) AS num from sfuser WHERE user_ID = '{$userID}'");
  $row = mysql_fetch_assoc($result);
  if($row['num'] == 0) 
  {
	  $db->query("INSERT INTO sfuser (user_ID, user_fname, user_lname) VALUES ('{$userID}','{$fname}','{$lname}')");
	  echo "Inserted new user.";
  } else
  {
	  echo "Did not insert user.";
  }

  echo mysql_error();
?>
