<?php 
  require_once("classes/Calendar.php");
  require_once("classes/Event.php");
  session_start(); 
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");

  if(isset($_GET['id']) && isset($_GET['day']) && isset($_GET['min']))
  {
    $id = $_GET['id'];
    $day = $_GET['day'];
    $min = $_GET['min'];
    $res = isset($_GET['re']) ? true : false;
    Event::changeEvent($id, $day, $min, $res);   
    exit(0);
  }
?>
<!DOCTYPE html>
<html>
  <head>
	<?php require_once("layout/headScripts.php"); ?>
	<?php Calendar::makeCalScript($_SESSION['userID']); ?>
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
      <?php Calendar::makeCalDiv(); ?>
    </div>
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
