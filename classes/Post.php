<?php
  require_once("Database.php");
  
  class post{
    private $id;
	private $name;
	private $content;
	private $post_time;
    
    function __construct($ptID, $ptName, $ptContent, $ptPost_time) {
      $this->id = $ptID;
	  $this->name = $ptName;
	  $this->content = $ptContent;
	  $this->post_time = $ptPost_time;
    }
        
    /* GETTERS */
    
    function get_id() {
      return $this->id;
    }

	function get_name() {
      return $this->name;
    }
	
	function get_content() {
      return $this->content;
    }
	
	function get_post_time() {
      return $this->post_time;
    }
	
	function get_string(){
		return $this->name." ".$this->post_time.":  ".$this->content;
	}
	
    /* SETTERS */
    
    function set_id($x) {
      $this->id = $x;
    }
	
	function set_name($x) {
      $this->name = $x;
    }
	
	function set_content($x) {
      $this->content = $x;
    }
	
	function set_post_time($x) {
      $this->post_time = $x;
    }
	    
  }
  
?>
