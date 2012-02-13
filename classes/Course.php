<?php
/* These pages don't exist yet
  require_once("Forum.php");
  require_once("Calendar.php");
*/
class Course {
  private $id;
  private $name;
  private $descrip;
  private $time;
  private $location;
  private $calendar;
  private $forum;
  private $groupID;

  public __construct() {
    // Don't know yet
  }

  /* Getters */
  public getName() {
    return $this->name;
  }

  public getDescrip() {
    return $this->descrip;
  }

  public getTime() {
    return $this->time;
  }

  public getLocation() {
    return $this->location;
  }

  public getCourses() {
    // Not sure yet
  }

  /* Setters */
  public setName($x) {
    $this->name = $x;
  }

  public setDescrip($x) {
    $this->descrip = $x;
  }

  public setTime($x) {
    $this->time = $x;
  }

  public setLocation($x) {
    $this->location = $x;
  }
}

$course = new Course();
?>
