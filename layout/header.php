<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . "sf/classes/User.php";
	require_once($path);
	
	$user = new User($_SESSION['userID']);
 
	$x = "<div id='headerWrap'>
          <div id='header'>
            <ul id='nav'>
              <li><a href='calendar.php'>Calendar</a></li>
              <li id='courses'><a href='courses.php'>Courses</a><div id='crsMenu'></div></li>";
			  
	if($user->get_userType() < 2) {
		$x = $x."<li><a href='coursebuilder.php'>Instructor Course Management</a></li>";
	}
			  
	$x = $x."<li><a href='courseAdd.php'>Enrollment Management</a></li>
			<li class='last'><a href='storage.php'>User Storage</a></li>
            </ul>
           <div id='headerRight'>
           <img id='profilePic' src='https://graph.facebook.com/".$_SESSION['userID']."/picture' />
          	<button id='logoutBtn' 
            	onclick='FB.logout(function(response){ 
              	if (response.authResponse) 
                	logout(response.authResponse.accessToken); 
              	});'>Log Out</button>
          </div>
          </div>
        </div>";
		
	echo $x;
?>
