<?php
  
  class Database {
    private $conn;
    private $query;
    
    public function __construct() {
      $this->setConn();
    }
    
    public function setConn() {
      // This IP may change if the server goes down
      $this->conn = new mysqli("71.31.181.51", "root", "denim", "sf");
      if(mysqli_connect_errno())
      {
        die("Could not connect to specified database: " . mysqli_connect_error());
      }
    }
    
    public function query($query) {
      return $this->conn->query($query);
    }
  }
  
  $db = new Database();
  
?>
