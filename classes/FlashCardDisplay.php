<?php
require_once("FlashCardManager.php");

class FlashCardDisplay{
///////////////////////////////////////////////////////////
// Flash Card Select Page (First page user veiws)//////////
///////////////////////////////////////////////////////////

	public static function flashCardSelectScript() {
		$x = "
			<script type='text/javascript'>		
				function validateMyForm(counter, flag){
					var titles = new Array();
					var j = 0;
					for (i=0;i<counter;i++){
						if(document.getElementById(i).checked){
							 titles[j] = document.getElementById(i).value;
							 j++;
						}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
					}
					if( titles.length != 0 ){
						if(flag){
						  $.ajax({url: 'flashcardselect.php?Result=' + titles.toString(), dataType: 'html', success: function(object) {
								$('#f').html(object);}});
						}
						else{
						$.ajax({url: 'flashcardselect.php?Change=' + titles.toString(), dataType: 'html', success: function(object) {
								$('#f').html(object);}});
						}
					}
				}
				
				function addCards(){
					$.ajax({url: 'flashcardselect.php?add=true', dataType: 'html', success: function(object) {
								$('#f').html(object);}});
				}
			</script>
			";
		
		echo $x;
	}
	
	public static function flashCardSelectBody($cID) {
		$titles = json_decode(FlashCardManager::getCardTitle($cID));
		$counter = count($titles);
		$x = "<p>Select the titles you would like to study:</p> <form>";
		for($i = 0; $i < $counter; $i++)
			$x = $x."<input type='checkbox' id='{$i}' value='{$titles[$i]->title}' /> {$titles[$i]->title}<br />";

		$x = $x."<br /><input type='button' onclick='validateMyForm({$counter}, true);' value='Submit' />
				 <input type='button' onclick='validateMyForm({$counter}, false);' value='Edit' />
				 <input type='button' onclick='addCards();' value='Add Cards' /></form><div id ='f'>";
		echo $x;
	}

///////////////////////////////////////////////////////////
// Flash Card Edit Page ///////////////////////////////////
///////////////////////////////////////////////////////////
	
	public static function makeFlashCardEditScript($titles){
		$toEdits = FlashCardManager::makeDeck($titles);
		$x = "
			<script type='text/javascript'>		
				function reSubmitCards(counter){
					var results = '';
					var qID = 'Q';
					var aID = 'A';
					var currentTitle;
					var toEdits = {$toEdits};
					for(i=0; i < counter; i++)
					{
						if(document.getElementById(i))
							currentTitle = document.getElementById(i).value;
							
						results = results+toEdits[i].id+'<>'+currentTitle+'<>'+document.getElementById(qID.concat(i)).value+'<>'+document.getElementById(aID.concat(i)).value+'<>';
						
					}
					$.ajax({url: 'flashcardselect.php?edit=' + results, dataType: 'html', success: function(object) {
								$('#f').html(object);
								}
							  });
				}
			</script>";
		echo $x;
	}
	
	public static function makeFlashCardEditBody($titles){
		$toEdits = json_decode(FlashCardManager::makeDeck($titles));
		$counter = count($toEdits);
		$x = "<p>Edit cards:</p> <form>";
		$tHolder = "";
		for($i = 0; $i < $counter; $i++){
			if($tHolder != $toEdits[$i]->title){
				$tHolder = $toEdits[$i]->title;
				$x = $x."Title: <input type='text' id='{$i}' value='{$toEdits[$i]->title}'/><br /><br />";
			}
			$q = "Q".$i;
			$a = "A".$i;
			$x = $x."Q: <input type='text' id='{$q}' value='{$toEdits[$i]->question}'/>
					 A: <input type='text' id='{$a}' value='{$toEdits[$i]->answer}'/><br /><br />";			
		}
		$x = $x."<br /><input type='button' onclick='reSubmitCards({$counter})' value='Submit' /></form>";
		echo $x;
	}

///////////////////////////////////////////////////////////
// Add Flashcard Page /////////////////////////////////////
///////////////////////////////////////////////////////////	
	
