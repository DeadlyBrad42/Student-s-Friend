<?php
  // Put all pertinent head-level styles & javascript here, it will save space/sanity in the long run

  $crs = isset($_SESSION['courses']) ? $_SESSION['courses'] : "[{'name':'Add'}]"; 
  echo  
  "
  <meta http-equiv='cache-control' content='no-cache' />
  <meta http-equiv='X-UA-Compatible' content='IE=9' />
  <link rel='stylesheet' type='text/css' href='styles/default.css' />
	<link rel='stylesheet' type='text/css' href='styles/fullcalendar.css' />
	<link rel='stylesheet' type='text/css' href='styles/qtip.css' />
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
  <script type='text/javascript' src='scripts/jsFuncs.js'></script>
	<script type='text/javascript' src='scripts/fullcalendar.js'></script>
  <script type='text/javascript' src='scripts/qtip.min.js'></script>
  <script type='text/javascript'>
      $(document).ready(function() {  
        var x = {$crs};  
        populateCourses(x);
      });
  </script>
  ";

?>
