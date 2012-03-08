<?php
  require_once("classes/Database.php");
  require_once("classes/User.php");
  session_start();
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");
  $id = $_SESSION['userID'];
  $user = new User($id);
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once("layout/headScripts.php"); ?>
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
      <p id='userWelcome'>
        <?php 
          echo "Hello, {$user->get_fname()}"; 
        ?>
      </p>
    </div>	
  <?php require_once("layout/footer.php"); ?>
  
</body>
</html>
