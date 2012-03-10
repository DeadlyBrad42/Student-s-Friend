<?php
  
  class NewsFeed {
    static function echoFeedFromRS($resultSet) {
	
  	  while($row = $resultSet->fetch_array(MYSQLI_ASSOC)) {	
	    echo "<tr char =" . $row['update_ID'] . "> <td>";
	    echo "<h2>" . $row['course_name'] . ":</h2>";
	    echo "<p class='update'>" . $row['update_text'] . "</p>";
	    echo "<p class='date'>" . $row['update_time'] . "</p>";
	    echo "</td></tr>";
      } 
    }
  }
?>