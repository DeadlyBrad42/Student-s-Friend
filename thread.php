<?php
  require_once("/classes/Database.php");
  
  session_start();
  
  if(isset($_GET['content']) && isset($_GET['threadID']) && isset($_SESSION['userID']))
  {
    // Sanatize here
    $content = $_GET['content'];
    $threadID = $_GET['threadID'];
    
    // Add a new post
    $db->query("INSERT INTO post (post_ID, user_ID, post_content, post_time, thread_ID) VALUES (null, '{$_SESSION['userID']}', '{$content}', now(), {$threadID})");
    
    exit(0);
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
      div.thread-wrapper{
        width: 95%;
        margin: 0px auto;
        clear: both;
      }
      
      div.post-author{
        font-size: 1.5em;
        font-weight: bold;
        float: left;
        clear: left;
      }
      
      div.post-content{
        font-size: 1.25em;
        float: left;
        clear: left;
      }
      
      div.post-time{
        font-style: italic;
        float: right;
      }
      
      form.new-post{
        padding: 0px auto;
        clear: both;
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
        if(isset($_GET["threadID"]))
        {
          $currentThread = $_GET["threadID"];
          
          // Print the thread title
          $result = $db->query("SELECT * FROM thread WHERE thread_ID={$currentThread}")->fetch_array(MYSQLI_ASSOC);
          echo "<h1 class='thread-title'>{$result['thread_title']}</h1>";
          
          echo "<div class='thread-wrapper'>";
          
          // Print each post in the specified thread
          $result = $db->query("SELECT * FROM post LEFT JOIN sfuser ON post.user_ID=sfuser.user_ID WHERE thread_ID={$currentThread} ORDER BY post_time ASC");
          while($post = $result->fetch_array(MYSQLI_ASSOC))
          {
            echo "<div class='post-wrapper'>";
            
            echo "<div class='post-author'>".($post['user_ID'] != null ? $post['user_fname']." ".$post['user_lname'] : "Walker")."</div>";
            echo "<div class='post-time'>{$post['post_time']}</div>";
            echo "<div class='post-content'>{$post['post_content']}</div>";
            
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
      function postPost()
      {
        $.ajax({
          url: "thread.php?content=" + $("textarea#content").val() + "&threadID=" + $("input#threadID").val(),
          success: function() {
            // Clear text boxes
            $("textarea#content").val("");
            
            // Add new post to the page
            var pageurl = "thread.php?threadID=" + $("input#threadID").val() + " div.thread-wrapper";
            $('div.thread-wrapper').load("thread.php?threadID=" + $("input#threadID").val() + " div.thread-wrapper");
          }
        });
      }
      </script>
      
    </div>
    
  </body>
</html>