function logout(token)
{
  window.location = "https://www.facebook.com/logout.php?next=http://localhost/sf/main.php&access_token=" + token;
}

function populateCourses(crs)
{
  var list = $('li#courses');
  var ul = $('<ul />',{id:'crsMenu'});
  var url;
  for(var i = 0; i < crs.length; i++)
  {
   	var li = $('<li />');
   	url = (crs[i].name == 'Add') ? 'courseAdd.php' : 'courses.php?c='+crs[i].id;
   	var a = $('<a />',{href: url, text: crs[i].name});
    li.append(a);
    ul.append(li);
  }
  list.append(ul);
}

function dialogue(id, content, title, blur) {
  $('<div />').qtip(
  {
    id: id,
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
      solo: true, // Hide all other tips when this pops up
      modal: {
        on: true, // Make it modal (darken the rest of the page)...
        blur: blur // parameter will decide whether to let user click out of form
      }
    },
    hide: false, // We'll hide it maunally so disable hide events
    style: 'ui-tooltip-light ui-tooltip-rounded ui-tooltip-dialogue', // Add a few styles
    events: {
      render: function(event, api) {
        // We'll be hiding our tooltips manually on a close-button to close-button basis
      },
      // Destroy the tooltip once it's hidden as we no longer need it!
      hide: function(event, api) { api.destroy(); }
    }
  });
}

