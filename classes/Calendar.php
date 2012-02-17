<?php
  class Calendar {
    
    public static function makeCalScript() {
      $x = "	
      <script>
	      $(document).ready(function() {
        // page is now ready, initialize the calendar...
	      $('#calendar').fullCalendar({
          header: {
            left: 'month,agendaWeek,agendaDay',
            center: 'title'},

            dayClick: function() {
                  alert('a day has been clicked!');
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
