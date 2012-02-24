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
