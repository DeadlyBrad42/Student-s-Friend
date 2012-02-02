<?php
  if (session_id() != '')
    header("Location: main.php");
  else
    session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
  <script src="https://connect.facebook.net/en_US/all.js" async="true"></script>
  <script type="text/javascript">
    function login() {
       var path = "https://www.facebook.com/dialog/oauth?client_id=";
       var appId = '346560865373540';
       var redirect = "http://localhost/sf/main.php";
       var params = [appId, "redirect_uri="+redirect, "response_type=token"];
       var query = params.join('&');
       var url = path + query;
       window.location = url;
    }
  </script>
  <link rel="stylesheet" href="styles/default.css" />
  </head>
  <body>
    <div id="wrapper">
    <button id="loginBtn" onclick="FB.login(function(response) { login(); });">Log in with Facebook</button>
      <div id="fb-root">
      <script type="text/javascript">
        window.fbAsyncInit = function() {
          FB.init({ 
						appId:'346560865373540', 
						status:true, 
						cookie:true, 
						xfbml:true, 
						oauth:true
					});
        };

				(function() {
					var e = document.createElement('script');
					e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
					e.async = true;
					document.getElementsByTagName('head')[0].appendChild(e);
				}());
      </script>
      </div>
    </div>
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
