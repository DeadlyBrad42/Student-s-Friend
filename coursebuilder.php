<?php
	require_once("classes/Facebook.php");
	require_once("classes/Course.php");
	session_start();
	if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
		header("Location: index.php");
	$userID = $_SESSION['userID'];
	
	if (isset($_POST['courseName']))
	{
		//echo "post was set";
		Course::createCourse($userID, $_POST['courseName'], $_POST['courseDescription'], $_POST['courseLocation']);
		
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
			<h1>Create Course</h1>
			<form id = "courseInputForm">
				Course Name: <input type="text" id = "courseName" /><br />
				Course Location: <input type="text" id = "courseLocation" /><br />
				Course Description: <textarea id = "courseDescription" rows = "5" col = "60"></textarea><br/>
				<button type = "button" onclick = "validateCourse()">Submit Course</button>
			</form>
			<div id = "helpBox"></div> 
			
		</div>
		<?php require_once("layout/footer.php"); ?>
	</body>
</html>