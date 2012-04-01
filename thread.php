<?php
  require_once("/classes/Database.php");
  
  session_start();
  
  // Get the specified course by ID
  $courseID = null;
  if(isset($_GET['c']))
  {
    $courseID = $_GET['c'];
  }
  
  // If content & a thread ID were passed, then add the new post to the DB and exit.
  if(isset($_GET['content']) && isset($_GET['threadID']) && isset($_SESSION['userID']))
  {
    // Sanatize here
    $content = $_GET['content'];
    $threadID = $_GET['threadID'];
    
    // Add a new post
    $db->query("INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) VALUES (null, '{$_SESSION['userID']}', '{$content}', now(), {$threadID})");
    
    exit(0);
  }
  
  
  
  // Page generation
  
  if(isset($_GET["threadID"]))
  {
    $currentThread = $_GET["threadID"];
    
    // Print the thread title
    $result = $db->query("SELECT * FROM thread WHERE thread_ID={$currentThread}")->fetch_array(MYSQLI_ASSOC);
    echo "<h1 class='thread-title'>".urldecode($result['thread_title'])."</h1>";
    
    echo "<div class='thread-wrapper'>";
    //echo "<a onclick='viewForum()'>Back to forum</a>";
    
    // Print each post in the specified thread
    $result = $db->query("SELECT * FROM post LEFT JOIN sfuser ON post.user_ID=sfuser.user_ID WHERE thread_ID={$currentThread} ORDER BY post_time ASC");
    while($post = $result->fetch_array(MYSQLI_ASSOC))
    {
      echo "<div class='post-wrapper'>";
      
      echo "<div class='post-author'>";
      echo ($post['user_ID'] != null ? $post['user_fname']." ".$post['user_lname'] : "Walker");
      echo "</div>";
      
      echo "<div class='post-time'>{$post['post_time']}</div>";
      
      echo "<div class='post-content'>".urldecode($post['post_content'])."</div>";
      
      echo "</div>";
    }
    
    echo "</div>";
    
    echo "<form class='new-post' name='input' id='input' action='thread.php' method='get'>";
    echo "<textarea name='content' id='content' rows='5' cols='35'></textarea>";
    echo "<input type='hidden' name='threadID' id='threadID' value='{$currentThread}' />";
    echo "<input type='button' value='Post' onclick='postPost()' />";
    echo "</form>";
    
  }
  else
  {
    echo "Error displaying thread.";
  }
  
?>

<script>
var cid = "<?php echo "{$courseID}"; ?>";

function postPost()
{
  $.ajax({
    url: "thread.php?content=" + processString($("textarea#content").val()) + "&threadID=" + $("input#threadID").val(),
    success: function() {
      // Clear text boxes
      $("textarea#content").val("");
      
      // Reload the page
      var pageurl = "thread.php?threadID=" + $("input#threadID").val() + " div.thread-wrapper";
      $('div.thread-wrapper').load("thread.php?threadID=" + $("input#threadID").val() + " div.post-wrapper");
    }
  });
}
</script>