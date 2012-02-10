<?php
  
  class Database {
    private $conn;
    private $query;
    
    public function __construct() {
      $this->setConn();
    }
    
    public function setConn() {
      // switch between commenting these lines depending on where you're developing from
      $this->conn = new mysqli("localhost", "root", "denim", "sf");
      //$this->conn = new mysqli("146.186.177.188", "root", "denim", "sf");
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
