<?php
  
  class Database {
    private $conn;
    private $query;
    
    public function __construct() {
      $this->setConn();
    }
    
    public function setConn() {
      // address might become numerical IP if server goes down (takes time for DNS to trickle down)
      $this->conn = new mysqli("www.troop551.com", "root", "denim", "sf");
      if(mysqli_connect_errno())
      {
        die("Could not connect to specified database: " . mysqli_connect_error());
      }
    }
    
    public function getConn() {
      return $this->conn;
    }
    
    public function query($query) {
      return $this->conn->query($query);
    }

    public function error() {
			return mysqli_error($this->conn);
		}

	public function next_result() {
		if (mysqli_more_results($this->conn))
			return mysqli_next_result($this->conn);
		else
			return false;
	}

    public function getLastInsertedID() {
      return mysqli_insert_id($this->conn);
    }
  }
  
  $db = new Database();
  
?>
