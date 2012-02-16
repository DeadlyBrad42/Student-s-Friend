<?php
  // Put all pertinent head-level javascript here, it will save space/sanity in the long run

  $crs = isset($_SESSION['courses']) ? $_SESSION['courses'] : "[{'name':'Add'}]"; 
  echo 
  "
  <script type='text/javascript'>
      $(document).ready(function() {  
        var x = {$crs};  
        populateCourses(x);
      });
  </script>
  ";

?>
