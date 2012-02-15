<?php
  require_once("Database.php");
  require_once("Post.php");
  
  class Thread{
    private $id;
	private $title;
	private $posts;
    
    function __construct($tdID, $tdTitle) {
      $this->id = $tdID;
	  $this->title = $tdTitle;
	  $this->getAll();
    }
    
    function getALL() {
      global $db;
	  $rs = $db->query("CALL getPosts('{$this->id}')");
	  //getPosts will get all of the thread's posts
      $result = $rs->fetch_array(MYSQLI_ASSOC);
	  $this->set_posts($result);


    }
    
    /* GETTERS */
    
    function get_id() {
      return $this->id;
    }

	function get_title() {
      return $this->name;
    }
	
	function get_posts() {
      return $this->posts;
    }
	
    /* SETTERS */
    
    function set_id($x) {
      $this->id = $x;
    }
	
	function set_title($x) {
      $this->title = $x;
    }
		
	function set_posts($result) {
		foreach($result as $row){
			$holder = new Post($row['post_ID'],$row['post_name'],$row['post_content'],$row['post_time']);
			array_push($this->posts, $holder);
		}
    }
	    
  }
  
?>
