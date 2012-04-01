<?php
	require_once("classes/Facebook.php");
	require_once("classes/Course.php");
	session_start();
	if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
		header("Location: index.php");
	$userID = $_SESSION['userID'];
	
	if (isset($_POST['courseID']))
	{
		//echo "post was set";
		$output = Course::requestEnrollWithCheck($userID, $_POST['courseID']);
		
		echo "$output";
		
		exit(0);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once("layout/headScripts.php"); ?>
		<?php require_once("layout/header.php"); ?>
		
		<script src='scripts/courseBuilder.js' type='text/javascript'></script>
	
		<script type="text/javascript">
			populate_newsfeed(<?php echo $userID ?>, 10);
		</script>
	</head>
	<body>
		<div id="fb-root">
			<?php Facebook::makeBodyScript(); ?>
		</div>
		<div id="wrapper">
		
			<div id = "newsfeed">
			</div>
			<h1>Add Course</h1>
			<form id = "courseInputForm">
				Course ID: <input type="text" id = "courseID" /><br />
				<button type = "button" onclick = "validateEnrollment()">Submit Course</button>
			</form>
			<div id = "helpBox"></div> 
			
		</div>
		<?php require_once("layout/footer.php"); ?>
	</body>
</html>