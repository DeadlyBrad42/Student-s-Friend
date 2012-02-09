<?php

  require_once("../classes/Database.php");
  session_start();
  
  /*
  Populate session with user's values
  */
  $userID = $_GET["userID"];
  $_SESSION["userID"] = $userID;
  $fname = $_GET["fname"];
  $lname = $_GET["lname"];
  global $db;

  /*
  Echo variables that have been passed for debugging
  
  echo "{$userID}, {$fname}, {$lname}";
  */
  
  $result = $db->query("SELECT user_ID from sfuser WHERE user_ID = '{$userID}'");
  $num = $result->num_rows;
  echo $num;
  if($num == 0) 
  {
	  $db->query("INSERT INTO sfuser (user_ID, user_fname, user_lname) VALUES ('{$userID}','{$fname}','{$lname}')");
	  echo "Inserted new user.";
  } else
  {
	  echo "Did not insert user.";
  }

?>
