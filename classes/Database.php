<?php
//require_once("../scripts/conn.php");

class Database
{
  private $conn;
  private $query;

  public function __construct() {
    $this->setConn();
    mysql_select_db("sf", $this->getConn());
  }
  
  public function getConn() {
    return $this->conn;
  }
  
  public function setConn() {
    $this->conn = mysql_connect("146.186.177.188", "root", "denim");
    if (!$this->conn)
    {
      die("Could not connect to specified database!");
    }
  }

  public function query($query) {
    return mysql_query($query);
  }

  /* Stored Procedure FUnctions */

  public function addUser() {
  
  }

}

$db = new Database();

?>
