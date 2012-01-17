<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
  <link rel="stylesheet" href="styles/default.css" />
	<script src="http://connect.facebook.net/en_US/all.js"></script>
  </head>
  <body>
    <div id="headerWrap">
      <div id="header"></div>
    </div>
    <div id="wrapper">
      <div id="fb-root"></div>
      <script type="text/javascript">
        window.fbAsyncInit = function() {
          FB.init({ appId:'346560865373540', status:true, cookie:true, xfbml:true, oauth:true});
        };
					FB.Event.subscribe('auth.login', function() {
						window.location = "http://localhost/Student_friend/trunk/loginPage.php";
					});
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
