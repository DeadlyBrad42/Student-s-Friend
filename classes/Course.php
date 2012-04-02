<?php
require_once("Database.php");

class Course {
  private $id;
  private $name;
  private $descrip;
  private $class_time;
  private $location;
  private $instructor_ID;

  function __construct($courseID) {
		$this->getALL($courseID);
  }
  
  function getALL($courseID) {
    global $db;
    $rs = $db->query("SELECT * FROM course WHERE course_ID = {$courseID}");
    $row = $rs->fetch_array(MYSQLI_ASSOC);
		$this->set_courseID($row['course_ID']);
		$this->set_name($row['course_name']);
		$this->set_descrip($row['course_description']);
		$this->set_time($row['course_time']);
		$this->set_location($row['course_location']);
		$this->set_instructorID($row['instructor_ID']);
		$rs->close(); // Close current result set
		$db->next_result(); // Make way for the next stored procedure
  }
  
  static function enrollInCourse($userID, $CourseID) {
		global $db;
		$db->query("INSERT INTO enrollment (user_ID, course_ID) VALUES ({$userID}, {$CourseID});");
		
		return "Course has been created";
	}
	
	static function enrollWithCheck($userID, $CourseID) {
		$rs = $db->query("SELECT * FROM enrollment WHERE user_ID = '{$userID}' AND course_ID = '{$CourseID}';");
		
		if($rs->num_rows == 0) {
			self::enrollInCourse($userID, $CourseID);
		}
	}
	
	static function requestEnrollWithCheck($userID, $CourseID) {
		global $db;
		$returnValue;
	
		$rs = $db->query("SELECT * FROM enrollmentrequests WHERE user_ID = '{$userID}' AND course_ID = '{$CourseID}';");
		
		if($rs->num_rows == 0) {
			$db->query("INSERT INTO enrollmentrequests (user_ID, course_ID) VALUES ({$userID}, {$CourseID});");
			$returnValue = "Request for enrollment sent.";
		} else {
			$returnValue = "Request for enrollment has already been sent. The instructor must ok your enrollment.";
		}
		
		return $returnValue;
	}
  
  static function createCourse($instructor_ID, $name, $location, $description) {
	global $db;
	$db->query("INSERT INTO course (course_name, course_description, course_location, instructor_ID) 
		VALUES ('{$name}', '{$location}', '{$description}', '{$instructor_ID}');");
	$lastID = $db->getLastInsertedID();
	
	$returnValue = self::enrollInCourse($instructor_ID, $lastID);
	
	return $returnValue;
  }
  
  static function getInstructorCoursesResultset($instructor_ID) {
	global $db;
	$rs = $db->query("SELECT course_name, course_ID FROM course WHERE instructor_ID = {$instructor_ID};");
	
	return $rs;
  }
  
  static function deleteCourse($course_ID) {
	global $db;
	$db->query("DELETE FROM course WHERE course_ID = {$course_ID};");
	$db->query("DELETE FROM enrollment WHERE course_ID = {$course_ID};");
	$db->query("DELETE FROM enrollmentrequests WHERE course_ID = {$course_ID};");
	
	return "Course deleted";
  }
  
	static function echoInstructorCourseMenu($userID) {
		$rs = Course::getInstructorCoursesResultset($userID);
		while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr><td>Course Name: {$row['course_name']} <br /> ID:{$row['course_ID']}<br/>
				<button type = 'button' onclick = 'okDelete({$row['course_ID']})'>Delete Course</button>
				</td></tr>";
		}
	}
	
	static function echoStudentCourseMenu($userID) {
		global $db;
		$rs = $db->query("SELECT course.course_name AS course_name, course.course_ID AS course_ID
				FROM course RIGHT JOIN enrollment ON course.course_ID = enrollment.course_ID
				WHERE enrollment.user_ID = {$userID};");
		echo "<h2>Enrolled Courses</h2>
			<table>";
		while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr><td>{$row['course_name']}<br/>
				<button type = 'button' onclick = 'okDisenroll({$row['course_ID']})'>Disenroll</button>
				</td></tr>";
		}
		
		$rs->close();
		$db->next_result();
		
		echo "</table>";
		
		echo "<h2>Pending Enrollments</h2>
			<table>";
			
		$rs = $db->query("SELECT course.course_name AS course_name, course.course_ID AS course_ID
				FROM course RIGHT JOIN enrollmentrequests ON course.course_ID = enrollmentrequests.course_ID
				WHERE enrollmentrequests.user_ID = {$userID};");
				
		while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr><td>{$row['course_name']}<br/>
				<button type = 'button' onclick = 'okCancelEnroll({$row['course_ID']})'>Cancel Request</button>
				</td></tr>";
		}
		
		echo "</table>";
	}
	
	static function disenrollStudent($userID, $courseID) {
		global $db;
		
		$db->query("DELETE FROM enrollment WHERE user_ID = {$userID} AND course_ID = {$courseID}");
	}
	
	static function cancelEnroll($userID, $courseID) {
		global $db;
		
		$db->query("DELETE FROM enrollmentrequests WHERE user_ID = {$userID} AND course_ID = {$courseID}");
	}
	
	static function approveEnrollRequest($userID, $courseID) {
		global $db;
		
		$db->query("INSERT INTO enrollment (user_ID, course_ID) VALUES ({$userID}, {$courseID});");
		$db->next_result();
		$db->query("DELETE FROM enrollmentrequests WHERE user_ID = {$userID} AND course_ID = {$courseID});");
	}
	
	static function echoEnrollRequestsMenu($courseID) {
		global $db;
		
		$rs = $db->query("SELECT sfuser.user_ID, sfuser.user_fname, sfuser.user_lname 
				FROM enrollmentrequests LEFT JOIN sfuser ON enrollmentrequests.user_ID = sfuser.user_ID
				WHERE course_ID = {$courseID};");
		
		echo "<table>";
		while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr><td>{$row['user_fname']} {$row['user_lname']}<br/>
				<button type = 'button' onclick = 'permitEnroll({$row['user_ID']}, {$courseID})'>Permit Enrollment</button>
				<button type = 'button' onclick = 'denyEnroll({$row['user_ID']}, {$courseID})'>Deny Enrollment</button>
				</td></tr>";
		echo "</table>";
		}
	}

  /* Getters */
  function get_courseID() {
    return $this->id;
  }
  
  function get_name() {
    return $this->name;
  }

  function get_descrip() {
    return $this->descrip;
  }

  function get_time() {
    return $this->class_time;
  }

  function get_location() {
    return $this->location;
  }
  
  function get_instructorID() {
	return $this->instructor_ID;
  }

  /* Setters */
  function set_courseID($x) {
    $this->id = $x;
  }
  
  function set_name($x) {
    $this->name = $x;
  }

  function set_descrip($x) {
    $this->descrip = $x;
  }

  function set_time($x) {
    $this->class_time = $x;
  }

  function set_location($x) {
    $this->location = $x;
  }
  
  function set_instructorID($x) {
    $this->instructor_ID = $x;
  }
}
?>