// Dynamically Builds and Shows the add event Dialogue
function eventDialogue(date, course_id)
{
  var isRecur=false;
  var isPM=false;
  var clickedTime;
  var div = $('<div />', {id: 'evtAddForm'});
  var tbl = $('<table />', {id: 'evtAddTbl'});
  var labels = ['<td>Title:</td>','<td>Start Date:</td>', '<td>End Date:</td>', '<td>Start Time:</td>', 
                '<td>End Time:</td>', '<td>Location:</td>', '<td>Description:</td>', '<td>Recurrence:</td>'];
  var clickedDate = (date.getMonth()+1) + "-" + date.getDate() + "-" + date.getFullYear();
  if (date.getHours() > 12)
	{
		isPM=true;
  	clickedTime = date.getHours()-12 + ":" + (date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes());
	}
	else
  	clickedTime = (date.getHours() < 10 ? '0'+date.getHours() : date.getHours()) + ":" 
  	+ (date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes());

	clickedTime = (clickedTime == "00:00") ? "12:00" : clickedTime;  
  var inp = new Array(); 
  inp[0] = $('<input />', {id: 'evtTitle', name: 'evtTitle', type: 'text', val: ''});
  inp[1] = $('<input />', {id: 'evtStartDt', name: 'evtStartDt', type: 'text', val: clickedDate, disabled: 'disabled'});
  inp[2] = $('<input />', {id: 'evtEndDt', name: 'evtEndDt', type: 'text', val: clickedDate, disabled: 'disabled'});
  inp[3] = $('<select />', {id: 'evtStartTi', name: 'evtStartTi'});
  inp[4] = $('<select />', {id: 'evtEndTi', name: 'evtEndTi'});
  inp[5] = $('<input />', {id: 'evtLocation', name: 'evtLocation', type: 'text', val: '' })
  inp[6] = $('<input />', {id: 'evtDescrip', name: 'evtDescrip', type: 'text', val: '' });
  inp[7] = $('<input />', {id: 'evtRecur', name: 'evtRecur', type: 'checkbox', val: 'yes', click: function() {
      if ($(this).is(':checked'))
      {
        $('tr#recRow').css('display','table-row');
        isRecur = true;
      }
      else
      {
        $('tr#recRow').css('display','none');
        isRecur = false;
      }
      
    } 
  });

	$(document).delegate($('#evtStartDt'),'change',function() {
			if ($('.evtAMPM:eq(0) option:selected').text() == 'PM' && $('.evtAMPM:eq(1) option:selected').text() == 'AM')
			{
				var newd = (date.getMonth()+1) + "-" + (date.getDate()+1) + "-" + date.getFullYear();
				$('#evtEndDt').val(newd);
			}
			else
			{
				$('#evtEndDt').val(clickedDate);
			}
		});
	$(document).delegate($('#evtEndDt'),'change',function() {
			if ($('.evtAMPM:eq(0) option:selected').text() == 'PM' && $('.evtAMPM:eq(1) option:selected').text() == 'AM')
			{
				var newd = (date.getMonth()+1) + "-" + (date.getDate()+1) + "-" + date.getFullYear();
				$('#evtEndDt').val(newd);
			}
			else
			{
				$('#evtEndDt').val(clickedDate);
			}
		});
	for (var i=1; i<13; i++)
	{
		inp[3].append('<option>'+(i < 10 ? "0" + i : i)+'</option>');
		inp[4].append('<option>'+(i < 10 ? "0" + i : i)+'</option>');
	}

	var minSelect1 = $('<select />',{id: 'minS1'});
	var minSelect2 = $('<select />',{id: 'minS2'});
	minSelect1.append('<option>00<option');
	minSelect1.append('<option>30<option');
	minSelect2.append('<option>00<option');
	minSelect2.append('<option>30<option');
  recurList = $('<ul />', {id: 'recurList'}),
  recurD = $('<input />', {id: 'recurDaily', type: 'radio', name: 'recur', val: 'Daily', checked: true}),
  recurW = $('<input />', {id: 'recurWeekly', type: 'radio', name: 'recur', val: 'Weekly'})
  recurM = $('<input />', {id: 'recurMonthly', type: 'radio', name: 'recur', val: 'Monthly'})
  recurY = $('<input />', {id: 'recurYearly', type: 'radio', name: 'recur', val: 'Yearly'});
  
  
  recurList.append($('<li />').append(recurD).append('Daily'))
           .append($('<li />').append(recurW).append('Weekly'))
           .append($('<li />').append(recurM).append('Monthly'))
           .append($('<li />').append(recurY).append('Yearly'));

  saveBtn = $('<button />', {text: 'Save', click: function() {
      if (validate('#evtAddForm input'))
      {
        isRecur ? addEvent($('input[name="recur"]:checked').attr('value'), course_id) : addEvent('none', course_id);
        $('#ui-tooltip-evtModal').qtip('hide');
      }
      else
      {
        $('div#infoLbl').css({display :'block', color: 'red'}).html('Issue with the form!');
      }
    } 
  }),
  cancelBtn = $('<button />', {text: 'Cancel', click: function() {$('#ui-tooltip-evtModal').qtip('hide');} });
  
  for (var i=0; i < labels.length; i++)
  {
    if (i == 3)
		{
  		var amPmSelect = $('<select />',{class: 'evtAMPM', name: 'evtAMPM'});
  		amPmSelect.append($('<option />',{val: 'am', text: 'AM'})).append($('<option />',{val: 'pm', text: 'PM'}));
			if (isPM) {amPmSelect.prop('selectedIndex', 1);}
    	var row = $('<tr />').append(labels[i]).append($('<td />').append(inp[i]).append(minSelect1).append(amPmSelect));
		}
		else if (i == 4)
		{
  		var amPmSelect = $('<select />',{class: 'evtAMPM', name: 'evtAMPM'});
  		amPmSelect.append($('<option />',{val: 'am', text: 'AM'})).append($('<option />',{val: 'pm', text: 'PM'}));
			if (isPM) {amPmSelect.prop('selectedIndex', 1);}
    	var row = $('<tr />').append(labels[i]).append($('<td />').append(inp[i]).append(minSelect2).append(amPmSelect));
			
		}
		else
    	var row = $('<tr />').append(labels[i]).append($('<td />').append(inp[i]));

    tbl.append(row);
  }
  
  tbl.append($('<tr />', {id: 'recRow'}).append('<td />').append($('<td />').append(recurList)));
  div.append(tbl);
  div.append(saveBtn).append(cancelBtn).append($('<div />', {id: 'infoLbl'}));
  dialogue('evtModal', div, 'New Event', false);
}

