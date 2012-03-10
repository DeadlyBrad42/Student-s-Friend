<?php
  require_once("classes/Database.php");
  require_once("classes/User.php");
  require_once("classes/Facebook.php");
  session_start();
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");
  $id = $_SESSION['userID'];
  $user = new User($id);
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once("layout/headScripts.php"); ?>
</head>
<body>
  <div id="fb-root">
  <?php Facebook::makeBodyScript(); ?>
  </div>
  
  <?php require_once("layout/header.php"); ?>
    <div id="wrapper">
      <p id='userWelcome'>
        <?php 
          echo "Hello, {$user->get_fname()}"; 
        ?>
      </p>
	  
	  <div id="newsfeed">
	  </div>
    </div>

    <script type="text/javascript">
      populate_newsfeed(<?php echo $id ?>, 10);
    </script>	
  <?php require_once("layout/footer.php"); ?>
  
</body>
</html>
