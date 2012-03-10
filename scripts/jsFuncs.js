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
  /* 
   * Since the dialogue isn't really a tooltip as such, we'll use a dummy
   * out-of-DOM element as our target instead of an actual element like document.body
   */
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
function eventDialog(date, callback)
{
  var clickedDate = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
  var clickedTime =
    (date.getHours() < 10 ? "0" + date.getHours() : date.getHours()) + ":" +
    (date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes());
  
  // Content will consist of a question elem and input, with ok/cancel buttons
  var title_msg = $('<p />', { text: 'Title of event' }),
      title_tbx = $('<input />', { val: '' }),
      startdt_msg = $('<p />', { text: 'Start date' }),
      startdt_tbx = $('<input />', { val: clickedDate }),
      enddt_msg = $('<p />', { text: 'End date' }),
      enddt_tbx = $('<input />', { val: clickedDate }),
      startti_msg = $('<p />', { text: 'Start Time' }),
      startti_tbx = $('<input />', { val: clickedTime }),
      endti_msg = $('<p />', { text: 'End Time' }),
      endti_tbx = $('<input />', { val: clickedTime }),
      lctn_msg = $('<p />', { text: 'Location' }),
      lctn_tbx = $('<input />', { val: '' }),
      desc_msg = $('<p />', { text: 'Description' }),
      desc_tbx = $('<input />', { val: '' }),
      save_btn = $('<button />', {text: 'Save', click: function() {callback( input.val() );} }),
      cncl_btn = $('<button />', {text: 'Cancel', click: function() { callback(null); } });

  dialogue(
    title_msg.add(title_tbx)
    .add(startdt_msg).add(startdt_tbx)
    .add(enddt_msg).add(enddt_tbx)
    .add(startti_msg).add(startti_tbx)
    .add(endti_msg).add(endti_tbx)
    .add(lctn_msg).add(lctn_tbx)
    .add(desc_msg).add(desc_tbx)
    .add(save_btn).add(cncl_btn),
    'New Event' );
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
	  document.getElementById("newsfeed").innerHTML = xmlhttp.responseText;
	  
	  feedObj.feedPopulated = true;
	  
	  // Sets the function to be called again in (2nd param) milliseconds.
      setTimeout("updateFeed(" + userID + ")", 5000);
	}
  }
  
  xmlhttp.open("GET", "getNewsfeed.php?userID=" + userID + "&numfeed=" + numfeed, true);
  xmlhttp.send();
}

function updateFeed(userID) {
  if(feedObj.feedPopulated == true) {
    var xmlhttp = new XMLHttpRequest();
  
	xmlhttp.onreadystatechange = function () 
    {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	  {		
	    document.getElementById("updateTable").childNodes[0].innerHTML = xmlhttp.responseText + document.getElementById("updateTable").childNodes[0].innerHTML;
	  
	    // Sets the function to be called again in (2nd param) milliseconds.
        setTimeout("updateFeed(" + userID + ")", 5000);
	  }
    }
	
	//	Check to see if the tbody of updateTable has any rows.
	if(document.getElementById("updateTable").childNodes[0].childNodes[0] != null)
	{
	  //  Table has rows. Set feedObj.lastUpdateID to the update_ID of the most recent update.
	  feedObj.lastUpdateID = document.getElementById("updateTable").childNodes[0].childNodes[0].getAttribute("char");
	}  else {
	  //  Table has no rows. Just set feedObj.lastUpdateID to 0 so that the search will search the entire table for updates
	  feedObj.lastUpdateID = 0;
	}
	
	
	xmlhttp.open("GET", "updateFeed.php?userID=" + userID + "&lastUpdateID=" + feedObj.lastUpdateID, true);
    xmlhttp.send();
  }
}  

function expandFeed(userID) {
  if(feedObj.feedPopulated == true) {	//	Sanity check to make sure divs we are expecting to be there will be there.
    var xmlhttp = new XMLHttpRequest();
  
	xmlhttp.onreadystatechange = function () 
    {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	  {		
	    document.getElementById("updateTable").childNodes[0].innerHTML = document.getElementById("updateTable").childNodes[0].innerHTML + xmlhttp.responseText;
	  }
    }
	
	//	Check to see if the tbody of updateTable has any rows.
	if(document.getElementById("updateTable").childNodes[0].childNodes[0] != null)
	{	  
	  //  Table has rows. Set feedObj.firstUpdateID to the update_ID of the most recent update.
	  feedObj.firstUpdateID = document.getElementById("updateTable").childNodes[0].lastChild.getAttribute("char");
	}  else {
	  //  Table has no rows. Just set feedObj.firstUpdateID to 0 so that the search will search the entire table for updates
	  feedObj.firstUpdateID = -1;
	}
	
	xmlhttp.open("GET", "expandFeed.php?userID=" + userID + "&firstUpdateID=" + feedObj.firstUpdateID + "&numfeed=" + feedObj.numfeeds, true);
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
feedObj.lastUpdateID;
feedObj.firstUpdateID;
feedObj.feedPopulated = false;
feedObj.numfeeds;