// simple validation function, just pass in the jquery selector string
function validate(element)
{
  var ok = true;
  $.each($(element),function(index)
  {
    //console.log($(this).attr('value'));
    if ($(this).attr('value') == null || $(this).attr('value') == '')
    {
      ok = false;
    }
  });
  return ok;
}

// Takes an array of inputs and processes their values
function addEvent(recurrence, course_id)
{
  // PHP's json_decode() is expecting a string of json, so we need to
  // do a join on the array and send it as a string.
	var sTime = $('#evtStartTi option:selected').text()+':'+$('#minS1 option:selected').text()+' '
							+$('.evtAMPM:eq(0) option:selected').text();
	var eTime = $('#evtEndTi option:selected').text()+':'+$('#minS2 option:selected').text()+' '
							+$('.evtAMPM:eq(1) option:selected').text();
  var event = [
    '"name":', '"'+$('#evtTitle').attr('value')+'",',
    '"sDate":', '"'+$('#evtStartDt').attr('value')+'",',
    '"eDate":', '"'+$('#evtEndDt').attr('value')+'",',
    '"sTime":', '"'+sTime+'",',
    '"eTime":', '"'+eTime+'",',
    '"loc":', '"'+$('#evtLocation').attr('value')+'",',
    '"descrip":', '"'+$('#evtDescrip').attr('value')+'",',
    '"isRecur":', recurrence != 'none' ? '"'+recurrence+'"' : '"false"'  
    ];
  
  var jsonStr = event.join('');
 
  var url = 'calendar.php?add=true' + '&event=' + jsonStr + '&courseID=' + course_id;
  $.ajax({
  	url: url, 
  	dataType: 'html', 
  	success: function(object) {
    	console.log(object);
    	$('#calendar').fullCalendar('refetchEvents');
    	$('.addTip').qtip('hide');
	}
  });
}

function viewEvent(s, e, d, t, l)
{
  var tbl = $('<table />',{id: 'viewEvt'});
  var txt1 = ["<td>Title:</td>", "<td>Start:</td>", "<td>End:</td>", "<td>Description:</td>", "<td>Location:</td>"];
  var txt2 = [t,s,e,d,l];
  for (var i = 0; i < txt1.length; i++)
  {
    tbl.append($('<tr />').append(txt1[i]).append($('<td />').append(txt2[i])));
  }
  dialogue('viewEvtModal', tbl, 'Event: View', true);
}

function deleteEvent(evtID)
{
  var div = $('<div />'),
      btnY = $('<input />', {type: 'button', val: 'Yes', click: function() {
        $('#ui-tooltip-deleteEvtConfirm').qtip('hide'); 
        var url = 'calendar.php?delete=true' + '&eventid=' + evtID;
        $.ajax({
        	url: url,
        	success: function(data) {
          	$('#calendar').fullCalendar('refetchEvents');
          }
        });
      }
      }),
      btnN = $('<input />', {type: 'button', val: 'No', click: function() {$('#ui-tooltip-deleteEvtConfirm').qtip('hide');} });

  div.html("Are you sure you want to permanently delete this event?<br />").append(btnY).append(btnN);
  dialogue('deleteEvtConfirm', div, 'Event: Deletion', false);
}

function uploadFile(isCrs, id)
{
  var form = $(document.createElement('form'));
  var actionUrl = isCrs == 1 ? 'scripts/upload.php?cid='+id : 'scripts/upload.php'; 
  var errLbl = $('<span />', {id: 'infoLbl'}); 
  form.attr({enctype: 'multipart/form-data', action: actionUrl, method: 'post', target: 'uploadFrame', onsubmit: 'toggleAjaxLoader(1);'});

  var input = $('<input />', {type: 'file', name: 'file', id: 'file'}),
      upload_btn = $('<input />', {val: 'Upload', name: 'Upload', type: 'Submit', click: function() {
        if ($('input#file').val() == null || $('input#file').val() == undefined || $('input#file').val() == '')
				{
					$('span#infoLbl').css({display :'block', color: 'red'}).html('You must select a file!');
					return false;
				}
        $('#ui-tooltip-uploadModal').css('display', 'none');
        $('#qtip-overlay').css('display', 'none');
        }
      }),
      cncl_btn = $('<input />', {val: 'Cancel', type: 'button', click: function() { $('#ui-tooltip-uploadModal').qtip('hide'); } });
  form.append(input).append(upload_btn).append(cncl_btn).append(errLbl);
  dialogue('uploadModal', form, 'Upload A New File', true);
}

