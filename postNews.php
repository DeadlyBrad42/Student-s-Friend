<?php
  require_once("classes/Database.php");
  
  $courseID = $_GET['courseID'];
  $update = $_GET['update'];
  
  global $db;
  $db->query("INSERT INTO sfupdate (course_ID, update_text, update_time) VALUES ({$courseID}, '{$update}', NOW());");
?>