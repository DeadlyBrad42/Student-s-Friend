<?php
  require_once("classes/Database.php");
  
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
    $db->query("INSERT INTO thread (thread_ID, thread_title, course_ID) VALUES (null, '{$title}', {$courseID})");
    
    // Get the threadID from the last query
    $threadID = $db->getLastInsertedID();
    
    // Add a new post to the thread that was just created
    $db->query("INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) VALUES (null, '{$_SESSION['userID']}', '{$content}', now(), {$threadID})");
    
    exit();
  }
  
  
  
  // Page generation
  
  echo "<div class='forum-wrapper'>";
  
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
      
      echo "<div class='thread-author'>";
      echo ($post['user_ID'] != null ? $post['user_fname']." ".$post['user_lname'] : "Anonymous");
      echo "</div>";
      
      echo "<div class='thread-postdate'>{$post['post_time']}</div>";
      
      echo "</div>";
    }
  }
  
  echo "</div>";
  
  // Form for new posts
  echo "<form class='new-thread' name='input'>";
  echo "<input type='text' name='title' id='title' />";
  echo "<textarea name='content' id='content' rows='5' cols='35'></textarea>";
  echo "<input type='button' value='Post' onclick='postThread()' />";
  echo "</form>";
  
?>

<script>
var cid = "<?php echo "{$courseID}"; ?>";

function postThread()
{
  $.ajax({
    url: "forum.php?title=" + processString($("input#title").val()) + "&content=" + processString($("textarea#content").val()) + "&c=" + cid,
    success: function() {
      // Clear text boxes
      $("input#title").val("");
      $("textarea#content").val("");
      
      // Reload the page
      $('div.forum-wrapper').load("forum.php?c=" + cid + " div.forum-wrapper");
    }
  });
}

function viewThread(threadID)
{
  $("div#crsContent").load("thread.php?threadID=" + threadID + "&c=" + cid);
}
</script>