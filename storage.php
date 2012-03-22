<?php 
  session_start(); 
  require_once("classes/UserStorage.php");
	require_once("classes/Facebook.php");
  
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");

  global $msg;
  UserStorage::setDir($_SESSION['userID'], 0);
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require_once("layout/headScripts.php"); 
          UserStorage::makeStoreScript(); ?>
    <script type="text/javascript">
      populate_newsfeed(<?php echo $_SESSION['userID'] ?>, 10);
	</script>
  </head>
  <body>
    <div id="fb-root">
		<?php Facebook::makeBodyScript(); ?>
    </div>
    <?php require_once("layout/header.php"); ?>
      <div id="wrapper">
      <div id="newsfeed"></div>
      <div id="uploadContent"> <!-- Placed here for ajax refreshing -->
        <?php UserStorage::makePage($_SESSION['userID'], $msg); ?>
      </div>
      </div> 
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
