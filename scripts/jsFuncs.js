function logout(token)
{
  window.location = "https://www.facebook.com/logout.php?next=http://localhost/sf/main.php&access_token=" + token;
}

function populateCourses(crs)
{
  var list = document.getElementById('crsMenu');
  var ul = document.createElement('ul');
  var li, a, txt, url;
  for(var i = 0; i < crs.length; i++)
  {
    li = document.createElement('li');
    a = document.createElement('a');
    url = 'courses.php?c='+crs[i].name;
    a.setAttribute('href', url);
    txt = document.createTextNode(crs[i].name);
    a.appendChild(txt);
    li.appendChild(a);
    ul.appendChild(li);
  }
  list.appendChild(ul);
}

/*
 * Common dialogue() function that creates our dialogue qTip.
 * We'll use this method to create both our prompt and confirm dialogues
 * as they share very similar styles, but with varying content and titles.
 */
function dialogue(content, title) {
  $('<div />').qtip(
  {
    content: {
      text: content,
      title: title
    },
    position: {
      my: 'center', at: 'center', // Center it...
      target: $(window) // ... in the window
    },
    show: {
      ready: true, // Show it straight away
      modal: {
        on: true, // Make it modal (darken the rest of the page)...
        blur: false // ... but don't close the tooltip when clicked
      }
    },
    hide: false, // We'll hide it maunally so disable hide events
    style: 'ui-tooltip-light ui-tooltip-rounded ui-tooltip-dialogue', // Add a few styles
    events: {
      // Hide the tooltip when any buttons in the dialogue are clicked
      render: function(event, api) {
        $('button', api.elements.content).click(api.hide);
      },
      // Destroy the tooltip once it's hidden as we no longer need it!
      hide: function(event, api) { api.destroy(); }
    }
  });
}

// Show Event Dialog
function addEvent(date)
{
  var div = $('<div />', {id: 'evtAddForm'});
  var tbl = $('<table />', {id: 'evtAddTbl'});
  var labels = ['<td>Title:</td>','<td>Start Date:</td>', '<td>End Date:</td>', '<td>Start Time:</td>', 
                '<td>End Time:</td>', '<td>Location:</td>', '<td>Description:</td>'];
  var clickedDate = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
  var clickedTime =
    (date.getHours() < 10 ? "0" + date.getHours() : date.getHours()) + ":" +
    (date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes());
  
  // Content will consist of a question elem and input, with ok/cancel buttons
  var inp = new Array(); 
  inp[0] = $('<input />', {name: 'evtTitle', type: 'text', val: ''});
  inp[1] = $('<input />', {name: 'evtStartDt', type: 'text', val: clickedDate});
  inp[2] = $('<input />', {name: 'evtEndDt', type: 'text', val: clickedDate});
  inp[3] = $('<input />', {name: 'evtStartTi', type: 'text', val: clickedTime});
  inp[4] = $('<input />', {name: 'evtEndTi', type: 'text', val: clickedTime});
  inp[5] = $('<input />', {name: 'evtLocation', type: 'text', val: '' });
  inp[6] = $('<input />', {name: 'evtDescrip', type: 'text', val: '' });
  
  saveBtn = $('<button />', {text: 'Save', click: function() {} }),
  cancelBtn = $('<button />', {text: 'Cancel', click: function() {} });

  for (var i=0; i < labels.length; i++)
  {
    var row = $('<tr />').append(labels[i]).append($('<td />').append(inp[i]));
    tbl.append(row);
  }
  div.append(tbl);
  div.append(saveBtn).append(cancelBtn);
  dialogue(div, 'New Event');
}

function viewEvent(isEdit, date)
{
  $('#calendar').fullCalendar('changeView','agendaDay');
  $('#calendar').fullCalendar('gotoDate', date);
}

function deleteEvent()
{
  // Coming soon
}

function uploadFile()
{
  var form = $(document.createElement('form'));
  form.attr({enctype: 'multipart/form-data', action: 'storage.php', method: 'post'});

  var input = $('<input />', {type: 'file', name: 'file', id: 'file'}),
      upload_btn = $('<input />', {val: 'Upload', name: 'Upload', type: 'Submit'}),
      cncl_btn = $('<button />', {text: 'Cancel', click: function() {} });
  form.append(input).append(upload_btn).append(cncl_btn);

  dialogue( form, 'Upload A New File' );
}

function showUploadPic(src, name)
{
  var box = $('<div />', {id: 'imgBox'}),
      img = $('<img />', {src: src, width: '500', height: '500'})
      btn = $('<button />', {text: 'Close', click: function() {} });

  box.append(img).append(btn);
  dialogue(box, name);
}


/*********************************
*	NEWSFEED FUNCTIONS
*********************************/

/*********************************
*	populate_newsfeed(userID, numFeed)
*	requirements: Must be a div on the page with id newsfeed
*	actions: Fills the div with a table containing the (numfeed) most recent updates for user: userID
*********************************/
function populate_newsfeed(userID, numfeed) 
{
  //Save the number of feeds requested for expandFeed function.
  feedObj.numfeeds = numfeed;
  
  // Ajax for filling news feed.
  var xmlhttp = new XMLHttpRequest();
  
  xmlhttp.onreadystatechange = function () 
  {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	{	  
	  // Once response is received put it's contents into newsfeed div and set mark feedObj as being populated.
	  document.getElementById("newsfeed").innerHTML = xmlhttp.responseText;
	  feedObj.feedPopulated = true;
	  
	  // Sets the function to be called again in (2nd param) milliseconds.
      setTimeout("updateFeed(" + userID + ")", 5000);
	}
  }
  
  xmlhttp.open("GET", "getNewsfeed.php?userID=" + userID + "&numfeed=" + numfeed, true);
  xmlhttp.send();
}

