<?php
	require_once("classes/FlashCardManager.php"); 
	require_once("classes/FlashCardDisplay.php"); 
	require_once("classes/NewsFeed.php");
	session_start(); 
	if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
	header("Location: index.php");
?>

<?php
	$cID = null;
	if(isset($_GET['c']))
	{
		$cID = $_GET['c'];
	}
	if(isset($_GET['Result'])){
		$titles= explode("<ii>",addslashes($_GET['Result']));
		FlashCardDisplay::makeFlashCardScript($titles);
		exit(0);
	}
	elseif(isset($_GET['Change'])){		
		$h=addslashes($_GET['Change']);
		$titles= explode("<ii>",$h);
		FlashCardDisplay::makeFlashCardEditBody($titles, $_SESSION['userID'], $cID);
		exit(0);
	}
	elseif(isset($_GET['add'])){
		$titles= addslashes($_GET['add']);
		FlashCardDisplay::addFlashCardScript($titles);
		exit(0);
	}
	elseif(isset($_GET['edit']) || isset($_GET['inst']) || isset($_GET['return'])){
		if(isset($_GET['edit'])){
			$tHolder = "";
			$news= "The ";
			$t;
			$edits = explode("<ii>",$_GET['edit']);
			for( $i=0; $i<count($edits)-4; $i+=4){
				if($tHolder != $edits[$i+1]){
					$tHolder = $edits[$i+1];
					$t[] = $edits[$i+1];
				}
				FlashCardManager::flashCardEdit($cID, $_SESSION['userID'], $edits[$i], $edits[$i+1], $edits[$i+2], $edits[$i+3] );
			}
			if( count($t) > 1 ){
				for( $i=0; $i<count($t)-1; $i++){
					$news .= $t[$i].", ";
				}	
				$news .= "and ".$tHolder." card groups were edited.";
			}
			else
			{
				$news .= $t[0]." card group was edited.";
			}
			NewsFeed::postUpdate($cID, $news);
		}
		elseif(isset($_GET['inst'])){
			$in = explode("<ii>",$_GET['inst']);
			NewsFeed::postUpdate($cID, "{$in[0]} card group was added to flashcards.");
			for( $i=0; $i<count($in)-3; $i+=3)
				FlashCardManager::insertFlashCards($cID, $_SESSION['userID'], addslashes($in[$i]), addslashes($in[$i+1]), addslashes($in[$i+2]));
		}
		FlashCardDisplay::flashCardSelectBody($cID);
		exit(0);
	}

?>

<!DOCTYPE html>
<html>
  <head>
    <?php 
		require_once("layout/headScripts.php");	
	?>
	
	<link rel='stylesheet' type='text/css' href='styles/basic-quickflips.css' />
	
	<?php
		require_once("layout/header.php"); 
	?>
  </head>
  
  <body>
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
		
		<div id="wrapper">
				<p>
					<?php
						FlashCardDisplay::flashCardSelectBody($cID);	
					?>
					
				</p>
		</div>
	</body>
  
</html>