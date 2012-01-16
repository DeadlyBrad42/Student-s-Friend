<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
  <link rel="stylesheet" href="styles/default.css" />
  </head>
  <body>
    <div id="headerWrap">
      <div id="header"></div>
    </div>
    <div id="wrapper">
      <div id="fb-root"></div>
      <script type="text/javascript">
        window.fbAsyncInit = function() {
          FB._https = window.location.protocol == "https:";
          FB.init({ appId:'346560865373540', status:true, cookie:true, xfbml:true, oauth:true});
        };
        (function(){
          var js = document.createElement('script');
          js.src = document.location.protocol + "//connect.facebook.net/en_US/all.js";
          js.async = true;
          document.getElementsByTagName('head')[0].appendChild(js);
          }());
      </script>
      <div class="fb-login-button">Login with Facebook</div>
    </div>
    <div id="footerWrap">
      <div id="footer"></div>
    </div>
  </body>
</html>
