<?php
  class Calendar {
    public static function makeCalScript($id) {
      $evt = Event::getEvents($id);
      //printf("Event: %s\n", $evt);
    // Calendar-specific <head> elements here
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
            dayClick: function() {
              //alert('a day has been clicked!');
              //$(this).append('<button id=\"addEvent\">Add</button>');
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
            editable: true
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
