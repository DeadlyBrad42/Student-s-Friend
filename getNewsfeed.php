<?php
  require_once("classes/Database.php");
  require_once("classes/NewsFeed.php");
  
  $userID = $_GET["userID"];
  $numfeed = $_GET["numfeed"];
  $lastUpdateID;
  

  global $db;
  $rs = $db->query("SELECT sfupdate.update_ID, course.course_name, sfupdate.update_text, DATE_FORMAT(sfupdate.update_time, '%a %b, %e %l:%i %p') AS update_time, sfupdate.update_time AS date
     FROM sfupdate LEFT JOIN course ON sfupdate.course_ID = course.course_ID WHERE sfupdate.course_ID IN 
    (SELECT course_ID FROM enrollment WHERE user_ID = '{$userID}') ORDER BY sfupdate.update_time DESC LIMIT {$numfeed}");

?>

<?php
  //	Place header and beginning of update table.  
  echo "<div class='headerDiv'><h1>Updates</h1></div>
  <div class='tableDiv'>
  <table id='updateTable'>";
  
  //	Save date of latest update at top for access in javascript.
  NewsFeed::echoFirstUpdateInput($rs);

  //	Fill table with updates.
  NewsFeed::echoFeedFromRS($rs, 0, $rs->num_rows);
  
  //	Save date of earliest update at bottom for access in javascript.
  NewsFeed::echoLastUpdateInput($rs);	  
  
  echo "</table>";
  
  //	Add button for adding earlier feeds to table.
  echo "<div align='center'><button onclick = 'expandFeed(" . $userID . ")'>More</button></div></div>";
  
?>