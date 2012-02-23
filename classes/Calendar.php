<?php
  class Calendar {
    public static function makeCalScript($id) {
    // Calendar-specific <head> elements here
      $evt = Event::getEvents($id);
      $x = "	
	    <script type='text/javascript' src='scripts/fullcalendar.js'></script>
      <script type='text/javascript'>
	      $(document).ready(function() {
        // page is now ready, initialize the calendar...
	      $('#calendar').fullCalendar({
          header: {
            left: 'month,agendaWeek,agendaDay',
            center: 'title'
            },
            events: {$evt},
            dayClick: function( date, allDay, jsEvent, view ) {
							newEvent(date, function(response) {
								// do something with response
								
							});
            },
            eventRender: function(event, element) {
              element.qtip({
                content: event.description,
                position: {
                  my: 'bottom left',
                  at: 'top left'
                }
              });
            },
            editable: true,
            eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
              alert(event.id + ' ' + event.start);
              var url = 'calendar.php?id=' + event.id + '&day=' + dayDelta + '&min=' +minuteDelta;
              $.ajax({url: url, dataType: 'json'});
            }
          })	
        });
      </script>";
      echo $x;
    }

    public static function makeCalDiv() {
      $x = "
       <div id='calendarWrap'>
        <div id='calendar'></div>
       </div>
      ";
      echo $x;
    }
  }
?>
