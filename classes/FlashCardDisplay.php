<?php
require_once("FlashCardManager.php");
class FlashCardDisplay{
///////////////////////////////////////////////////////////
// Flash Card Select Page (First page user veiws)//////////
///////////////////////////////////////////////////////////

	
	public static function flashCardSelectBody($cID) {
		$titles = json_decode(FlashCardManager::getCardTitle($cID));
		$counter = count($titles);
		$x = "<input id ='cID' type='hidden' value='{$cID}' />";
		$x .= "<div id ='f'>";
		if($titles[0] != null ){
			$x = $x."<p>Select the titles you would like to study:</p> <form>";
			for($i = 0; $i < $counter; $i++)
				$x = $x."<input type='checkbox' id='{$i}' value='{$titles[$i]->title}' /> {$titles[$i]->title}<br />";
			$x = $x."<br /><input type='button' onclick='validateMyForm({$counter}, true);' value='View' />
						   <input type='button' onclick='validateMyForm({$counter}, false);' value='Edit' />";
		}
		$x = $x."<input type='button' onclick='addCards({$counter});' value='Add Cards' />";
		$x = $x."</div>";
		echo $x;
	}

///////////////////////////////////////////////////////////
// Flash Card Edit Page ///////////////////////////////////
///////////////////////////////////////////////////////////	
	public static function makeFlashCardEditBody($titles, $userID, $cID){
		$deck = FlashCardManager::makeDeck($titles);
		$instructor = FlashCardManager::getInstruct($cID);
		$toEdits = json_decode($deck);
		$counter = count($toEdits);
		$x = "<div id = 'deck'>{$deck}</div>";
		$x = $x."<div id = 'outputContent'>";
		$x = $x."<br /><p>Edit cards:</p> <form>";
		$tHolder = "";
		$flag = true;
		$y = $counter;
		for($i = 0; $i < $y; $i++){
			if($userID == $toEdits[$i]->uid || $userID == $instructor)
			{
				$flag = false;
				if($tHolder != $toEdits[$i]->title){
					$tHolder = $toEdits[$i]->title;
					$x = $x."Title: <input type='text' id='{$i}' value=\"{$toEdits[$i]->title}\"/><br /><br />";
				}
				$q = "Q".$i;
				$a = "A".$i;
				$x = $x."Q: <input type='text' id='{$q}' value=\"{$toEdits[$i]->question}\"/>
						 A: <input type='text' id='{$a}' value=\"{$toEdits[$i]->answer}\"/>
						 <button type='button' onclick = 'clearFeild({$i})' >Clear</button><br /><br />";	
			}
			else{
				$counter--;
			}
		}
		if($flag){
			$x .= "	<p>You can only edit cards tha belong to you.</p><br />
					<button type='button' onclick = 'returnToSelect()' >Select Different Cards</button></div>";
		}
		else{
		$x = $x."<br /><input type='button' onclick='reSubmitCards({$counter})' value='Submit' />
			<input type='button' onclick='deleteCards({$counter})' value='Delete All Cards' /></form><br />
			<button type='button' onclick = 'returnToSelect()' >Select Different Cards</button>
			</div>";
		}
		echo $x;
	}

///////////////////////////////////////////////////////////
// Add Flashcard Page /////////////////////////////////////
///////////////////////////////////////////////////////////	
	
	public static function addFlashCardScript($titles){
		$x = "
		<br />
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
			<div id = 'deck'>{$deck}</div> 
			<div id = 'outputContent'>
				<div class='half-col'>	
					
					<div class='quickFlip3'>
						<div class='redPanel'>
							<div class='panel-content'><br/><br/><br/><p id='questf'></p></div>     
							<div class='pos_set'>
								<button type='button' id='answer' class = 'quickFlipCta' onclick = 'toBack()'>Answer</button>
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

				<div class='under'>
					<button type='button' id='removeCard' onclick = 'removeCard()' >Remove Card</button>
					<button type='button' onclick = 'returnToSelect()' >Select Different Cards</button>
				</div>
			</div>
			";
		echo $x;		
	}
		
///////////////////////////////////////////////////////////	
//End of Flash Card Page///////////////////////////////////
///////////////////////////////////////////////////////////
	}

?>