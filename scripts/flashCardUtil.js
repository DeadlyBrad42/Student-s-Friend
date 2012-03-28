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

/*
function reSubmitCards(counter){
	var results = '';
	var qID = 'Q';
	var aID = 'A';
	var currentTitle;
	var toEdits = {$toEdits};
	for(i=0; i < counter-1; i++)
	{
		alert(qID.concat(i));
		if(document.getElementById(i))
			currentTitle = document.getElementById(i).value;
			
		results = results+toEdits[i].id+'<>'+currentTitle+'<>'+document.getElementById(qID.concat(i)).value+'<>'+document.getElementById(aID.concat(i)).value+'<>';
		
	}
	$.ajax({url: 'flashcardselect.php?edit=' + results, dataType: 'html', success: function(object) {
				$('#f').html(object);
		}
	});
}
*/

function returnToSelect(){
	$.ajax({url: 'flashcardselect.php', dataType: 'html', success: function(object) {
		$('#f').html(object);
		}, asyc: false
	  });
}