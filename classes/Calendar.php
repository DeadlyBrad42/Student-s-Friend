<?php
  require_once("Event.php");
  class Calendar {
    public static function makeCalScript($id) {
    // Calendar-specific <head> elements here
      $evt = Event::getEvents($id);
      $x = "	
      <script type='text/javascript' src='scripts/fullcalendar.js'></script>
	  
      <script type='text/javascript'>
	    var agendaWeekLoaded = false;
	    var agendaDayLoaded = false;
	  
        $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
          header: {
            left: 'month,agendaWeek,agendaDay',
            center: 'title'
            },
			
            events: {$evt},
			
            dayClick: function( date, allDay, jsEvent, view ) {
			  // If this is a day of another month changing current day to that day will change view. That's totally not cool.
			  if(!$(this).hasClass('fc-other-month')) {
			    $('#calendar').fullCalendar('gotoDate', date);
			  }
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
              var url = 'calendar.php?id=' + event.id + '&day=' + dayDelta + '&min=' + minuteDelta;
              $.ajax({url: url, dataType: 'json'});
            },
			 
            eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
              var url = 'calendar.php?id=' + event.id + '&day=' + dayDelta + '&min=' + minuteDelta + '&re=' + 1;
              $.ajax({url: url, dataType: 'json'});
            },
			
			//	Elements aren't added until view is changed so we need to check to see if widgets need funcs added. 	
			viewDisplay: function(view) {
			  if((view.name == 'agendaWeek') && (agendaWeekLoaded == false)) {  
			    // We're in agendaWeek mode for first time so set the new widget's double click function
			    agendaWeekLoaded = true;
				setWidgetDblClick('agendaWeek');
			  } else
			  if((view.name == 'agendaDay') && (agendaDayLoaded == false)) {
			    // We're in agendaDay mode for first time so set the new widget's double click function
			    agendaDayLoaded = true;
				setWidgetDblClick('agendaDay');
			  }
			}
          })
  
          // Calendar automatically loads into month view so set it's widgets now.
          setWidgetDblClick('month');		  
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
