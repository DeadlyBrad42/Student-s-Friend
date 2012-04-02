<?php 
	require_once("classes/Facebook.php");
	require_once("classes/Calendar.php");
	require_once("classes/UserStorage.php");
	require_once("classes/FlashCardManager.php"); 
	require_once("classes/FlashCardDisplay.php");
	require_once("classes/Course.php");
  $userID = $_SESSION['userID'];
 	$makeCal = 0; 
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");

  if (isset($_GET['view']) && isset($_GET['c']))
  {
    $cid = $_GET['c'];
    $v = $_GET['view'];
    switch($v)
    {
      case 0:
        Calendar::makeCalScript($cid, 1); 
        Calendar::makeCalDiv();
        break;
      case 1:
        UserStorage::setDir($cid, 1);
        UserStorage::makeStoreScript($cid);
        UserStorage::makePage($cid);
        break;
      case 2:
        include("forum.php");
        break;
      case 3:
		FlashCardDisplay::flashCardSelectBody($cid);		
        break;
	  case 4:
		  echo "<div id='enrollMenu'>";
		  Course::echoCourseEnrollMenu($cid);
			Course::echoEnrollRequestsMenu($cid);
		  echo "</div>";
      default:
        break;
    }

    exit(0);
  }
  else if (!isset($_GET['view']) && isset($_GET['c']))
	{
		$cid = $_GET['c'];
		$makeCal = 1;
	}
?>
<!DOCTYPE html>
<html>
  <head>
	<?php require_once("layout/headScripts.php"); ?>
	<script src='scripts/jquery.quickflip.source.js' type='text/javascript'></script>
	<script type='text/javascript' src='scripts/flipFuncs.js'></script>
	<link rel='stylesheet' type='text/css' href='styles/basic-quickflips.css' />
	<link rel='stylesheet' type='text/css' href='styles/flashcard.css' />
	<script src='scripts/courseBuilder.js' type='text/javascript'></script>
	
		<script type="text/javascript">
      populate_newsfeed(<?php echo $userID ?>, 10);
		</script>
  </head>
  <body>
    <div id="ajaxLoader"></div>
    <div id="fb-root">
		 <?php Facebook::makeBodyScript(); ?>
    </div>
    <?php require_once("layout/header.php"); ?>
      <div id="wrapper">
      <div id="newsfeed"></div>
      <div id="crsWrap">
				<?php require_once("layout/courseHeader.php"); ?>
				<div id='crsContent'>
					<?php 
					if($makeCal==1)
					{ 
						echo Calendar::makeCalScript($cid,1);
						echo Calendar::makeCalDiv(); 
					}
					?>
				</div>
			</div> 
      </div> 
    <?php require_once("layout/footer.php"); ?>
  </body>
</html>
