<?php
  require_once("classes/Database.php");
  
  $userID = $_GET["userID"];
  $numfeed = $_GET["numfeed"];
  

  global $db;
  $rs = $db->query("SELECT course.course_name, sfupdate.update_text, sfupdate.update_time 
     FROM sfupdate LEFT JOIN course ON sfupdate.course_ID = course.course_ID WHERE sfupdate.course_ID IN 
    (SELECT course_ID FROM enrollment WHERE user_ID = '{$userID}') ORDER BY sfupdate.update_time DESC LIMIT {$numfeed}");

	
  echo "<table border='1'>
  <tr>
  <th>Course</th>
  <th>Update</th>
  <th>Time</th>
  </tr>";

  while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
	
	echo "<tr>";
	echo "<td>" . $row['course_name'] . "</td>";
	echo "<td>" . $row['update_text'] . "</td>";
	echo "<td>" . $row['update_time'] . "</td>";
	echo "<tr>";
  } 
  
  echo "</table>";
?>