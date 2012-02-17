<?php 
  session_start(); 
  if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
    header("Location: index.php");
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" type="text/css" href="styles/default.css" />
	<link rel='stylesheet' type='text/css' href='styles/fullcalendar.css' />
  <script type="text/javascript" src="scripts/jquery.js"></script>
  <script type="text/javascript" src="scripts/jsFuncs.js"></script>
	<script type='text/javascript' src="scripts/fullcalendar.js"></script>
	<?php require_once("layout/headScripts.php"); ?>
	
	<!-- Script for preparing the calendar -->
	<script>
	  $(document).ready(function() {
    // page is now ready, initialize the calendar...
	  $('#calendar').fullCalendar({
	    header: {
		  left: 'month,agendaWeek,agendaDay',
		  center: 'title'
		},
		
		dayClick: function() {
		  alert('a day has been clicked!');
		}
	  })	
	});
	  </script>
  </head>
  <body>
    <div id="fb-root">
      <script type="text/javascript">
        window.fbAsyncInit = function() {
          FB.init({ appId: '346560865373540', status: true, cookie: true, xfbml: true });
          FB.Event.subscribe("auth.logout", function() { window.location = "index.php?logout=true"; });
        };
        
        (function() {
          var e = document.createElement('script');
          e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
          e.async = true;
          document.getElementsByTagName('head')[0].appendChild(e);
        }());
      </script>
    </div>
	
    <?php require_once("layout/header.php"); ?>
	  <div id="wrapper">
      <div id="calendarWrap">
	      <!-- Calendar div. This is where fullcalendar places it's calendar. -->
        <div id='calendar'></div>
      </div>
    </div>
    <?php require_once("layout/footer.php"); ?>
  
  </body>
</html>
