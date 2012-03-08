<?php
  require_once("NewsFeed.php");
  session_start();
  
  $id = $_SESSION['userID'];
?>
  
  <!DOCTYPE html>
  <html>
    <head>
	  <title>newsfeed test page</title>
	  
	  <?php require_once("layout/headScripts.php"); ?>
	  
	  <script>
	    function check_status() {
		  //document.getElementById("errorLog").innerHTML += "Entered check_status";  //Debug
		
		  if(document.getElementById("update").value != "") {
		    //document.getElementById("errorLog").innerHTML += "Entered check_status if";	//Debug
		    postNews(9, document.getElementById("update").value);
		  }
		}
	  </script>
	</head>
    <body> 
	  <div id="newsfeed">
	  </div>
	  
	  <div>
	    <p>Status update</p>
	    <textarea id = 'update' name='content' rows='5' cols='35'></textarea>
		<button type="button" onclick="check_status()">Post Update</button>
	  </div>
	  
	  <!--<p id="errorLog">Errors here</p>  --> <!-- Debug -->
	  
	  <script type="text/javascript">
	    populate_newsfeed(<?php echo $id ?>, 10);
	  </script>
	</body>
  </html>
