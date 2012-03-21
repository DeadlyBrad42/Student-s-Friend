<?php 
  require_once("classes/Calendar.php");
	require_once("classes/Facebook.php");
  session_start(); 
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");

  if(isset($_GET['id']) && isset($_GET['day']) && isset($_GET['min']))
  {
    $id = $_GET['id'];
    $day = $_GET['day'];
    $min = $_GET['min'];
    $res = isset($_GET['re']) ? true : false;
    Event::changeEvent($id, $day, $min, $res);   
    exit(0);
  }

  if(isset($_GET['add']) && $_GET['courseID'] && $_GET['add'] == 'true' && isset($_GET['event']))
  {
    $evt = "{" . $_GET['event'] . "}";
    $evt = json_decode($evt);
    Event::createEvent($evt, $_GET['courseID']);
    exit(0);
  }

  if(isset($_GET['delete']) && $_GET['delete'] == 'true' && isset($_GET['eventid']))
  {
    $id = $_GET['eventid'];
    Event::deleteEvent($id);
    exit(0);
  }
?>
<!DOCTYPE html>
<html>
  <head>
	<?php require_once("layout/headScripts.php"); ?>
	<?php Calendar::makeCalScript($_SESSION['userID']); ?>
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
        <?php Calendar::makeCalDiv(); ?>
      </div>
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
