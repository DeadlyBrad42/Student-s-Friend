<?php
  require_once("../classes/Database.php");
  require_once("../classes/UserStorage.php");
  require_once("../scripts/utility.php");
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
  $_SESSION["userName"] = $fname;
  
  // Dubugging
  // echo "{$userID}, {$fname}, {$lname}";
  $rs = $db->query("CALL returnIdIfExists('{$userID}', @id)");
  $rs = $db->query("SELECT @id");
  $num = $rs->fetch_array(MYSQLI_NUM);
  /* Insert the user into the database if they don't already exist */
  if($num[0] == 0)
  {
    $db->query("CALL insertNewUser('{$userID}', '{$fname}', '{$lname}')");
    // Debugging
    // echo "Inserted new user.";
  }
  
  $_SESSION['isLogged'] = 'true';
?>
