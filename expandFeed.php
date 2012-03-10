<?php
  require_once("classes/Database.php");
  require_once("classes/NewsFeed.php");
  
  $userID = $_GET["userID"];
  $numfeeds = $_GET["numfeed"];
  $lowestEntryDate = $_GET["lowestEntryDate"];
  

  global $db;
  $rs = $db->query("SELECT sfupdate.update_ID, course.course_name, sfupdate.update_text, DATE_FORMAT(sfupdate.update_time, '%a %b, %e %l:%i %p') AS update_time, sfupdate.update_time AS date
  FROM sfupdate LEFT JOIN course ON sfupdate.course_ID = course.course_ID WHERE sfupdate.course_ID IN 
  (SELECT course_ID FROM enrollment WHERE user_ID = '{$userID}') AND sfupdate.update_time <= '{$lowestEntryDate}' ORDER BY sfupdate.update_time DESC LIMIT {$numfeeds}");

  //	Echo the resultSet excluding the first (duplicate entry).  
  NewsFeed::echoFeedFromRS($rs, 1, $rs->num_rows);
  
  //	Save date of earliest update at bottom for access in javascript.
  NewsFeed::echoLastUpdateInput($rs);
?>