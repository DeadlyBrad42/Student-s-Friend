<?php 
  echo "<div id='headerWrap'>
          <div id='header'>
            <ul id='nav'>
              <li><a href='main.php'>Home</a></li>
              <li id='courses'><a href='courses.php'>Courses</a><div id='crsMenu'></div></li>
              <li><a href='storage.php'>User Storage</a></li>
              <li class='last'><a href='calendar.php'>Calendar</a></li>
            </ul>
          <button id='logoutBtn' 
            onclick='FB.logout(function(response){ 
              if (response.authResponse) 
                logout(response.authResponse.accessToken); 
              });'>Log Out</button>
          </div>
        </div>";
?>
