var counter = 0;
var front = true;
var deck;
var t;

//var i = 0;

//	Takes an ajax response as object, parses the object taking the value
//	in element identified by identifier passed in through dataStore
//	and returning it and posting the content identified by the identifier passed
//	in through outputStore and posts enters it's html into div#f.
function loadDataAndOutput(object, dataStore, outputStore) {
	//	Get the entire object back and store it in f
	$('div#f').html(object);
	
	var storeVar;
	
	//	Pull out the data
	storeVar = $('div#f ' + dataStore).html();
	
	//	Replace html in f with just the content we want user to see.
	$('div#f').html($('div#f ' + outputStore).html());
	
	return storeVar;
}

function loadDeckAndPostOutput(object) {
	var storeVar;

	storeVar = loadDataAndOutput(object, 'div#deck', 'div#outputContent');
	storeVar = eval ("(" + storeVar + ")");
	return storeVar;
}

function processString(s){
	s=escape(s);
	s=s.replace(/\+/g,"%2B");
	s=s.replace(/\&/g,"%26");
	s=s.replace(/\?/g,"%3F");
	s=s.replace(/\@/g,"%40");
	//s=s.replace(/'/g,"%60");
	//s=s.replace(/\"/g,"%22");
	return s;
}

function validateMyForm(con, flag){
	var titles = '';
	var f = false;
	cards = '';
	var j = 0;
	for (i=0;i<con;i++){
		if(document.getElementById(i).checked){
			f = true;
			titles = titles + document.getElementById(i).value+"<ii>";
			j++;
		}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	}
	
	//titles = titles.substr(0,(titles.length-2));
	
	//alert(titles.toString());	//debug
	if( f == true ){
		if(flag){
			toggleAjaxLoader(1);
		    $.ajax({
			url: 'flashcardselect.php?Result=' + processString(titles)+'&c='+document.getElementById('cID').value, 
			dataType: 'html', 
			success: 
				function(object) {
					//	Fill deck variable and f div with new content.
					deck = loadDeckAndPostOutput(object);
					
					//	Set quickflip function and get new card.
					$('.quickFlip3').quickFlip();
					getNew();
					toggleAjaxLoader(0);
				}, 
			asyc: false});
		}
		
		else{
			toggleAjaxLoader(1);
			$.ajax({url: 'flashcardselect.php?Change=' + processString(titles)+'&c='+document.getElementById('cID').value, dataType: 'html', 
			
			success: function(object) {
				deck = loadDeckAndPostOutput(object);
				toggleAjaxLoader(0);
			},
			
			asyc: true});	
		}
	}
}
	
function reSubmitCards(c){
	var results = '';
	var qID = 'Q';
	var aID = 'A';
	var currentTitle;
	var toEdits = deck;
	for(i=0; i < c; i++)
	{
		if(document.getElementById(i))
			currentTitle = document.getElementById(i).value;
			
		results = results+toEdits[i].id+'<ii>'+currentTitle+'<ii>'+document.getElementById(qID.concat(i)).value+'<ii>'+document.getElementById(aID.concat(i)).value+'<ii>';
		
	}
	toggleAjaxLoader(1);
	$.ajax({url: 'flashcardselect.php?edit=' + processString(results)+'&c='+document.getElementById('cID').value, dataType: 'html', success: function(object) {
		$('#f').html(object);
		toggleAjaxLoader(0);
		}, asyc: true
	 });
}

function deleteCards(cr){
	var qID = 'Q';
	var aID = 'A';
	for(i=0; i < cr; i++)
	{
		document.getElementById(qID.concat(i)).value = "";
		document.getElementById(aID.concat(i)).value = "";
	}
	reSubmitCards(cr);
}

function addCards(cont){
	t= null;
	t = new Array();	
	cards = '';
	if( $("#0").length > 0){
	for (i=0;i<cont;i++){
		t[i] = document.getElementById(i).value;                                                                                                                               
	}
	}
	toggleAjaxLoader(1);
	$.ajax({url: 'flashcardselect.php?add='+processString(t.toString())+'&c='+document.getElementById('cID').value, dataType: 'html', 
		success: function(object) {
				$('#f').html(object);
				toggleAjaxLoader(0);
				}, 
				asyc: false});
}
								
function removeCard() {
	if(deck.length > 1 ){
		counter--;
		deck.splice(counter, 1);
		if(!front){
			$('.quickFlip3').quickFlipper();
		}
		getNew();
	}
}

function toBack(){
	front = false;
}

function getNew() {
	front = true;
	if (counter == deck.length) {
		counter = 0;
	}

	$('#questf').html(deck[counter].question);
	$('#questb').html(deck[counter].question);
	$('#ans').html(deck[counter].answer);
	counter++;
}

function returnToSelect(){
	toggleAjaxLoader(1);
	$.ajax({url: 'flashcardselect.php?return=1'+'&c='+document.getElementById('cID').value, dataType: 'html', success: function(object) {
		$('#f').html(object);
		toggleAjaxLoader(0);
		}, asyc: false
	  });
}

function next(){
	document.getElementById('Q').focus();
	makeNewCardsArray()
}

function makeNewCardsArray(){
	if( document.getElementById('T').value != '' && 
		document.getElementById('Q').value != '' &&  
		document.getElementById('A').value != '' ){
		cards = cards + document.getElementById('T').value +'<ii>'+ document.getElementById('Q').value +'<ii>'+ document.getElementById('A').value+'<ii>';
		}
	document.getElementById('Q').value = '';
	document.getElementById('A').value = ''; 
}

function checkTitle(){
	var flag = true;
	for (i=0;i<=t.length-1;i++)
	{
		if( document.getElementById('T').value == t[i] ){
			var r=confirm('The title you entered already exists, if you would like to add cards to this title press OK.');
			if (r==false){
				document.getElementById('T').focus();
				document.getElementById('T').value = '';
				flag = false;
			}
			else
				document.getElementById('T').disabled=true;
		}
	}
	
	if(flag && document.getElementById('T').value != '')
		document.getElementById('T').disabled=true;
		
}

function sumitNewCards(){
	makeNewCardsArray();
	toggleAjaxLoader(1);
	$.ajax({url: 'flashcardselect.php?inst='+processString(cards)+'&c='+document.getElementById('cID').value, dataType: 'html', success: function(object) {
				$('#f').html(object);
				toggleAjaxLoader(0);
			}, asyc: false});					
}

function clearFeild(i){
	document.getElementById('Q'+i).value = '';
	document.getElementById('A'+i).value = ''; 
}
