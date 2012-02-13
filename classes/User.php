<?php
  require_once("Database.php");
  
  class User {
	private $record;
    private $id;
    private $userType;
    private $fname;
    private $lname;
    private $dob;
    private $semester;
    private $school;
    private $token;
    private $major;
    
    /*
    CONSTRUCTOR
    Parameter $fbID: Unique facebook identifier
    Using facebook ID sets id parameter to the facebook ID.
    */
    function __construct($fbID) {
      $this->set_id($fbID);
    }
    
    function getALL() {
      global $db;
      $rs = $db->query("CALL getUser('{$this->id}')");
      $row = $rs->fetch_array(MYSQLI_ASSOC);
      $this->set_fname($row['user_fname']);
	  $this->set_lname($row['user_lname']);
    }
    
    /* GETTERS */
    
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
    
    /* SETTERS */
    
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
