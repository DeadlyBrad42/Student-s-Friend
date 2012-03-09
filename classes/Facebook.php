<?php
  class Facebook {
    public static function makeBodyScript()
    {
      echo "  
        <script type='text/javascript'>
        window.fbAsyncInit = function() {
           FB.init({ appId: '346560865373540', status: true, cookie: true, xfbml: true });
           FB.Event.subscribe('auth.logout', function() { 
             $.ajax({url: 'scripts/utility.php', data: {action: 'logout'}, type: 'post', success: function() {
               window.location = 'index.php?logout=true';     
              }
            });  
          });
        };
        
        (function() {
          var e = document.createElement('script');
          e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
          e.async = true;
          document.getElementsByTagName('head')[0].appendChild(e);
        }());
      </script>
      ";
    } 
  }
?>
