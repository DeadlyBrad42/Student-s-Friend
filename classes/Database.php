<?php
//require_once("../scripts/conn.php");

class Database
{
  private $conn;
  private $query;

  function __construct() {
    $this->setConn();
    mysql_select_db("sf", $this->getConn());
  }
  
  function getConn() {
    return $this->conn;
  }
  
  function setConn() {
    $this->conn = mysql_connect("146.186.177.188", "root", "denim");
    if (!$this->conn)
    {
      die("Could not connect to specified database!");
    }
  }

  function query($query) {
    return mysql_query($query);
  }
}

$db = new Database();

?>
