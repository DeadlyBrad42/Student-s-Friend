<?php
require_once("classes/Course.php");
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
	$c = new Course($cid);
	$title = "Specific Course";
	echo "<div id='crsWrap'>
				 <h2 id='crsName'>".$c->get_name()."</h2>
					<ul id='crsNav'>
						<li><a onclick='switchCrsView(0)'>Calendar</a></li>
						<li><a onclick='switchCrsView(1)'>Course Storage</a></li>
						 <li><a onclick='switchCrsView(2)'>Forum</a></li>
						<li><a onclick='switchCrsView(3)'>Flash Cards</a></li>
					</ul>
					<div id='crsContent'></div> 
				</div>
				";
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
				<div id='crsWrap'>
					<h2 id='crsName'>{$title}</h2>
					<div id='crsContent'></div>
				</div>
				";
}
?>
