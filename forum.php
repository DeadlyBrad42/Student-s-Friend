<?php
  require_once("classes/Database.php");
  require_once("classes/NewsFeed.php");
  require_once("classes/FlashCardManager.php");
  // If the page is being accessed by an AJAX call, the page needs to use the Session to get the UID.
  //  Otherwise, the page is being added indirectly by courses, and the session has already been started.
  if(!isset($_SESSION['userID']))
  {
    session_start();
  }
  
  // Get the specified course by ID
  $courseID = null;
  if(isset($_GET['c']))
  {
    $courseID = $_GET['c'];
  }
  
  // If content & title were passed, then add the new thread to the DB and exit.
  if(isset($_GET['content']) && isset($_GET['title']) && isset($_SESSION['userID']))
  {
    // Sanatize here
    $content = $_GET['content'];
    $title = $_GET['title'];
    
    echo "recieved {$content} and {$title}.";
    
    // Add a new thread
	if(strlen($title) > 0){
		//News feed update.
		$rs = $db->query("SELECT * FROM sfuser WHERE user_ID = '{$_SESSION['userID']}'");
		$row = $rs->fetch_array(MYSQLI_ASSOC);
		$news = "The ".$title." thread was started in the forum section by ".$row['user_fname']." ".$row['user_lname'].".";
		NewsFeed::postUpdate($courseID, $news);

		$db->query("INSERT INTO thread (thread_ID, thread_title, course_ID) VALUES (null, '{$title}', {$courseID})");
    
		// Get the threadID from the last query
		$threadID = $db->getLastInsertedID();
    
		// Add a new post to the thread that was just created
		$db->query("INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) VALUES (null, '{$_SESSION['userID']}', '{$content}', now(), {$threadID})");
    }
    exit();
  }

  
  //Deletes threads
  if(isset($_GET['del']) && isset($_GET['threadID']))
  {
    // Sanitize here
    $delete = $_GET['del'];
    $threadID = $_GET['threadID'];

	//News feed update.
	$rs = $db->query("SELECT * FROM thread WHERE thread_ID={$threadID}");
	$row = $rs->fetch_array(MYSQLI_ASSOC);
	$news = "The ".$row['thread_title']." thread was deleted from the forum section.";
	NewsFeed::postUpdate($courseID, $news);
	$db->next_result();
	//delete
	$db->query("DELETE FROM thread WHERE thread_ID={$threadID}");
	$db->next_result();
	exit();
  }
  
  
  
  // Page generation  
  echo "<div class='forum-wrapper'>";
  $isID = FlashCardManager::getInstruct($courseID);
  $db->next_result();
  // return all the threads sorted by the first post's time
  $result = $db->query("SELECT * FROM thread LEFT JOIN post ON thread.thread_ID=post.thread_ID LEFT JOIN sfuser ON post.user_ID=sfuser.user_ID WHERE thread.course_ID={$courseID} GROUP BY thread.thread_ID ORDER BY post.post_time DESC");
  
  if($courseID == null)
  {
    // Error message to display if no courseID was passed in
    echo "<p>Error: No course specified. Go back and try again.</p>";
  }
  else if($result->num_rows == 0)
  {
    // Message to display if the course forum is empty
    echo "<p>The forum for this class is empty.</p>";
  }
  else if($courseID != null)
  {
    // Build a table with all the threads in it
    while($post = $result->fetch_array(MYSQLI_ASSOC))
    {
      echo "<div class='thread-wrapper'>";
      
      echo "<div class='thread-title'>";
      echo "<a onclick=\"viewThread('{$post['thread_ID']}')\">".urldecode($post['thread_title'])."</a>";
      echo "</div>";
      
      echo "<div class='thread-author'>".($post['user_ID'] != null ? "{$post['user_fname']} {$post['user_lname']}" : "Anonymous")."</div>";
      
      echo "<div class='thread-postdate'>{$post['post_time']}</div>";
      
	  if($_SESSION['userID'] == $isID){
		echo "<a onclick=\"deleteThread('{$post['thread_ID']}')\">Delete</a>";
	  }
      echo "</div><br />"; 
    }
  }
  
  echo "</div>";
  
  // Form for new posts
  echo "<br /><h2>Start a new thread:</h2><br />";
  echo "<p>Thread Title:</p><form class='new-thread' name='input'>";
  echo "<input type='text' name='title' id='title' />";
  echo "<br />Post:<br />";
  echo "<textarea name='content' id='content' rows='5' cols='35'></textarea><br />";
  echo "<input id='poster' type='button' value='Post' onclick='postThread()' />";
  echo "</form>";
  
?>

<script>
var cid = "<?php echo "{$courseID}"; ?>";

$(document).ready(function() {
  toggleAjaxLoader(0);
  forumTimer = setTimeout("reloadPage()", 10000);
});

function postThread()
{
  toggleAjaxLoader(1);
  document.getElementById('poster').disabled=true;
  $.ajax({
    url: "forum.php?title=" + processString($("input#title").val()) + "&content=" + processString($("textarea#content").val()) + "&c=" + cid,
    success: function() {
      // Clear text boxes
      $("input#title").val("");
      $("textarea#content").val("");
      // Reload the page
		reloadPage();
		toggleAjaxLoader(0);
    }
  });
}

function reloadPage()
{
  clearTimeout(forumTimer);
  forumTimer = setTimeout("reloadPage()", 10000);
  var pageurl = "forum.php?c=" + cid + " div.forum-wrapper";
  $('div.forum-wrapper').load(pageurl);
  setTimeout("document.getElementById('poster').disabled=false", 1000);
}

function viewThread(threadID)
{
  toggleAjaxLoader(1);
  clearTimeout(forumTimer);
  var pageurl = "thread.php?threadID=" + threadID + "&c=" + cid;
  $("div#crsContent").load(pageurl);
}

function deleteThread(threadID)
{
  toggleAjaxLoader(1);
  $.ajax({
    url: "forum.php?del=1&threadID=" + threadID,
    success: function() {
      // Reload the page
      reloadPage();
	  toggleAjaxLoader(0);
    }
  });
	
}

</script>
