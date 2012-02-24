<?php
  require_once("/classes/Database.php");
  
  if(isset($_GET['content']) && isset($_GET['threadID']))
  {
    $content = $_GET['content'];
    $threadID = $_GET['threadID'];
    
    $db->query("INSERT INTO post VALUES (null, 'anonymous', '{$content}', now(), {$threadID})");
    
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
          echo "<h1>{$result['thread_title']}</h1>";
          
          
          echo "<table>";
          echo "<tr><th>Author</th><th>Time</th><th>Message</th></tr>";
          
          // Print the posts in the specified thread
          $result = $db->query("SELECT * FROM post WHERE thread_ID={$currentThread} ORDER BY post_time ASC");
          while($post = $result->fetch_array(MYSQLI_ASSOC))
          {
            echo "<tr>";
            
            echo "<td>{$post['post_name']}</td>";
            echo "<td>{$post['post_time']}</td>";
            echo "<td>{$post['post_content']}</td>";
            
            echo "</tr>";
          }
          
          echo "</table>";
          
          echo "<form name='input' action='thread.php' method='get'>";
          echo "<input type='textarea' name='content' />";
          echo "<input type='hidden' name='threadID' value='{$currentThread}' />";
          echo "<input type='submit' value='Post' />";
          echo "</form>";
          
        }
        else
        {
          echo "Error displaying thread.";
        }
      ?>
    </div>
    
  </body>
</html>