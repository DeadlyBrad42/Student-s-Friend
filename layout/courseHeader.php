<?php
require_once("classes/Course.php");
require_once("classes/User.php");

if (isset($_GET['c']) && !empty($_GET['c']))
{
	makeSpecificCourse($_GET['c']);
}
else
{
	makeCourseLanding();
}

function makeSpecificCourse($cid)
{
	$course = new Course($_SESSION['userID']);
	$c = new Course($cid);
	$title = "Specific Course";
	$x = " <h2 id='crsName'>".$c->get_name()."</h2>
					<ul id='crsNav'>
						<li><a onclick='switchCrsView(0)'>Calendar</a></li>
						<li><a onclick='switchCrsView(1)'>Course Storage</a></li>
						<li><a onclick='switchCrsView(2)'>Forum</a></li>
						<li><a onclick='switchCrsView(3)'>Flash Cards</a></li>";
	if($course->get_instructorID() == $_SESSION['userID']) {
		$x = $x."<li><a onclick='switchCrsView(4)'>Course Management</a></li>";
	}
	$x = $x."</ul>";
	echo $x;
}

function makeCourseLanding()
{
	$title = $_SESSION['userName']."'s Courses";
	$crs = isset($_SESSION['courses']) ? $_SESSION['courses'] : "You are currently not enrolled in any courses";
	echo "<script type='text/javascript'>
					$(document).ready(function() {
							var crs = {$crs};
							var div = $('div#crsContent');
							makeCrsLanding(crs, div);
						});
				</script>
				<h2 id='crsName'>{$title}</h2>
				";
}
?>
