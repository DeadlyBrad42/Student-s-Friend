<?php
  require_once("Database.php");
  
  class Event{
  private $id;
	private $name;
	private $description;
	private $location;
	private $startTime;
	private $endTime;
	private $privacy;
    
  function __construct($etID) {
    $this->id = $etID;
  }
    
  function getALL() {
    global $db;
    $rs = $db->query("CALL getEvent('{$this->id}')");
    $row = $rs->fetch_array(MYSQLI_ASSOC);
    $this->set_name($row['name']);
    $this->set_description($row['description']);
    $this->set_location($row['location']);
    $this->set_startTime($row['start']);
    $this->set_endTime($row['end']);
    $this->set_privacy($row['privacy']);
  }
    
	function createEvent(){
	}
	
	function isRecurring(){
	}
	
  public static function getEvents($id, $isCrs=0) {
    global $db;
    
    if ($isCrs == 1)
    {
      // Do crap here
    }
    else
    {
      $rs = $db->query("SELECT * FROM sfevent WHERE user_ID = '{$id}'");
    }

    $evt = array();
    while($row = $rs->fetch_array(MYSQLI_ASSOC))
    {
      $e = array(
        'id' => $row['event_calID'],
        'title' => $row['event_name'],
        'start' => $row['event_startTime'],
        'end' => $row['event_endTime'],
        'location' => $row['event_location'],
        'privacy' => $row['event_privacy'],
        'description' => $row['event_desc']);

      $evt[] = $e;
    }
    
    return json_encode($evt);
  }

    /* GETTERS */
    
    function get_id() {
      return $this->id;
    }

	function get_name() {
      return $this->name;
    }
	
	function get_description() {
      return $this->description;
    }
	
	function get_location() {
      return $this->location;
    }
	
	function get_startTime() {
      return $this->startTime;
    }
	
	function get_endTime() {
      return $this->endTime;
    }
	
	function get_privacy() {
      return $this->privacy;
    }
 
    /* SETTERS */
    
    function set_id($x) {
      $this->id = $x;
    }
	
	function set_name($x) {
      $this->name = $x;
    }
	
	function set_description($x) {
      $this->description = $x;
    }
	
	function set_location($x) {
      $this->location = $x;
    }
	
	function set_startTime($x) {
      $this->startTime = $x;
    }
	
	function set_endTime($x) {
      $this->endTime = $x;
    }
	
	function set_privacy($x) {
      $this->privacy = $x;
    }
    
  }
  
?>
