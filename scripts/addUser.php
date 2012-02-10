<?php
  
  require_once("../classes/Database.php");
  global $db;
  session_start();
  
  /*
  Grab the values from the GET request
  */
  $userID = $_GET["userID"];
  $fname = $_GET["fname"];
  $lname = $_GET["lname"];
  
  /*
  Populate session with user's values
  */
  $_SESSION["userID"] = $userID;
  
  /*
  Echo variables that have been passed for debugging
  echo "{$userID}, {$fname}, {$lname}";
  */
  
  $num = $db->query("SELECT user_ID from sfuser WHERE user_ID = '{$userID}'")->num_rows;
  
  /* Insert the user into the database if they don't already exist */
  if($num == 0){
    $db->query("INSERT INTO sfuser (user_ID, user_fname, user_lname) VALUES ('{$userID}','{$fname}','{$lname}')");
    echo "Inserted new user.";
  }
  else{
    echo "Did not insert user.";
  }
  
?>