function destroyUpTip()
{
  $('#ui-tooltip-uploadModal').qtip('destroy');
}

function showUploadPic(src, name)
{
  var box = $('<div />', {id: 'imgBox'}),
      img = $('<img />', {src: src, width: '500', height: '500'})
      btn = $('<button />', {text: 'Close', click: function() {$('#ui-tooltip-picModal').qtip('hide');} });

  box.append(img).append(btn);
  dialogue('picModal', box, name, true);
}


function deleteStorageDialogue(sid, id, isCrs)
{
	var box = $('<div />', {id: 'deleteStorageBox'}),
			btn1 = $('<button />', {text: 'Yes', click: function() { 
				$('#ui-tooltip-deleteStoreModal').qtip('hide');
				deleteStorageItem(sid, id, isCrs);} 
			}),
			btn2 = $('<button />', {text: 'No', click: function() { $('#ui-tooltip-deleteStoreModal').qtip('hide');} });

	box.append(btn1).append(btn2);
	dialogue('deleteStoreModal', box, "Are you sure you want to delete this item?", false);
}

function approveStorageDialogue(sid)
{
	var box = $('<div />', {id: 'approveStorageBox'}),
			btn1 = $('<button />', {text: 'Yes', click: function() { 
				$('#ui-tooltip-approveStoreModal').qtip('hide');
				approveStorageItem(sid);} 
			}),
			btn2 = $('<button />', {text: 'No', click: function() { $('#ui-tooltip-approveStoreModal').qtip('hide');} });

	box.append(btn1).append(btn2);
	dialogue('approveStoreModal', box, "Are you sure you want to approve this item?", false);
}

function deleteStorageItem(sid, id, isCrs)
{
	toggleAjaxLoader(1);
	if (isCrs == 1)
	{
		var url = 'scripts/utility.php?action=deleteStorage&storeID='+sid+'&id='+id+'&isCrs=1';
		$.ajax({url: url, dataType: 'html', success: function() { 
			switchCrsView(1); 
			toastMessage("Item successfully deleted!");
			toggleAjaxLoader(0);
			}
		});
	}
	else
	{
		var url = 'scripts/utility.php?action=deleteStorage&storeID='+sid+'&id='+id+'&isCrs=0';
		$.ajax({url: url, dataType: 'html', success: function(html) {	
				$('div#uploadContent').html(html);
				toastMessage("Item successfully deleted!");
				toggleAjaxLoader(0);
			}
		});
	}
}

function approveStorageItem(sid)
{
	toggleAjaxLoader(1);
	var url = 'scripts/utility.php?action=approveStorage&storeID='+sid;
	$.ajax({url: url, dataType: 'html', success: function() {
		switchCrsView(1);
		toastMessage("Item has been approved and is viewable by the whole class!");
		toggleAjaxLoader(0);
		}
	});
}

function switchCrsView(i)
{
	var hash;
	switch(i)
	{
		case 0 :
			hash = '#cal';
			break;
		case 1 :
			hash = '#store';
			break;
		case 2 :
			hash = '#forum';
			break;
		case 3 :
			hash = '#card';
			break;
		case 4 :
			hash = '#manage';
			break;
	}
  var url = document.location.href + '&view=' + i + hash;
  $.ajax({url: url, dataType: 'html', success: function(html) {
      $('div#crsContent').html(html);
      toggleAjaxLoader(0); // if loader is showing, hide it
      url = url + hash;
    }
  });
}

window.toggleAjaxLoader = function(option)
{
  // Option is a number, where 1 is showing and 0 is not showing
  if (option == 1)
  {
    $('div#ajaxLoader').css('display', 'block');
  }
  else
  {
    $('div#ajaxLoader').css('display', 'none');
  }
  
}