	public static function addFlashCardScript(){
		$x = "
			<script type='text/javascript'>		
				var title;
				var cards = '';
				
				function next(){
					document.getElementById('Q').focus();
					makeNewCardsArray()
				}
				
				function makeNewCardsArray(){
					if( document.getElementById('T').value != '' && 
      					document.getElementById('Q').value != '' &&  
						document.getElementById('A').value != '' ){
						cards = cards + document.getElementById('T').value +'<>'+ document.getElementById('Q').value +'<>'+ document.getElementById('A').value+'<>';
						}
					document.getElementById('Q').value = '';
					document.getElementById('A').value = ''; 
				}
				
				function sumitNewCards(){
					makeNewCardsArray();
					$.ajax({url: 'flashcardselect.php?inst='+cards, dataType: 'html', success: function(object) {
								$('#f').html(object);}});					
				}
			</script>
			";
		
		echo $x;
	}
	
	public static function addFlashCardBody(){
			$x = "
				<p>Edit cards:</p> 
				<form>
					Title: <input type='text' id='T'/><br /><br />
					Q: <input type='text' id='Q'/>
					A: <input type='text' id='A'/><br /><br />
					<button type='button' onclick = 'next()' >Next Card</button>
					<button type='button' onclick = 'sumitNewCards()' >Submit</button>
				</form>

			";
		echo $x;
	}
	
///////////////////////////////////////////////////////////
// Flash Card Page ////////////////////////////////////////
///////////////////////////////////////////////////////////

	public static function makeFlashCardScript($titles) {
		$deck = FlashCardManager::makeDeck($titles);
		$x = "
			
			<style type='text/css'>
				div.pos_set
				{
					position:absolute;
					bottom:10px;
					left:121px;
				}
			</style>
			<script src='scripts/jquery.quickflip.source.js' type='text/javascript'></script>
			<script type='text/javascript'>
				var counter = 0;
				var front = true;
				var deck = {$deck};
				
				$(document).ready(function() {
					
					getNew();
				});
				
				$(function() {
					$('.quickFlip3').quickFlip();
				});
								
				function removeCard() {
					if(deck.length > 1 ){
						counter--;
						deck.splice(counter, 1);
						getNew();
					}
				}

				function flipCard() {
					$('.quickFlip3').quickFlipper();
					front = !front;
				}

				function getNew() {
					if (!front) {
						flipCard();
					}
					if (counter == deck.length) {
						counter = 0;
					}

					$('#questf').html(deck[counter].question);
					$('#questb').html(deck[counter].question);
					$('#ans').html(deck[counter].answer);
					counter++;
				}
				
				function returnToSelect(){
					$.ajax({url: 'flashcardselect.php', dataType: 'html', success: function(object) {
						$('#f').html(object);
						}
					  });
				}

			</script>
			<link rel='stylesheet' type='text/css' href='styles/basic-quickflips.css' />
			";
		echo $x;		
	}
	
	public static function makeFlashCardBody() {
		$x = "
			<html>
			<body>    
				<br class='clear' />
			<div class='half-col'>	
				
				<div class='quickFlip3'>
					<div class='redPanel'>
						<div class='panel-content'><br/><br/><br/><p id='questf'></p></div>     
						<div class='pos_set'>
							<button type='button' id='answer' onclick = 'flipCard()'>Answer</button>
						</div>
					</div>

					<div class='blackPanel'>
						<div><br/><br/><p id='questb'></p><br/><p id='ans'></p></div>
						
						<div class='pos_set'>
							<button type='button' id='question' onclick = 'flipCard()'>Question</button>
						</div>
					</div>
				</div>
			</div>

				<button type='button' id='new' onclick = 'getNew()' >Get New Question</button>
				<button type='button' id='removeCard' onclick = 'removeCard()' >Remove Card</button>
				<br />
				<button type='button' onclick = 'returnToSelect()' >Select Different Cards</button>

			</body>
			</html>";
		echo $x;
	}
	
	public static function redo($q){
		$x = "
		<script type='text/javascript'>
				$(document).ready(function() {
					$.ajax({url: 'flashcardselect.php?Result=' + '{$q}', dataType: 'html', success: function(object) {
						$('#f').html(object);}});
						});
		</script>";
		echo $x;
	}
///////////////////////////////////////////////////////////	
//End of Flash Card Page///////////////////////////////////
///////////////////////////////////////////////////////////
	}

?>