<?php
  session_start();
  require_once("../classes/UserStorage.php");
  global $msg;
  if (isset($_GET['cid']) && !empty($_GET['cid']))
  {
    $ownerID = $_GET['cid'];
    UserStorage::setDir($ownerID, 1); 
  }
  else
  {
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
      UserStorage::addItem($ownerID, $file);
    }

    $msg = $file . " was successfully uploaded.<br />";
  }
?>
  <script type="text/javascript">
  <?php 
      if (UserStorage::getCrsStatus() == 1)
        echo "window.top.window.switchCrsView(1);";
      else
        echo "window.top.window.ajaxLoad('div#uploadContent', 'scripts/utility.php?action=refreshUserUp');";
    ?>
</script>
