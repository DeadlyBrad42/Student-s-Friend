<?php
  require_once("Database.php");
  require_once("NewsFeed.php");
  
  class Event {
  private $id;
	private $name;
	private $description;
	private $location;
	private $startTime;
	private $endTime;
	private $privacy;
    
  // $obj here is a json object that's been decoded
  public static function createEvent($obj, $courseID) {
    global $db;
    $orgFormat = "n-j-Y h:i a";
    $dbFormat = "Y-m-d H:i:s";
    $daysUntilRecur = 0;
    $event_recurs = 0;
    $isRecur = 0;
    $start = $obj->sDate . " " . $obj->sTime;
    $end = $obj->eDate . " " . $obj->eTime;
    $sTime = DateTime::createFromFormat($orgFormat, $start);
    $eTime = DateTime::createFromFormat($orgFormat, $end);
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
      if(!$db->query("CALL createEvent('{$obj->name}', '{$obj->descrip}', '{$obj->loc}', '".$sTime->format($dbFormat)."','".$eTime->format($dbFormat)."', 0, '0', '{$courseID}', {$isRecur}, {$daysUntilRecur}, {$event_recurs})"));
      	echo $db->error();
	  
	  NewsFeed::postUpdate($courseID, "New event {$obj->name} added on ".$sTime->format('n-j-Y'));
    }
    else
    {
      $id = $_SESSION['userID'];
				
      if(!$db->query("CALL createEvent('{$obj->name}', '{$obj->descrip}', '{$obj->loc}', '".$sTime->format($dbFormat)."','".$eTime->format($dbFormat)."', 0, '{$id}', '0', {$isRecur}, {$daysUntilRecur}, {$event_recurs})"));
      	echo $db->error();
    }
  }
	
  public static function getEvents($id, $isCrs=0) {
    global $db;
    
    if ($isCrs == 1)
    {
      $rs = $db->query("CALL events_by_course('{$id}')");
    }
    else
    {
      $rs = $db->query("CALL events_by_user('{$id}')");
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
	
	$rs = $db->query("SELECT course_ID, event_name, event_startTime FROM sfevent WHERE event_ID = {$id}");
	$row = $rs->fetch_array(MYSQLI_ASSOC);
	
	NewsFeed::postUpdate($row['course_ID'], "Event {$row['event_name']} rescheduled to {$row['event_startTime']}.");
  }

  public static function deleteEvent($id) {
    global $db;
	
	$rs = $db->query("SELECT course_ID, event_name FROM sfevent WHERE event_ID = {$id}");
	$row = $rs->fetch_array(MYSQLI_ASSOC);
	
    if ($db->query("DELETE FROM sfevent WHERE event_ID = {$id}"))
    {
      echo "query worked!";
	  
	  NewsFeed::postUpdate($row['course_ID'], "Event {$row['event_name']} was deleted from calendar.");
    }
    else
    {
      echo "query did not work!";
    } 
  }
}
?>
