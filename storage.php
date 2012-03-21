<?php 
  require_once("classes/UserStorage.php");
	require_once("classes/Facebook.php");
  session_start(); 
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");

  // Set the physical path inside the storage class
  UserStorage::setDir($_SESSION['userID'], 0);
  if (isset($_POST['Upload']))
  {
    $file = $_FILES['file']['name'];
    $path = UserStorage::getDir() . "/" . $file;
    if ($_FILES["file"]["error"] > 0)
    {
      $msg = "Error Uploading file: " . $_FILES["file"]["error"] . "<br />"; 
    }
    else if (file_exists($path))
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
      <?php UserStorage::makePage($_SESSION['userID'], $msg); ?>
      </div> 
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
