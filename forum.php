<?php
  require_once("/classes/Database.php");
  
  session_start();
  
  if(isset($_GET['content']) && isset($_GET['title']) && isset($_SESSION['userID']))
  {
    // Sanatize here
    $content = $_GET['content'];
    $title = $_GET['title'];
    $courseID = 42;
    
    // Add a new thread
    $db->query("INSERT INTO thread (thread_ID, thread_title, course_ID) VALUES (null, '{$title}', {$courseID})");
    
    // Get the threadID from the last query
    $threadID = $db->getLastInsertedID();
    
    // Add a new post to the thread that was just created
    $db->query("INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) VALUES (null, '{$_SESSION['userID']}', '{$content}', now(), {$threadID})");
    
    //exit();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Student's Friend - Forum</title>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <link rel="stylesheet" href="styles/default.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <style type="text/css">
      div.forum-wrapper{
        width: 95%;
        margin: 0px auto;
      }
      
      div.post-wrapper{
        margin-bottom: 10px;
        clear: both;
      }
      
      div.thread-title{
        font-size: 1.5em;
        font-weight: bold;
        float: left;
        clear: left;
      }
      
      div.thread-author{
        font-size: 1.25em;
        float: left;
        clear: left;
      }
      
      div.thread-postdate{
        font-style: italic;
        float: right;
      }
    </style>
  </head>
  <body>
    <div id="fb-root">
      <script type="text/javascript">
        window.fbAsyncInit = function() {
          FB.init({ appId: '346560865373540', status: true, cookie: true, xfbml: true });
          FB.Event.subscribe("auth.logout", function() { window.location = "index.php?logout=true"; });
        };
        (function() {
          var e = document.createElement('script');
          e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
          e.async = true;
          document.getElementsByTagName('head')[0].appendChild(e);
        }());
      </script>
    </div>
    <?php require_once("layout/header.php"); ?>
    
    <div id="wrapper">
      <?php
        // return all the threads sorted by the first post's time
        $result = $db->query("SELECT * FROM thread LEFT JOIN post ON thread.thread_ID=post.thread_ID LEFT JOIN sfuser ON post.user_ID=sfuser.user_ID GROUP BY thread.thread_ID ORDER BY post.post_time DESC");
        
        echo "<div class='forum-wrapper'>";
        
        // Build a table with all the threads in it
        while($post = $result->fetch_array(MYSQLI_ASSOC))
        {
          echo "<div class='post-wrapper'>";
          
          echo "<div class='thread-title'><a href='thread.php?threadID={$post['thread_ID']}'>{$post['thread_title']}</a></div>";
          echo "<div class='thread-author'>".($post['user_ID'] != null ? $post['user_fname']." ".$post['user_lname'] : "Walker")."</div>";
          echo "<div class='thread-postdate'>{$post['post_time']}</div>";
          
          echo "</div>";
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
      function postThread()
      {
        $.ajax({
          url: "forum.php?title=" + $("input#title").val() + "&content=" + $("textarea#content").val(),
          success: function() {
            // Clear text boxes
            $("input#title").val("");
            $("textarea#content").val("");
            
            // Reload 
            $('div.forum-wrapper').load("forum.php div.post-wrapper");
          }
        });
      }
      </script>

    </div>
    
  </body>
</html>