<?php
  require_once("classes/Database.php");
  require_once("classes/NewsFeed.php");
  
  $userID = $_GET["userID"];
  $topEntryDate = $_GET["topEntryDate"];
  

  global $db;
  $rs = $db->query("SELECT sfupdate.update_ID, course.course_name, sfupdate.update_text, DATE_FORMAT(sfupdate.update_time, '%a %b, %e %l:%i %p') AS update_time, sfupdate.update_time AS date
     FROM sfupdate LEFT JOIN course ON sfupdate.course_ID = course.course_ID WHERE sfupdate.course_ID IN 
    (SELECT course_ID FROM enrollment WHERE user_ID = '{$userID}') AND sfupdate.update_time >= '{$topEntryDate}' ORDER BY sfupdate.update_time DESC");
	
  NewsFeed::echoFirstUpdateInput($rs);
	
  NewsFeed::echoFeedFromRS($rs, 0, ($rs->num_rows - 1) );
?>
