<?php
  require_once("Database.php");
  require_once("Thread.php");
  
  class Forum{
	private $courseID;
	private $title;
	private $threads;
    
    function __construct($fmCourseID) {
      $this->courseID = $fmCourseID;
    }
    
    function getALL() {
      global $db;	  
	  $rs = $db->query("CALL getThreads('{$this->courseID}')");
      $result = $rs->fetch_array(MYSQLI_ASSOC);
	  $this->set_threads($result);


    }
    
    /* GETTERS */
    
    function get_id() {
      return $this->id;
    }

	function get_title() {
      return $this->name;
    }
	
	function get_threads() {
      return $this->posts;
    }
	
    /* SETTERS */
    
    function set_id($x) {
      $this->id = $x;
    }
	
	function set_title($x) {
      $this->title = $x;
    }
		
	function set_threads($result) {
		foreach($result as $row){
			$holder = new Thread($row['thread_ID'], $row['thread_title']);
			$holder.getAll();
			array_push(threads, holder);
		}
    }
	    
  }
  
?>
