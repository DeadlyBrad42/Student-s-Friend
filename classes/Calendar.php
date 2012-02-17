<?php
  class Calendar {
    
    public static function makeCalScript() {
      $x = "	
      <script type='text/javascript'>
	      $(document).ready(function() {
        // page is now ready, initialize the calendar...
	      $('#calendar').fullCalendar({
          header: {
            left: 'month,agendaWeek,agendaDay',
            center: 'title'
            },
            events: [
              {
                title: 'walker',
                start: '2012-02-16',
                end: '2012-02-17',
                description: 'Walker\'s class sucks'
              }
            ],
            dayClick: function() {
                  //alert('a day has been clicked!');
                  //$(this).html('you clicked me');
            },
            eventRender: function(event, element) {
              
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
