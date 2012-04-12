<?php
  require_once("classes/Database.php");
  require_once("classes/NewsFeed.php");
  require_once("classes/FlashCardManager.php");
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
    $content = addslashes($_GET['content']);
    $threadID = $_GET['threadID'];
    
    // Add a new post
	if(strlen($content) > 0){
		$db->query("INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) VALUES (null, '{$_SESSION['userID']}', '{$content}', now(), {$threadID})");
    }
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
      $db->query("DELETE FROM post WHERE post_ID={$postID}");
	  
    }
        
    exit(0);
  }
  
  // Page generation
  
  if(isset($_GET["threadID"]))
  {
    $currentThread = $_GET["threadID"];
	global $db;
	$q = $db->query("SELECT * FROM thread WHERE thread_ID={$currentThread}");
	$b = $q->fetch_array(MYSQLI_ASSOC);
	$isID = FlashCardManager::getInstruct($b['course_ID']);	
	$db->next_result();
    echo "<div class='all'>";
    // Print the thread title
    $result = $db->query("SELECT * FROM thread WHERE thread_ID={$currentThread}")->fetch_array(MYSQLI_ASSOC);
    echo "<h1 class='thread-title'>".urldecode($result['thread_title'])."</h1>";
    
    echo "<div class='thread-wrapper'>";
    //echo "<a class='cursorPter' onclick='viewForum()'>Back to forum</a><br />";
    echo "<a class='cursorPter' onclick='viewForum()'>Back to forum</a>";
    
    // Print each post in the specified thread
    $result = $db->query("SELECT * FROM post LEFT JOIN sfuser ON post.user_ID=sfuser.user_ID WHERE thread_ID={$currentThread} ORDER BY post_time ASC");
    while($post = $result->fetch_array(MYSQLI_ASSOC))
    {
      echo "<div class='post-wrapper'>";
	  echo "<div id='post-picture' class='post-picture'><a href='http://www.facebook.com/".$post['user_ID']."'><img src=http://graph.facebook.com/".$post['user_ID']."/picture/ width='45' height='45'></a></div>";
      echo "<p id='post-name'>".($post['user_ID'] != null ? "{$post['user_fname']} {$post['user_lname']}" : "Anonymous")."</p>";
    
	$pFormat = "n-j-y H:i";
	$date = new DateTime($post['post_time']);
	$date = $date->format($pFormat);
	  
	  
      //echo "<p>{$post['post_time']}</p><br />";
      echo "<p>{$date}</p>";
      
      //echo "<p>".urldecode($post['post_content'])."</p><br />";
      echo "<p>".urldecode($post['post_content'])."</p>";
      

      if($post['user_ID'] == $_SESSION['userID'] || $_SESSION['userID'] == $isID)
      {
        echo "<span><a class='cursorPter' onclick='deletePost({$post['post_ID']})'>Delete</a></span>";
      }
      
      echo "</div><!--<br /><br />-->";
    }
    
    echo "</div>";
    
    echo "<form class='new-post' name='input' id='input' action='thread.php' method='get'>";
    echo "<textarea name='content' id='content' rows='5' cols='35'></textarea>";
    echo "<input type='hidden' name='threadID' id='threadID' value='{$currentThread}' />";
    echo "<br /><input id='poster' type='button' value='Post' onclick='postPost()' />";
    echo "</form></div>";

  }
  else
  {
    echo "Error displaying thread.";
  }
  
?>

<script>
var cid = "<?php echo "{$courseID}"; ?>";
var threadTimer;

$(document).ready(function() {
  toggleAjaxLoader(0);
  threadTimer = setTimeout("reloadPage()", 10000);
});

function reloadPage()
{
  clearTimeout(forumTimer);
  threadTimer = setTimeout("reloadPage()", 10000);
  var pageurl = "thread.php?threadID=" + $("input#threadID").val() + " div.thread-wrapper";
  $('div.thread-wrapper').load(pageurl);
  setTimeout("document.getElementById('poster').disabled=false", 1000);
}

function postPost()
{
  toggleAjaxLoader(1);
  document.getElementById('poster').disabled=true;
  $.ajax({
    url: "thread.php?content=" + processString($("textarea#content").val()) + "&threadID=" + $("input#threadID").val(),
    success: function() {
      // Clear text boxes
      $("textarea#content").val("");
      
      // Reload the page
      reloadPage();
	  toggleAjaxLoader(0);
    }
  });
}

function viewForum(){
    toggleAjaxLoader(1);
	clearTimeout(threadTimer);
	var pageurl = 'forum.php?c='+cid;
	$('div.all').load(pageurl);
}

function deletePost(postID)
{
  toggleAjaxLoader(1);
  $.ajax({
    url: "thread.php?del=1&postID=" + postID + "&threadID=" + $("input#threadID").val(),
    success: function() {
      // Reload the page
      reloadPage();
	  toggleAjaxLoader(0);
    }
  });
}
</script>
