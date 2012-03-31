<?php
  session_start();
  require_once("../classes/UserStorage.php");
  require_once("../classes/Course.php");
  global $msg;
  if (isset($_GET['cid']) && !empty($_GET['cid']))
  {
  	$c = new Course($_GET['cid']);
    $ownerID = $_GET['cid'];

    // If the current user on this course page IS the instructor, anything they add is OK
    if ($c->get_instructorID() == $_SESSION['userID'])
    	$appr = 1;
    else 
    	$appr = 0;

    UserStorage::setDir($ownerID, 1); 
  }
  else
  {
  	// We're in a user's personal storage, so they'll always have upload approval
  	$appr = 1;
    $ownerID = $_SESSION['userID'];
    UserStorage::setDir($ownerID, 0);
  }

  $file = $_FILES['file']['name'];
  $path = $_SERVER['DOCUMENT_ROOT'] . "sf/" . UserStorage::getDir() . "/" . $file;
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
      chmod($path, 0777);
      UserStorage::addItem($ownerID, $file, $appr);
    }

    $msg = $file . " was successfully uploaded.<br />";
  }

?>
  <script type="text/javascript">
    <?php   
      if (UserStorage::getCrsStatus() == 1)
        echo "window.top.window.switchCrsView(1);";
      else
      {
        echo "window.top.window.ajaxLoad('div#uploadContent', 'scripts/utility.php?action=refreshUserUp&uid={$ownerID}');";
      }
      echo "window.top.window.destroyUpTip();";
      echo "window.top.window.toastMessage('".$msg."');";
    ?>
  </script>
