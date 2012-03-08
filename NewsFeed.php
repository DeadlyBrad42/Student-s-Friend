<?php
  require_once("classes/Database.php");
  
  class NewsFeed {
    static function getNewsByID($userID) {
      global $db;
	  $rs = $db->query("SELECT courses_ID, update_text, update_time FROM sfupdate WHERE courses_ID IN 
	    (SELECT course_ID FROM course WHERE user_ID = '{$userID}')");
	
	  $news_array = array();
	
  	  while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
	
        $e = array(
          'courses_ID' => $row['courses_ID'],
          'update_text' => $row['update_text'],
          'update_time' => $row['update_time']);
        
	    $news_array[] = $e;
	  } 
	  
	  return $news_array;
    }
  }
?>