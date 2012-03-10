<?php
  
  class NewsFeed {
    /*********************************
	*	echoFeedFromRS($resultSet, $startBuf, $numFeeds))
	*
	*	Requires: Must be a result set of updates from
	*		sfupdates table.
	*	Action: Takes a result set of updates, skips $startBuf
	*		entries echos them as html table elements until
	*		it reaches the numFeeds (including the skipped feeds).
	**********************************/
  
    static function echoFeedFromRS($resultSet, $startBuf, $numFeeds) {
	  $resultSet->data_seek($startBuf);
	  
  	  for($i = $startBuf; $i < $numFeeds; $i++) {	
	    $row = $resultSet->fetch_array(MYSQLI_ASSOC);
	    echo "<tr char =" . $row['update_ID'] . "> <td>";
	    echo "<h2>" . $row['course_name'] . ":</h2>";
	    echo "<p class='update'>" . $row['update_text'] . "</p>";
	    echo "<p class='date'>" . $row['update_time'] . "</p>";
	    echo "</td></tr>";
      } 
    }
	
	/*********************************
	*	echoFirstUpdateInput($resultSet)
	*
	*	Requires: Result Set must contain an element
	*		date which is the standard sql date
	*		set as the date of the update.
	*	Action: Takes a result set of updates and
	*		outputs a hidden input with the date of
	*		the latest update as it's value for
	*		access in javascript.
	**********************************/
	static function echoFirstUpdateInput($resultSet) {
      $firstRow = $resultSet->fetch_array(MYSQLI_ASSOC);
      echo "<tr><td><input type='hidden' value='" . $firstRow['date'] . "'></td></tr>";
	}
	
	/*********************************
	*	echoLastUpdateInput($resultSet)
	*
	*	Requires: Result Set must contain an element
	*		date which is the standard sql date
	*		set as the date of the update.
	*	Action: Takes a result set of updates and
	*		outputs a hidden input with the date of
	*		the earliest update as it's value for
	*		access in javascript.
	**********************************/
	static function echoLastUpdateInput($resultSet) {
      $resultSet->data_seek($resultSet->num_rows - 1);
      $lastRow = $resultSet->fetch_array(MYSQLI_ASSOC);
      echo "<tr><td><input type='hidden' value='" . $lastRow['date'] . "'></td></tr>";
	}
  }
?>