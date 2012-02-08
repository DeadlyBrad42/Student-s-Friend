<!DOCTYPE html>
<?php session_start(); ?>
<html>
  <head>
  <script type="text/javascript" src="scripts/jquery.js"></script>
  <script type="text/javascript">
    function login() {
       var path = "https://www.facebook.com/dialog/oauth?client_id=";
       var appId = '346560865373540';
       var redirect = "http://localhost/sf/index.php";
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

        function welcome(user) {
      	  var uid = user.id;	
      	  var fname = user.first_name;
      	  var lname = user.last_name; 
      	  var url = "scripts/addUser.php?userID="+uid+"&fname="+fname+"&lname="+lname;
          $.ajax({url: url, success: function() {
            window.location = "http://localhost/sf/main.php"; }
          });
        }

				(function() {
					var e = document.createElement('script');
					e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
					e.async = true;
					document.getElementsByTagName('head')[0].appendChild(e);
				}());

        if (window.location.hash.length > 0)
        {
          var token = window.location.hash.substring(1);
          var path = "https://graph.facebook.com/me?";
          var params = [token, 'callback=welcome'];
          var query = params.join('&');
          var url = path + query;
          var script = document.createElement('script');
          script.src = url;
          document.body.appendChild(script);
        }

      </script>
      </div>
    </div>
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
