<?php
  require_once("Database.php");
  
  class Event {
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
    
  // $obj here is a json object that's been decoded
  public static function createEvent($obj, $courseID) {
    global $db;
    $daysUntilRecur = 0;
    $event_recurs = 0;
    $isRecur = 0;
    $sTime = $obj->sDate . " " . $obj->sTime;
    $eTime = $obj->eDate . " " . $obj->eTime;
    switch ($obj->isRecur)
    {
      case "Daily":
        $isRecur = 1;
        $daysUntilRecur = 1;
        $event_recurs = 365;
        break;
      case "Weekly":
        $isRecur = 1;
        $daysUntilRecur = 7;
        $event_recurs = 52;
        break;
      case "Monthly":
        $isRecur = 1;
        $daysUntilRecur = 30;
        $event_recurs = 12;
        break;
      case "Yearly":
        $isRecur = 1;
        $daysUntilRecur = 365;
        $event_recurs = 1;
        break;
      default:
        break;
    }

	//	If courseID is anything other than user we are adding event under course, otherwise we are adding it under user.
    if ($courseID != 0)
    {
      if ($db->query("INSERT INTO sfevent (event_name, event_desc, event_location, event_startTime, event_endTime, event_privacy, user_ID,
                  course_ID, event_isRecur, event_daysUntilRecur, event_recurs) VALUES('{$obj->name}', '{$obj->descrip}', '{$obj->loc}',
                  '{$sTime}', '{$eTime}', '0', '0', {$courseID}, '{$isRecur}', '{$daysUntilRecur}', '{$event_recurs}')"))
      {
        echo "insert success!";
      }
    }
    else
    {
      $id = $_SESSION['userID'];
      if ($db->query("INSERT INTO sfevent (event_name, event_desc, event_location, event_startTime, event_endTime, event_privacy, user_ID,
                  course_ID, event_isRecur, event_daysUntilRecur, event_recurs) VALUES('{$obj->name}', '{$obj->descrip}', '{$obj->loc}',
                  '{$sTime}', '{$eTime}', '0', '{$id}', '0', '{$isRecur}', '{$daysUntilRecur}', '{$event_recurs}' )"))
      {
        echo "insert success!";
      }
    }
  }
	
	public function isRecurring(){
	}
	
  public static function getEvents($id, $isCrs=0) {
    global $db;
    
    if ($isCrs == 1)
    {
      // Do crap here
      $rs = $db->query("SELECT * FROM sfevent WHERE course_ID = '{$id}'");
    }
    else
    {
      $rs = $db->query("SELECT * FROM sfevent WHERE user_ID = '{$id}'");
    }

    $evt = array();
    while($row = $rs->fetch_array(MYSQLI_ASSOC))
    {
      $e = array(
        'allDay' => false,
        'id' => $row['event_ID'],
        'title' => $row['event_name'],
        'start' => $row['event_startTime'],
        'end' => $row['event_endTime'],
        'location' => $row['event_location'],
        'privacy' => $row['event_privacy'],
        'description' => $row['event_desc']);

      $evt[] = $e;
	  
      if($row['event_isRecur']) 
      {
        for($i = 0; $i < $row['event_recurs']; $i++) 
        {
		      $daysToAdd = $row['event_daysUntilRecur'];
		      $start = new DateTime($e['start']);
		      $start->add(new DateInterval("P{$daysToAdd}D"));
		      $e['start'] = $start->format('Y-m-d H:i:s');
		  
		      $end = new DateTime($e['end']);
		      $end->add(new DateInterval("P{$daysToAdd}D"));
		      $e['end'] = $end->format('Y-m-d H:i:s');
		  
		      $evt[] = $e;
	      }
      }
    }
    return json_encode($evt);
  }

  public static function changeEvent($id, $dayDiff, $minDiff, $isResize) {
    global $db;
    if ($isResize)
    {
      // We only care about the event endTime if an event is resized
      if ($dayDiff != 0)
      {
        $db->query("UPDATE sfevent SET event_endTime = DATE_ADD(event_endTime, INTERVAL '{$dayDiff}' DAY) WHERE event_ID = {$id};");
      }
      if ($minDiff != 0)
      {
        $db->query("UPDATE sfevent SET event_endTime = DATE_ADD(event_endTime, INTERVAL '{$minDiff}' MINUTE) WHERE event_ID = {$id};");
      }
    }
    else
    {
      if ($dayDiff != 0)
      {
        $db->query("UPDATE sfevent SET event_startTime = DATE_ADD(event_startTime, INTERVAL '{$dayDiff}' DAY), 
        event_endTime = DATE_ADD(event_endTime, INTERVAL '{$dayDiff}' DAY) WHERE event_ID = {$id};");
      }
      if ($minDiff != 0)
      {
        $db->query("UPDATE sfevent SET event_startTime = DATE_ADD(event_startTime, INTERVAL '{$minDiff}' MINUTE), 
        event_endTime = DATE_ADD(event_endTime, INTERVAL '{$minDiff}' MINUTE) WHERE event_ID = {$id};");
      }
    }
  }

  public static function deleteEvent($id) {
    global $db;
    if ($db->query("DELETE FROM sfevent WHERE event_ID = {$id}"))
    {
      echo "query worked!";
    }
    else
    {
      echo "query did not work!";
    } 
  }

  /* GETTERS */
  public function get_id() {
    return $this->id;
  }

	public function get_name() {
    return $this->name;
  }
	
	public function get_description() {
    return $this->description;
  }
	
	public function get_location() {
    return $this->location;
  }
	
	public function get_startTime() {
    return $this->startTime;
  }
	
	public function get_endTime() {
    return $this->endTime;
  }
	
	public function get_privacy() {
    return $this->privacy;
  } 
    /* SETTERS */
    
  private function set_id($x) {
    $this->id = $x;
  }
	
	private function set_name($x) {
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
