<?php 
	require_once("classes/Facebook.php");
  session_start(); 
  $userID = $_SESSION['userID'];
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");
?>
<!DOCTYPE html>
<html>
  <head>
		<?php require_once("layout/headScripts.php"); ?>
		<script type="text/javascript">
		  populate_newsfeed(<?php echo $userID ?>, 10);
		</script>
  </head>
  <body>
    <div id="fb-root">
		 <?php Facebook::makeBodyScript(); ?>
    </div>
    <?php require_once("layout/header.php"); ?>
      <div id="wrapper">
	    <div id="newsfeed"></div>
		<p>
			<a href='forum.php'>Forum</a> <br />
			<a href='flashcardselect.php'>Flash Cards</a> 
		</p>
      </div> 
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
