<?php
  require_once("../classes/Database.php");
  require_once("../classes/UserStorage.php");
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
  
  // Dubugging
  // echo "{$userID}, {$fname}, {$lname}";
  echo "Before returnIdIfExists<br />";
  $rs = $db->query("CALL returnIdIfExists('{$userID}', @id)");
  $rs = $db->query("SELECT @id");
  $num = $rs->fetch_array(MYSQLI_NUM);
  /* Insert the user into the database if they don't already exist */
  if($num[0] == 0)
  {
    $db->query("CALL insertNewUser('{$userID}', '{$fname}', '{$lname}')");
    UserStorage::makeUserDir($userID);
    // Debugging
    // echo "Inserted new user.";
  }
  else
  {
    $rs = $db->query("CALL getCoursesForUser('{$userID}')");
    if ($rs->num_rows == 0)
    {
      // For now, javascript handles the case where there are no rows
    }
    else
    {
      $i = 0;
      $courses = array();
      while($row = $rs->fetch_array(MYSQLI_ASSOC))
      {
       // While there is still a row to fetch, add an array to $courses based on key/value pairs 
        $id = $row['course_ID'];
        $name = $row['course_name'];
        $descrip = $row['course_description'];
        $time = $row['course_time'];
        $location = $row['course_location'];
        $eventID = $row['sfevent_ID'];
        
        $c = array('id' => "{$id}", 
                   'name' => "{$name}",
                   'descrip' => "{$descrip}",
                  'time' => "{$time}",
                  'location' => "{$location}",
                  'eventID' => "{$eventID}");
        
        $courses[] = $c;
      }

      $_SESSION['courses'] = json_encode($courses);
    }  
    // Debugging
    // echo "Did not insert user.";
  }
  
  $_SESSION['isLogged'] = 'true';
?>
