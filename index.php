<?php session_start();
  $logout = isset($_GET['logout']) ? $_GET['logout'] : "";
  if ($logout == 'true')
    $_SESSION['isLogged'] = 'false';
  if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == 'true')
    header("Location: main.php");
?>
<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="X-UA-Compatible" content="IE=9" />
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
  <body class="login">
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
        
        function verify(user) {
          var uid = user.id;
          var fname = user.first_name;
          var lname = user.last_name; 
          var url = "scripts/checkUser.php?userID="+uid+"&fname="+fname+"&lname="+lname;
          $.ajax({url: url, success: function() {
            window.location = "http://localhost/sf/main.php";
          }});

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
          var params = [token, 'callback=verify'];
          var query = params.join('&');
          var url = path + query;
          var script = document.createElement('script');
          script.src = url;
          document.body.appendChild(script);
        }
      </script>
      </div>
    <div id="headerWrap">
      <div id="header">
        <h2 class="txtCenter">Welcome to the Student's Friend Task Management and Study Assistance Application</h2>
      </div>
    </div>
    <div id="wrapper">
      <div id="content">
        <p>Before using our application, you'll first have to log in through Facebook</p>
        <button id="loginBtn" onclick="FB.login(function(response) { login(); });">Log in with Facebook</button> 
      </div>
    </div>
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