/*********************************
*	updateFeed(userID)
*	requirements: Must be a div on the page which has already been populated with updates.
*	actions: Fills the updates table with any updates that have come about since the table was last filled.
*********************************/
function updateFeed(userID) {
  if(feedObj.feedPopulated == true) {
    var xmlhttp = new XMLHttpRequest();
  
	xmlhttp.onreadystatechange = function () 
    {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	  {	
	    // New set has been successfully received. Remove the input element marking the date of the latest update. 
        document.getElementById("updateTable").childNodes[0].removeChild(document.getElementById("updateTable").childNodes[0].firstChild);
		// Add feed to top of update table including new latest update marker.
	    document.getElementById("updateTable").childNodes[0].innerHTML = xmlhttp.responseText + document.getElementById("updateTable").childNodes[0].innerHTML;
	  
	    // Sets the function to be called again in (2nd param) milliseconds.
        setTimeout("updateFeed(" + userID + ")", 5000);
	  }
    }
	
	//	Check to see if the tbody of updateTable has any rows.
	if(document.getElementById("updateTable").childNodes[0].childNodes[0] != null)
	{
	  //  Table has rows. Set feedObj.topEntryDate to the update date of input element marking the date of the latest update.
	  feedObj.topEntryDate = document.getElementById("updateTable").childNodes[0].firstChild.childNodes[0].childNodes[0].getAttribute("value");
	}  else {
	  //  Table has no rows. Just set feedObj.topEntryDate to absurdly early date so that the search will search the entire sfupdate table for updates.
	  feedObj.topEntryDate = "1980-00-00 00:00:00";
	}
	
	xmlhttp.open("GET", "updateFeed.php?userID=" + userID + "&topEntryDate=" + feedObj.topEntryDate, true);
    xmlhttp.send();
  }
}  

/*********************************
*	expandFeed(userID)
*	requirements: Must be a div on the page which has already been populated with updates.
*	actions: Fills the updates table with more updates beyond the earliest one in the user's feed.
*********************************/
function expandFeed(userID) {
  if(feedObj.feedPopulated == true) {	//	Sanity check to make sure divs we are expecting to be there will be there.
    var xmlhttp = new XMLHttpRequest();
  
	xmlhttp.onreadystatechange = function () 
    {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	  {	
        //	Remove the input element which contains the date of the earliest update from the table.	  
	    document.getElementById("updateTable").childNodes[0].removeChild(document.getElementById("updateTable").childNodes[0].lastChild);
		//	Insert the new data from expandFeed.php into the table including a new input element containing the new date of the earliest update in the feed.
	    document.getElementById("updateTable").childNodes[0].innerHTML = document.getElementById("updateTable").childNodes[0].innerHTML + xmlhttp.responseText;
	  }
    }
	
	//	Check to see if the tbody of updateTable has any rows.
	if(document.getElementById("updateTable").childNodes[0].childNodes[0] != null)
	{	  
	  //  Table has rows. Set feedObj.lowestEntryDate to the date in input element marker at end of table containing date of earliest update.
	  feedObj.lowestEntryDate = document.getElementById("updateTable").childNodes[0].lastChild.childNodes[0].childNodes[0].getAttribute("value");
	}  else {
	  //  Table has no rows. Just set feedObj.lowestEntryDate to future so that the search will search the entire sfupdate table for updates
	  feedObj.lowestEntryDate = "3000-00-00 00:00:00";
	}
	
	xmlhttp.open("GET", "expandFeed.php?userID=" + userID + "&lowestEntryDate=" + feedObj.lowestEntryDate + "&numfeed=" + feedObj.numfeeds, true);
    xmlhttp.send();
  }
}  

/*********************************
*	postNews(courseID, update)
*	requirements: Please make sure update actually contains something.
*	actions: Enters update into the sfupdates table under courseID.
*********************************/
function postNews(courseID, update) {
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.open("GET", "postNews.php?courseID=" + courseID + "&update=" + update, true);
  xmlhttp.send();
}

/**********************************
*	feedObj
*	Encapsulates all necessary data for the feed.
***********************************/
feedObj = new Object();
feedObj.currTimeOut = 0;
feedObj.topEntryDate;
feedObj.lowestEntryDate;
feedObj.feedPopulated = false;
feedObj.numfeeds;


/*********************************
*	END NEWSFEED FUNCTIONS
*********************************/


/*********************************
*	CALENDAR FUNCTIONS
*********************************/
/*********************************
*	setWidgetDblClick(targetView)
*	Action: Sets the widgets in div of class
*	fc-view-(tarvetView) to show eventdialog
*	on double click;
*********************************/
function setWidgetDblClick(targetView) {
  $("div.fc-view-" + targetView + " td.fc-widget-content").dblclick(function() {
	if(!$(this).hasClass('fc-other-month')) {
      eventDialog($('#calendar').fullCalendar('getDate') , function(response) {
        // do something with response
      });
    }
  });
}
