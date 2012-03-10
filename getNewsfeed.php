<?php
  require_once("classes/Database.php");
  require_once("classes/NewsFeed.php");
  
  $userID = $_GET["userID"];
  $numfeed = $_GET["numfeed"];
  $lastUpdateID;
  

  global $db;
  $rs = $db->query("SELECT sfupdate.update_ID, course.course_name, sfupdate.update_text, DATE_FORMAT(sfupdate.update_time, '%a %b, %e %l:%i %p') AS update_time
     FROM sfupdate LEFT JOIN course ON sfupdate.course_ID = course.course_ID WHERE sfupdate.course_ID IN 
    (SELECT course_ID FROM enrollment WHERE user_ID = '{$userID}') ORDER BY sfupdate.update_time DESC LIMIT {$numfeed}");

?>

<?php
  //	Place header and beginning of update table.  
  echo "<div class='headerDiv'><h1>Updates</h1></div>
  <div class='tableDiv'>
  <table id='updateTable'>";

  //	Fill update table.
  NewsFeed::echoFeedFromRS($rs);
  
  echo "</table>";
  
  //	Add button to add more feeds to div.
  echo "<div align='center'><button onclick = 'expandFeed(" . $userID . ")'>More</button></div></div>";
  
?>