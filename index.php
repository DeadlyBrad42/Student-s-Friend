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
       var url = "https://www.facebook.com/dialog/oauth?client_id=346560865373540&redirect_uri=http://localhost/sf/main.php&response_type=token";
      window.location = url;

    }
  </script>
  <link rel="stylesheet" href="styles/default.css" />
  </head>
  <body>
    <div id="headerWrap">
      <div id="header"></div>
    </div>
    <div id="wrapper">
    <button id="loginBtn" onclick="FB.login(function(response) { login(); });">Log in with Facebook</button>
      <div id="fb-root"></div>
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
      <div class="fb-login-button">Login with Facebook</div>
    </div>
    <div id="footerWrap">
      <div id="footer">
        <?php $date = date("Y");
              echo "<p>{$date} Student's Friend Application</p>"; 
        ?>
      </div>
    </div>
  </body>
</html>
