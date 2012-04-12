<?php
require_once("Database.php");
require_once("UserStorage.php");

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
    if ($rs)
		{
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
  }
  
  
  
  static function enrollInCourse($userID, $CourseID) {
		global $db;
		$db->query("INSERT INTO enrollment (user_ID, course_ID) VALUES ({$userID}, {$CourseID});");
		
		$db->next_result();
		
		return "Course has been created";
	}
	
	static function enrollWithCheck($userID, $CourseID) {
		$rs = $db->query("SELECT * FROM enrollment WHERE user_ID = '{$userID}' AND course_ID = '{$CourseID}';");
		
		if($rs->num_rows == 0) {
			self::enrollInCourse($userID, $CourseID);
		}
		
		$db->next_result();
		$rs->close();
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
		
		$db->next_result();
		$rs->close();
		
		return $returnValue;
	}
  
  static function createCourse($instructor_ID, $name, $location, $description) {
	global $db;
	
	$name = addslashes($name);
	$location = addslashes($location);
	$description = addslashes($description);
	
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
	$db->query("DELETE FROM flashcard WHERE course_ID = {$course_ID};");
	$db->query("DELETE FROM post WHERE thread_ID IN
		(SELECT thread_ID FROM thread WHERE course_ID = {$course_ID};");
	$db->query("DELETE FROM thread WHERE course_ID = {$course_ID};");
	$db->query("DELETE FROM sfevent WHERE course_ID = {$course_ID};");
	$db->query("DELETE FROM sfupdate WHERE course_ID = {$course_ID};");
	UserStorage::deleteCourseDirectory($course_ID);
	$db->query("DELETE FROM sfstorage WHERE owner_ID = {$course_ID};");
	
	
	return "Course deleted";
  }
  
	static function echoInstructorCourseMenu($userID) {
		$rs = Course::getInstructorCoursesResultset($userID);
		if($rs) {
			while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
				echo "<tr><th>Course Name: {$row['course_name']} <br /> ID:{$row['course_ID']}<br/></th>
					<td><button type = 'button' onclick = 'okDelete({$row['course_ID']})'>Delete Course</button>
					</td></tr>";
			}
		}
	}
	
	static function echoStudentCourseMenu($userID) {
		global $db;
		$rs = $db->query("SELECT course.course_name AS course_name, course.course_ID AS course_ID
				FROM course RIGHT JOIN enrollment ON course.course_ID = enrollment.course_ID
				WHERE enrollment.user_ID = {$userID} AND course.instructor_ID != {$userID};");
		
		if($rs) {
			
			echo "<h2>Enrolled Courses</h2>
				<table id='enrolledcourses'>";
			while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
				echo "<tr><th>{$row['course_name']}</th><td>
					<button type = 'button' onclick = 'okDisenroll({$row['course_ID']})'>Disenroll</button>
					</td></tr>";
			}
			
			echo "</table>";
			
			$rs->close();
			$db->next_result();
		}
		
		echo "</table>";
			
		$rs = $db->query("SELECT course.course_name AS course_name, course.course_ID AS course_ID
				FROM course RIGHT JOIN enrollmentrequests ON course.course_ID = enrollmentrequests.course_ID
				WHERE enrollmentrequests.user_ID = {$userID};");
		
		if($rs) {
			echo "<h2>Pending Enrollments</h2>
				<table id='pendingenrollments'>";
					
			while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
				echo "<tr><th>{$row['course_name']}</th><td>
					<button type = 'button' onclick = 'okCancelEnroll({$row['course_ID']})'>Cancel Request</button>
					</td></tr>";
			}
			
			echo "</table>";
			
			$db->next_result();
			$rs->close();
		}
	}
	
	static function disenrollStudent($userID, $courseID) {
		global $db;
		
		$db->query("DELETE FROM enrollment WHERE user_ID = {$userID} AND course_ID = {$courseID}");
		
		$db->next_result();
	}
	
	static function cancelEnroll($userID, $courseID) {
		global $db;
		
		$db->query("DELETE FROM enrollmentrequests WHERE user_ID = {$userID} AND course_ID = {$courseID}");
		
		$db->next_result();
	}
	
	static function approveEnrollRequest($userID, $courseID) {
		global $db;
		
		$db->query("INSERT INTO enrollment (user_ID, course_ID) VALUES ({$userID}, {$courseID});");
		$db->next_result();
		$db->query("DELETE FROM enrollmentrequests WHERE user_ID = {$userID} AND course_ID = {$courseID};");
		
		$db->next_result();
	}
	
	static function denyEnrollRequest($userID, $courseID) {
		global $db;
		$db->query("DELETE FROM enrollmentrequests WHERE user_ID = {$userID} AND course_ID = {$courseID};");
		
		$db->next_result();
	}

	static function echoCourseEnrollMenu($courseID) {
		global $db;
		$rs = $db->query("SELECT sfuser.user_ID, sfuser.user_fname, sfuser.user_lname 
				FROM enrollment LEFT JOIN sfuser ON enrollment.user_ID = sfuser.user_ID
				WHERE course_ID = {$courseID} AND sfuser.user_ID NOT IN 
				(SELECT instructor_ID FROM course WHERE course_ID = {$courseID});");
		if (!$rs) echo $db->error();

		echo "<table>";
		while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr><td>{$row['user_fname']} {$row['user_lname']}<br/>
				<button type = 'button' onclick = 'disenrollStudent({$row['user_ID']}, {$courseID})'>Disenroll Student</button>
				</td></tr>";
		}
		echo "</table>";
	}
	
	static function echoEnrollRequestsMenu($courseID) {
		global $db;
		
		$rs = $db->query("SELECT sfuser.user_ID, sfuser.user_fname, sfuser.user_lname 
				FROM enrollmentrequests LEFT JOIN sfuser ON enrollmentrequests.user_ID = sfuser.user_ID
				WHERE course_ID = {$courseID};");
		if (!$rs) echo $db->error();
		
		echo "<table>";
		while($row = $rs->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr><td>{$row['user_fname']} {$row['user_lname']}<br/>
				<button type = 'button' onclick = 'permitEnroll({$row['user_ID']}, {$courseID})'>Permit Enrollment</button>
				<button type = 'button' onclick = 'denyEnroll({$row['user_ID']}, {$courseID})'>Deny Enrollment</button>
				</td></tr>";
		}
		echo "</table>";
	}
	
	static function loadCoursesIntoSession($userID) {
		global $db;
		$rs = $db->query("CALL getCoursesForUser('{$userID}')");
		if ($rs->num_rows == 0)
		{
		  // For now, javascript handles the case where there are no rows
		}
		else
		{	
		  $i = 0;
		  $courses = array();
		  while($row = $rs->fetch_array(MYSQLI_ASSOC))
		  {
		   // While there is still a row to fetch, add an array to $courses based on key/value pairs 
			$id = $row['course_ID'];
			$name = $row['course_name'];
			$descrip = $row['course_description'];
			$time = $row['course_time'];
			$location = $row['course_location'];
			$instructFN = $row['ins_fname'];
			$instructLN = $row['ins_lname'];
			
			$c = array('id' => "{$id}", 
					   'name' => "{$name}",
					   'descrip' => "{$descrip}",
					  'time' => "{$time}",
					  'location' => "{$location}",
					  'insFirst' => "{$instructFN}",
					  'insLast' => "{$instructLN}");
			
			$courses[] = $c;
		  }

		  // Finally, place the Add course link in the json obj
				$c = array('name' => 'Add');
				$courses[] = $c;
		  $_SESSION['courses'] = json_encode($courses);
		}
		
		$rs->close();
		$db->next_result();
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
