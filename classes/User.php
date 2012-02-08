<?php
require_once("Database.php");

class User {
	private $id;
	private $userType;
	private $fname;
	private $lname;
	private $dob;
	private $semester;
	private $school;
	private $token;
	private $major;

	function __construct($fbID) {
    $this->id = $fbID;
 /*	$result = Database::getUser($fbID);
		$this->id = $result["user_ID"];
		$this->userType = $result["user_type"];
		$this->fname = $result["user_fname"];
		$this->lname = $result["user_lname"];
		$this->dob = $result["user_dob"];
		$this->semester = $result["user_semester"];
		$this->school = $result["user_university"];
		$this->token = $result["user_dbToken"];
		$this->major = $result["user_major"];*/
  } 	

  function getALL() {
   /* $mysqli = new mysqli("146.186.177.188", "root", "denim", "sf");
    $rs = $mysqli->query("CALL getUser('{$this->id}')");
    $row = $rs->fetch_array(MYSQLI_ASSOC);
    $this->fname = $row['fname'];*/

  }
	function get_id() {
		return $this->id;
	}

	function get_userType() {
		return $this->userType;
	}

	function get_fname() {
		return $this->fname;
	}

	function get_lname() {
		return $this->lname;
	}

	function get_dob() {
		return $this->dob;
	}

	function get_semester() {
		return $this->semester;
	}

	function get_school() {
		return $this->school;
	}

	function get_token() {
		return $this->token;
	}

	function get_major() {
		return $this->major;
	}

	function set_id($x) {
		$this->id = $x;
	}

	function set_userType($x) {
		$this->userType = $x;
	}

	function set_fname($x) {
		$this->fname = $x;
	}

	function set_lname($x) {
		$this->lname = $x;
	}

	function set_dob($x) {
		$this->dob = $x;
	}

	function set_semester($x) {
		$this->semester = $x;
	}

	function set_school($x) {
		$this->school = $x;
	}

	function set_token($x) {
		$this->token = $x;
	}

	function set_major($x) {
		$this->major = $x;
	}

}

?>
