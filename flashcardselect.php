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
				if(isset($_GET['Result'])){
					require_once("layout/header.php");
					$titles= explode(",",$_GET['Result']);
					FlashCardDisplay::makeFlashCardScript($titles);
					exit(0);
				}
				elseif(isset($_GET['Change'])){
					require_once("layout/header.php");
					$h=$_GET['Change'];
					$titles= explode(",",$h);
					FlashCardDisplay::makeFlashCardEditScript($titles);
					FlashCardDisplay::makeFlashCardEditBody($titles, $_SESSION['userID']);
					exit(0);
				}
				elseif(isset($_GET['add'])){
					require_once("layout/header.php");
					$titles= $_GET['add'];
					FlashCardDisplay::addFlashCardScript($titles);
					exit(0);
				}
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
		</div>
		
				<?php require_once("layout/header.php"); ?>
				  <div id="wrapper">
					<p>
						<?php
							FlashCardDisplay::flashCardSelectBody(49);	
						?>
					</p>
		</div>
		</div>
	</body>
  
</html>