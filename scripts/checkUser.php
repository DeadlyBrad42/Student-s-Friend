<?php
  require_once("../classes/Database.php");
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
  if($num == 0)
  {
    $db->query("INSERT INTO sfuser (user_ID, user_fname, user_lname) VALUES ('{$userID}','{$fname}','{$lname}')");
    /* debugging */
    //echo "Inserted new user.";
  }
  else
  {
    $rs = $db->query("SELECT * FROM course WHERE user_ID = '{$userID}'");
    if ($rs->num_rows == 0)
    {
    
    }
    else
    {
      $i = 0;
      while($row = $rs->fetch_array(MYSQLI_ASSOC))
      {
       // While there is still a row to fetch, add an array to $courses based on key/value pairs 
        $courses[$i] = 
          (
            array('id' => $row['course_ID'], 
                  'name' => $row['course_name'],
                  'descrip' => $row['course_description'],
                  'time' => $row['course_time'],
                  'location' => $row['course_location'],
                  'eventID' => $row['sfevent_ID'])
          );
        $i++;
      }
      // Test to see if json_encode works...as of 2/13/12, it does
      echo json_encode($courses);
    }  
    /* debugging */
    //echo "Did not insert user.";
  }
  
  $_SESSION['isLogged'] = 'true';
?>