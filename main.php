<?php
  require_once("classes/Database.php");
  require_once("classes/User.php");
  session_start();
  $id = $_SESSION['userID'];
  $user = new User($id);
  $user->getAll();
?>
<html>
<head>
  <link type="text/css" href="styles/default.css" rel="stylesheet" />
  <script type="text/javascript" src="scripts/jsFuncs.js"></script>
  <script type="text/javascript" src="scripts/jquery.js"></script>
</head>
<body>
  <div id="fb-root">
  <script type="text/javascript">

     window.fbAsyncInit = function() {
        FB.init({ appId: '346560865373540', status: true, cookie: true, xfbml: true });
        FB.Event.subscribe("auth.logout", function() { window.location = "index.php"; });
      };

			(function() {
				var e = document.createElement('script');
				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
				e.async = true;
				document.getElementsByTagName('head')[0].appendChild(e);
			}());
			
			 /*
      // Put the url string together, and create a script tag dynamically
      var token = window.location.hash.substring(1);
      var path = "https://graph.facebook.com/me?";
      var params = [token, 'callback=welcome'];
      var query = params.join('&');
      var url = path + query;
      var script = document.createElement('script');
      script.src = url;
      document.body.appendChild(script);
      */

  </script>
  </div>
  <?php require_once("layout/header.php"); ?>
    <div id="wrapper">
      <p id='userWelcome'><?php echo "Hello, {$user->get_fname()}"; ?>
    </div>
  <?php require_once("layout/footer.php"); ?>
</body>
</html>
