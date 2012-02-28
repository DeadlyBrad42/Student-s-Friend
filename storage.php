<?php 
  require_once("classes/UserStorage.php");
  session_start(); 
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");

  // Apparently we can do this asynchronously using iFrames...we might look into that later
  if (isset($_POST['Upload']))
  {
    UserStorage::setDir($_SESSION['userID']);
    $file = $_FILES['file']['name'];
    $path = UserStorage::getDir() . $file;
    if ($_FILES["file"]["error"] > 0)
    {
      $msg = "Error Uploading file: " . $_FILES["file"]["error"] . "<br />"; 
    }
    else if (file_exists($file))
    {
      $msg = "{$file} already exists.<br />";
    }
    else
    {
      if (is_uploaded_file($_FILES['file']['tmp_name']))
      {
        move_uploaded_file($_FILES['file']['tmp_name'], $path);
        UserStorage::addItem($_SESSION['userID'], $file);
      }

      $msg = $file . " was successfully uploaded.<br />";
    }
  }
  else
    $msg = "";
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require_once("layout/headScripts.php"); 
          UserStorage::makeStoreScript(); ?>
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
      <?php UserStorage::makePage($_SESSION['userID'], $msg); ?>
      </div> 
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
