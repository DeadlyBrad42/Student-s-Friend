<?php
	require_once("classes/FlashCardManager.php"); 
	require_once("classes/FlashCardDisplay.php"); 
	session_start(); 
	if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
	header("Location: index.php");
	
?>
<!DOCTYPE html>
<html>
  <head>
		<?php
			require_once("layout/headScripts.php");
			echo "<script src='scripts/jquery.quickflip.source.js' type='text/javascript'></script>";
				if(isset($_GET['Result'])){
					$titles= explode(",",$_GET['Result']);
					FlashCardDisplay::makeFlashCardScript($titles);
				}
				elseif(isset($_GET['Change'])){
					$h=$_GET['Change'];
					$titles= explode(",",$h);
					FlashCardDisplay::makeFlashCardEditScript($titles);
				}
				elseif(isset($_GET['add'])){
					FlashCardDisplay::addFlashCardScript();}
//				elseif(isset($_GET['ping'])){
//					$titles= explode(",",$_GET['ping']);
//					FlashCardDisplay::makeFlashCardScript($titles);
//					FlashCardDisplay::redo($_GET['ping']);}
				else{
					if(isset($_GET['edit'])){
						$edits = explode("<>",$_GET['edit']);
						FlashCardManager::flashCardEdit($edits, 49, $_SESSION['userID']);
					}
					elseif(isset($_GET['inst'])){
						$in = explode("<>",$_GET['inst']);
						for( $i=0; $i<count($in)-3; $i+=3)
							FlashCardManager::insertFlashCards(49, $_SESSION['userID'], $in[$i], $in[$i+1], $in[$i+2]);
					}
					FlashCardDisplay::flashCardSelectScript();
				}
			
		 ?>
  </head>
  <body>
	<div id ='f'>
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
		  <script src='scripts/jquery.quickflip.source.js' type='text/javascript'></script>
		</div>
		<?php require_once("layout/header.php"); ?>
		  <div id="wrapper">
			<p>
				<?php
				if(isset($_GET['Result']))
					FlashCardDisplay::makeFlashCardBody();
				elseif(isset($_GET['Change'])){
					$h=$_GET['Change'];
					$titles= explode(",",$h);
					FlashCardDisplay::makeFlashCardEditBody($titles);
				}
				elseif(isset($_GET['add']))
					FlashCardDisplay::addFlashCardBody();
				else
					FlashCardDisplay::flashCardSelectBody(49);	
				?>
			</p>
		  </div>
		<?php //require_once("layout/footer.php"); ?>
	</div>
  </body>
</html>