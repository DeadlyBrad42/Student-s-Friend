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
    $rs = $db->query("SELECT * FROM course WHERE course_ID = '{$courseID}'");
    $row = $rs->fetch_array(MYSQLI_ASSOC);
	  
	$this->set_courseID($row['course_ID']);
    $this->set_name($row['course_name']);
	$this->set_descrip($row['course_description']);
	$this->set_time($row['course_time']);
	$this->set_location($row['course_location']);
	$this->set_instructorID($row['instructor_ID']);
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