function ajaxLoad(target, url)
{
  console.log("in ajax load");
  $(target).load(url, function() {
    toggleAjaxLoader(0);
  });
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
  
  var url = "getNewsfeed.php?userID=" + userID + "&numfeed=" + numfeed;
  
  $.ajax({
	  url: url, 
	  success: function(data) {
        // Once response is received put it's contents into newsfeed div and set mark feedObj as being populated.
	  document.getElementById("newsfeed").innerHTML = data;
	  feedObj.feedPopulated = true;
	  
	  // Sets the function to be called again in (2nd param) milliseconds.
      setTimeout("updateFeed(" + userID + ")", feedObj.currTimeOut);
	  }
	})
}

/*********************************
*	updateFeed(userID)
*	requirements: Must be a div on the page which has already been populated with updates.
*	actions: Fills the updates table with any updates that have come about since the table was last filled.
*********************************/
function updateFeed(userID) {
  if(feedObj.feedPopulated == true) {
	//	Check to see if the tbody of updateTable has any rows.
	if(document.getElementById("updateTable").childNodes[0].childNodes[0] != null)
	{
	  //  Table has rows. Set feedObj.topEntryDate to the update date of input element marking the date of the latest update.
	  feedObj.topEntryDate = document.getElementById("updateTable").childNodes[0].firstChild.childNodes[0].childNodes[0].getAttribute("value");
	}  else {
	  //  Table has no rows. Just set feedObj.topEntryDate to absurdly early date so that the search will search the entire sfupdate table for updates.
	  feedObj.topEntryDate = "1980-00-00 00:00:00";
	}
	
	var url = "updateFeed.php?userID=" + userID + "&topEntryDate=" + feedObj.topEntryDate;
	
	$.ajax({
	  url: url, 
	  success: function(data) {
        // New set has been successfully received. Remove the input element marking the date of the latest update. 
        document.getElementById("updateTable").childNodes[0].removeChild(document.getElementById("updateTable").childNodes[0].firstChild);
		// Add feed to top of update table including new latest update marker.
	    document.getElementById("updateTable").childNodes[0].innerHTML = data + document.getElementById("updateTable").childNodes[0].innerHTML;
		
		// Sets the function to be called again in (2nd param) milliseconds.
        setTimeout("updateFeed(" + userID + ")", feedObj.currTimeOut);
	  }
	})
  }
}  

