<?php 
  echo "<div id='headerWrap'>
          <div id='header'>
            <ul id='nav'>
              <li><a href='#'>Home</a></li>
              <li><a href='#'>Courses</a></li>
              <li><a href='#'>User Storage</a></li>
              <li><a href='#'>Calendar</a></li>
            </ul>
          <button id='logoutBtn' 
            onclick='FB.logout(function(response){ 
              if (response.authResponse) 
                logout(response.authResponse.accessToken); 
              });'>Log Out</button>
          </div>
        </div>";
?>
