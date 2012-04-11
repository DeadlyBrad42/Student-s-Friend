<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . "sf/classes/User.php";
	require_once($path);
  // Put all pertinent head-level styles & javascript here, it will save space/sanity in the long run
 	$user = new User($_SESSION['userID']); 
  include($_SERVER['DOCUMENT_ROOT']."sf/scripts/utility.php");
  updateCourses($_SESSION['userID']);
  
  // For now, we're keeping the jquery.custom and qtip as global <head> includes, but we may find that those
  // are only pertinent for the Calendar, in which case we'll move them into the Calendar
  // class
  $crs = isset($_SESSION['courses']) ? $_SESSION['courses'] : "[{'name':'Add'}]";
  global $user;
  switch ($user->get_userType())
	{
		case 0 :
			$type = "Administrator";
			break;
		case 1 :
			$type = "Instructor";
			break;
		default :
			$type = "Student";
			break;
	}
  
  echo  
  "
  <meta http-equiv='cache-control' content='no-cache' />
  <meta http-equiv='X-UA-Compatible' content='IE=9' />
  <link rel='stylesheet' type='text/css' href='styles/default.css' />
  <link rel='stylesheet' type='text/css' href='styles/newsfeed.css' />
	<link rel='stylesheet' type='text/css' href='styles/fullcalendar.css' />
	<link rel='stylesheet' type='text/css' href='styles/qtip.css' />
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
  <script type='text/javascript' src='scripts/jquery-ui-1.8.17.custom.min.js'></script>
  <script src='scripts/jquery.quickflip.source.js' type='text/javascript'></script>
  <script type='text/javascript' src='scripts/flipFuncs.js'></script>
  <script type='text/javascript' src='scripts/jsFuncs.js'></script>
  <script type='text/javascript' src='scripts/qtip.min.js'></script>
  <script type='text/javascript'>
      $(document).ready(function() {  
        var x = {$crs};  
        populateCourses(x);
        // Utilise delegate so we don't have to rebind for every qTip!
        $(document).delegate('.qtip.jgrowl', 'mouseenter mouseleave', timer); 
        $('img#profilePic').qtip({
        		content: { 
        			title: '".$user->get_fname()." ".$user->get_lname()."',
        			text: 'Logged in as&#58; {$type}'
        			},
						position: {
							my: 'right center', 
							at: 'left center' 
						},
						style: {
							tip: true,
							classes: 'ui-tooltip-tipped'
						}
        	});
      });
  </script>
  ";
?>
