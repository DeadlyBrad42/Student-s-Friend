<?php
	require_once("classes/Facebook.php");
	require_once("classes/Course.php");
	require_once("classes/User.php");
	session_start();
	if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 'false')
		header("Location: index.php");
	$userID = $_SESSION['userID'];
	$user = new User($userID);
	if ($user->get_userType() == 2)
		header("Location: courseAdd.php");
	
	if (isset($_POST['courseName'])) {
		$returnValue = Course::createCourse($userID, $_POST['courseName'], $_POST['courseDescription'], $_POST['courseLocation']);
		
		Course::loadCoursesIntoSession($userID);
		
		Course::echoInstructorCourseMenu($userID);
		
		exit(0);
	}
	else if(isset($_POST['courseID'])) {
		Course::loadCoursesIntoSession($userID);
	
		if(!isset($_POST['permittedStudent']) && !isset($_POST['deniedStudent'])) {
			$returnValue = Course::deleteCourse($_POST['courseID']);
			
			Course::echoInstructorCourseMenu($userID);
			
			exit(0);
		} else if(isset($_POST['permittedStudent'])) {
			Course::approveEnrollRequest($_POST['permittedStudent'], $_POST['courseID']);
			
			Course::echoEnrollRequestsMenu($_POST['courseID']);
			
			exit(0);
		} else if(isset($_POST['deniedStudent'])) {
			Course::denyEnrollRequest($_POST['deniedStudent'], $_POST['courseID']);
			
			Course::echoEnrollRequestsMenu($_POST['courseID']);
			
			exit(0);
		}
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
			
			<div id = "helpBox"></div>
			
			<h1>Create Course</h1>
			<form id = "courseInputForm">
				Course Name: <input type="text" id = "courseName" /><br />
				Course Location: <input type="text" id = "courseLocation" /><br />
				Course Description: <textarea id = "courseDescription" rows = "5" col = "60"></textarea><br/>
				<button type = "button" onclick = "validateCourse()">Submit Course</button>
			</form>
			
			<h1>Manage Courses</h1>
			<table id = "coursesDisplay">
				<?php
					Course::echoInstructorCourseMenu($userID);
				?>
			</table>
			
		</div>
		<?php require_once("layout/footer.php"); ?>
	</body>
</html>