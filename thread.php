<?php
  require_once("classes/Database.php");
  
  session_start();
  
  // Get the specified course by ID
  $courseID = null;
  if(isset($_GET['c']))
  {
    $courseID = $_GET['c'];
  }
  
  // If content & a threadID were passed, then add the new post to the DB and exit.
  if(isset($_GET['content']) && isset($_GET['threadID']) && isset($_SESSION['userID']))
  {
    // Sanatize here
    $content = $_GET['content'];
    $threadID = $_GET['threadID'];
    
    // Add a new post
    $db->query("INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) VALUES (null, '{$_SESSION['userID']}', '{$content}', now(), {$threadID})");
    
    exit(0);
  }
  
  // If del, a postID, & a threadID were passed, and userID matches the post author, delete it and exit
  if(isset($_GET['del']) && isset($_GET['postID']) && isset($_GET['threadID']) && isset($_SESSION['userID']))
  {
    // Sanitize here
    $delete = $_GET['del'];
    $postID = $_GET['postID'];
    $threadID = $_GET['threadID'];
    
    if($delete)
    {
      $db->query("DELETE FROM post WHERE user_ID={$_SESSION['userID']} AND post_ID={$postID}");
    }
    
    // If this makes the thread empty, delete the thread from the database
    if( $db->query("SELECT * FROM post WHERE thread_ID={$threadID}")->num_rows == 0 )
    {
      $db->query("DELETE FROM thread WHERE thread_ID={$threadID}");
    }
    
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
      
      echo "<div class='post-author'>".($post['user_ID'] != null ? "{$post['user_fname']} {$post['user_lname']}" : "Anonymous")."</div>";
      
      echo "<div class='post-time'>{$post['post_time']}</div>";
      
      echo "<div class='post-content'>".urldecode($post['post_content'])."</div>";
      
      if($post['user_ID'] == $_SESSION['userID'])
      {
        echo "<div id='post-delete'><a onclick='deletePost({$post['post_ID']})'>Delete</a></div>";
      }
      
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

function reloadPage()
{
  var pageurl = "thread.php?threadID=" + $("input#threadID").val() + " div.thread-wrapper";
  $('div.thread-wrapper').load(pageurl);
}

function postPost()
{
  $.ajax({
    url: "thread.php?content=" + processString($("textarea#content").val()) + "&threadID=" + $("input#threadID").val(),
    success: function() {
      // Clear text boxes
      $("textarea#content").val("");
      
      // Reload the page
      reloadPage();
    }
  });
}

function deletePost(postID)
{
  $.ajax({
    url: "thread.php?del=1&postID=" + postID + "&threadID=" + $("input#threadID").val(),
    success: function() {
      // Reload the page
      reloadPage();
    }
  });
}
</script>