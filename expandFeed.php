<?php
  require_once("classes/Database.php");
  
  $userID = $_GET["userID"];
  $numfeeds = $_GET["numfeed"];
  $firstUpdateID = $_GET["firstUpdateID"];
  

  global $db;
  if($firstUpdateID != -1) {
	$rs = $db->query("SELECT sfupdate.update_ID, course.course_name, sfupdate.update_text, DATE_FORMAT(sfupdate.update_time, '%a %b, %e %l:%i %p') AS update_time
	 FROM sfupdate LEFT JOIN course ON sfupdate.course_ID = course.course_ID WHERE sfupdate.course_ID IN 
	(SELECT course_ID FROM enrollment WHERE user_ID = '{$userID}') AND sfupdate.update_ID < {$firstUpdateID} ORDER BY sfupdate.update_time DESC LIMIT {$numfeeds}");
  } else {
    $rs = $db->query("SELECT sfupdate.update_ID, course.course_name, sfupdate.update_text, DATE_FORMAT(sfupdate.update_time, '%a %b, %e %l:%i %p') AS update_time
	 FROM sfupdate LEFT JOIN course ON sfupdate.course_ID = course.course_ID WHERE sfupdate.course_ID IN 
	(SELECT course_ID FROM enrollment WHERE user_ID = '{$userID}') ORDER BY sfupdate.update_time DESC LIMIT {$numfeeds}");
  }
	
  while($row = $rs->fetch_array(MYSQLI_ASSOC)) {	
	echo "<tr char =" . $row['update_ID'] . "> <td>";
	echo "<h2>" . $row['course_name'] . ":</h2>";
	echo "<p class='update'>" . $row['update_text'] . "</p>";
	echo "<p class='date'>" . $row['update_time'] . "</p>";
	echo "</td></tr>";
  }
?>