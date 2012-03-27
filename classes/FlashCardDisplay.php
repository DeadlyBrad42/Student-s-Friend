<?php
require_once("FlashCardManager.php");

class FlashCardDisplay{
///////////////////////////////////////////////////////////
// Flash Card Select Page (First page user veiws)//////////
///////////////////////////////////////////////////////////

	public static function flashCardSelectScript() {
		$x = "
			<script type='text/javascript'>	
				function addCards(counter){
					var all = new Array();
					
					for (i=0;i<counter;i++){
						all[i] = document.getElementById(i).value;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
					}
					
					$.ajax({url: 'flashcardselect.php?add='+all.toString(), dataType: 'html', success: function(object) {
								$('#f').html(object);}, asyc: false});
				}
			</script>
			";
		
		echo $x;
	}
	
	public static function flashCardSelectBody($cID) {
		$titles = json_decode(FlashCardManager::getCardTitle($cID));
		$counter = count($titles);
		$x = "<div id ='f'>";
		$x = $x."<p>Select the titles you would like to study:</p> <form>";
		for($i = 0; $i < $counter; $i++)
			$x = $x."<input type='checkbox' id='{$i}' value='{$titles[$i]->title}' /> {$titles[$i]->title}<br />";

		$x = $x."<br /><input type='button' onclick='validateMyForm({$counter}, true);' value='Submit' />
				 <input type='button' onclick='validateMyForm({$counter}, false);' value='Edit' />
				 <input type='button' onclick='addCards({$counter});' value='Add Cards' />";
		$x = $x."</div>";
		echo $x;
	}

///////////////////////////////////////////////////////////
// Flash Card Edit Page ///////////////////////////////////
///////////////////////////////////////////////////////////	
	public static function makeFlashCardEditBody($titles, $userID){
		$deck = FlashCardManager::makeDeck($titles);
		$toEdits = json_decode($deck);
		$counter = count($toEdits);
		$x = "<div id = 'deck'>{$deck}</div>";
		$x = $x."<div id = 'outputContent'>";
		$x = $x."<p>Edit cards:</p> <form>";
		$tHolder = "";
		$y = $counter;
		for($i = 0; $i < $y; $i++){
			if($userID != $toEdits[$i]->uid)
			{
				$counter--;
			}
			else{
				if($tHolder != $toEdits[$i]->title){
					$tHolder = $toEdits[$i]->title;
					$x = $x."Title: <input type='text' id='{$i}' value='{$toEdits[$i]->title}'/><br /><br />";
				}
				$q = "Q".$i;
				$a = "A".$i;
				$x = $x."Q: <input type='text' id='{$q}' value='{$toEdits[$i]->question}'/>
						 A: <input type='text' id='{$a}' value='{$toEdits[$i]->answer}'/>
						 <button type='button' onclick = 'clearFeild({$i})' >Clear</button><br /><br />";		

			}
		}
		$x = $x."<br /><input type='button' onclick='reSubmitCards({$counter})' value='Submit' /></form><br />
			<button type='button' onclick = 'returnToSelect()' >Select Different Cards</button>
			</div>";
		echo $x;
	}

///////////////////////////////////////////////////////////
// Add Flashcard Page /////////////////////////////////////
///////////////////////////////////////////////////////////	
	
	public static function addFlashCardScript($titles){
		$x = "
			<p>Add cards:</p> 
			<form>
				Title: <input type='text' id='T' onblur='checkTitle()'/><br /><br />
				Q: <input type='text' id='Q'/>
				A: <input type='text' id='A'/><br /><br />
				<button type='button' onclick = 'next()' >Next Card</button>
				<button type='button' onclick = 'sumitNewCards()' >Submit</button><br />
				<button type='button' onclick = 'returnToSelect()' >Select Different Cards</button>
			</form>
			";
		
		echo $x;
	}
		
///////////////////////////////////////////////////////////
// Flash Card Page ////////////////////////////////////////
///////////////////////////////////////////////////////////

	public static function makeFlashCardScript($titles) {
		$deck = FlashCardManager::makeDeck($titles, true);
		$x = "
		<!--
			<script src='scripts/jquery.quickflip.source.js' type='text/javascript'></script>
			<script type='text/javascript'>
				var counter = 0;
				var front = true;
				var deck = {$deck};
				
				$(document).ready(function() {
					$(function() {
						console.log('GOT HERE!!!!!!');
						$('.quickFlip3').quickFlip();
					}					
				);
					getNew();
				});
												
				function removeCard() {
					if(deck.length > 1 ){
						counter--;
						deck.splice(counter, 1);
						getNew();
					}
				}

				function getNew() {
					if (counter == deck.length) {
						counter = 0;
					}

					$('#questf').html(deck[counter].question);
					$('#questb').html(deck[counter].question);
					$('#ans').html(deck[counter].answer);
					counter++;
				}
				
			</script>
			-->
			
			<div id = 'deck'>{$deck}</div> 
			<div id = 'outputContent'>
				<div class='half-col'>	
					
					<div class='quickFlip3'>
						<div class='redPanel'>
							<div class='panel-content'><br/><br/><br/><p id='questf'></p></div>     
							<div class='pos_set'>
								<button type='button' id='answer' class = 'quickFlipCta'>Answer</button>
							</div>
						</div>

						<div class='blackPanel'>
							<div><br/><br/><p id='questb'></p><br/><p id='ans'></p></div>
							
							<div class='pos_set'>
								<button type='button' id='question' class = 'quickFlipCta' onclick = 'getNew()'>Next Question</button>
							</div>
						</div>
					</div>
				</div>

				<button type='button' id='removeCard' onclick = 'removeCard()' >Remove Card</button>
				<br />
				<button type='button' onclick = 'returnToSelect()' >Select Different Cards</button>
			</div>
			";
		echo $x;		
	}
		
///////////////////////////////////////////////////////////	
//End of Flash Card Page///////////////////////////////////
///////////////////////////////////////////////////////////
	}

?>