/*********************************
*	expandFeed(userID)
*	requirements: Must be a div on the page which has already been populated with updates.
*	actions: Fills the updates table with more updates beyond the earliest one in the user's feed.
*********************************/
function expandFeed(userID) {
  if(feedObj.feedPopulated == true) {	//	Sanity check to make sure divs we are expecting to be there will be there.
	
	//	Check to see if the tbody of updateTable has any rows.
	if(document.getElementById("updateTable").childNodes[0].childNodes[0] != null)
	{	  
	  //  Table has rows. Set feedObj.lowestEntryDate to the date in input element marker at end of table containing date of earliest update.
	  feedObj.lowestEntryDate = document.getElementById("updateTable").childNodes[0].lastChild.childNodes[0].childNodes[0].getAttribute("value");
	}  else {
	  //  Table has no rows. Just set feedObj.lowestEntryDate to future so that the search will search the entire sfupdate table for updates
	  feedObj.lowestEntryDate = "3000-00-00 00:00:00";
	}
	
	var url = "expandFeed.php?userID=" + userID + "&lowestEntryDate=" + feedObj.lowestEntryDate + "&numfeed=" + feedObj.numfeeds;
	
	$.ajax({
	  url: url, 
	  success: function(data) {
        //	Remove the input element which contains the date of the earliest update from the table.	  
	    document.getElementById("updateTable").childNodes[0].removeChild(document.getElementById("updateTable").childNodes[0].lastChild);
		//	Insert the new data from expandFeed.php into the table including a new input element containing the new date of the earliest update in the feed.
	    document.getElementById("updateTable").childNodes[0].innerHTML = document.getElementById("updateTable").childNodes[0].innerHTML + data;
	  }
	})
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
feedObj.currTimeOut = 5000;
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

/** Messaging functions and messaging helper functions **/
window.toastMessage = function(msg)
{
  var target = $('.qtip.jgrowl:visible:last');
  $(document.body).qtip({
    content: {
        title: {
          text: 'NOTICE',
          button: true
        },
        text: msg
    },
    position: {
      my: 'top right',
      at: (target.length ? 'bottom' : 'top') + ' right',
      target: target.length ? target : $(window),
      adjust: { y : 5 },
      effect: function(api, newPos) {
          // Animate as usual if the window element is the target
          $(this).animate(newPos, {
            duration: 200,
            queue: false
        });
      }
    },
    show: {
      event: false,
      ready: true,
      effect: function() {
        $(this).stop(0, 1).fadeIn(400);
      },
      delay: 0
    },
    hide: {
      event: false,
      // Don't hide it on a regular event
      effect: function(api) {
          // Do a regular fadeOut, but add some spice!
          $(this).stop(0, 1).fadeOut(400).queue(function() {
          // Destroy this tooltip after fading out
          api.destroy();
          updateGrowls();
          })
        }
      },
      style: {
        classes: 'jgrowl ui-tooltip-tipped ui-tooltip-rounded',
        // Some nice visual classes
        tip: false // No tips for this one (optional ofcourse)
      },
      events: {
        render: function(event, api) {
          timer.call(api.elements.tooltip, event);
        }
      }
  }).removeData('qtip');
}

// Make it a window property see we can call it outside via updateGrowls() at any point
window.updateGrowls = function() {
    // Loop over each jGrowl qTip
    var each = $('.qtip.jgrowl'),
        width = each.outerWidth(),
        height = each.outerHeight(),
        gap = each.eq(0).qtip('option', 'position.adjust.y'),
        pos;

    each.each(function(i) {
        var api = $(this).data('qtip');

        // Set target to window for first or calculate manually for subsequent growls
        api.options.position.target = !i ? $(window) : [
            pos.left + width, pos.top + (height * i) + Math.abs(gap * (i-1))
        ];
        api.set('position.at', 'top right');
        
        // If this is the first element, store its finak animation position
        // so we can calculate the position of subsequent growls above
        if(!i) { pos = api.cache.finalPos; }
    });
};

function timer(event) {
    var api = $(this).data('qtip'),
    lifespan = 5000; // 5 second lifespan

    // Otherwise, start/clear the timer depending on event type
    clearTimeout(api.timer);
    if (event.type !== 'mouseover') {
        api.timer = setTimeout(api.hide, lifespan);
    }
}

function processString(s){
	s=s.replace(/'/g,"");
	s=s.replace(/\+/g,"%2B");
	s=s.replace(/\&/g,"%26");
	s=s.replace(/\?/g,"%3F");
	s=s.replace(/\@/g,"%40");
	s=escape(s);
	//s=s.replace(/\"/g,"%22");
	return s;
}

function makeCrsLanding(list, target) {
	for(var i=0; i<(list.length-1); i++)
	{
		var tbl = $('<table />', {class: 'crsLanding'}),r1 = $('<th />'),
				r2 = $('<tr />'), d2 = $('<td />'), 
				r3 = $('<tr />'), d3 = $('<td />'),
				r4 = $('<tr />'), d4 = $('<td />'), 
				r5 = $('<tr />'), d5 = $('<td />');
		
		// Form the rows
		r1.append($('<a />', {text: list[i].name, href: 'courses.php?c='+list[i].id}));
		r2.append('<td>Description:</td>').append(d2.append(list[i].descrip)); 
		r3.append('<td>Location:</td>').append(d3.append(list[i].location));
		r4.append('<td>Time:</td>').append(d4.append(list[i].time));
		r5.append('<td>Instructor:</td>').append(d5.append(list[i].insFirst +' '+ list[i].insLast));

		// Append each row to the table
		tbl.append(r1).append(r2).append(r3).append(r4).append(r5);

		// Append each table to our target
		target.append(tbl);
	}
}
