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
					$titles= explode(",",$_GET['Result']);
					FlashCardDisplay::makeFlashCardScript($titles);
					exit(0);
				}
				elseif(isset($_GET['Change'])){
					$h=$_GET['Change'];
					$titles= explode(",",$h);
					FlashCardDisplay::makeFlashCardEditScript($titles);
					FlashCardDisplay::makeFlashCardEditBody($titles, $_SESSION['userID']);
					exit(0);
				}
				elseif(isset($_GET['add'])){
					$titles= $_GET['add'];
					FlashCardDisplay::addFlashCardScript($titles);
					exit(0);
				}
				else{
					if(isset($_GET['edit'])){
						$edits = explode("<>",$_GET['edit']);
						FlashCardManager::flashCardEdit($edits, 49, $_SESSION['userID']);
						FlashCardDisplay::flashCardSelectScript();
						FlashCardDisplay::flashCardSelectBody(49);
						exit(0);
					}
					elseif(isset($_GET['inst'])){
						$in = explode("<>",$_GET['inst']);
						for( $i=0; $i<count($in)-3; $i+=3)
						FlashCardManager::insertFlashCards(49, $_SESSION['userID'], $in[$i], $in[$i+1], $in[$i+2]);
						FlashCardDisplay::flashCardSelectScript();
						FlashCardDisplay::flashCardSelectBody(49);
						exit(0);
					}
					elseif(isset($_GET['returner'])){
						FlashCardDisplay::flashCardSelectScript();
						FlashCardDisplay::flashCardSelectBody(49);
						exit(0);
					}
					
				}
				FlashCardDisplay::flashCardSelectScript();
				FlashCardDisplay::flashCardSelectBody(49);	
		 ?>
  </head>
  
