<?php
  require_once("/classes/Database.php");
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
        // return queries sorted by time created
        $result = $db->query("SELECT * FROM thread LEFT JOIN post on thread.thread_ID=post.thread_ID GROUP BY thread.thread_ID ORDER BY post.post_time DESC");
        
        
        echo "<table>";
        echo "<tr><th>Thread Title</th><th>Thread Author</th><th>First Post Date</th></tr>";
        
        // Build a table with all the threads in it
        while($post = $result->fetch_array(MYSQLI_ASSOC))
        {
          echo "<tr>";
          
          echo "<td><a href='thread.php?threadID={$post['thread_ID']}'>{$post['thread_title']}</a></td>";
          echo "<td>{$post['post_name']}</td>";
          echo "<td>{$post['post_time']}</td>";
          
          echo "</tr>";
        }
        
        echo "</table>";
      ?>
    </div>
    
  </body>
</html>