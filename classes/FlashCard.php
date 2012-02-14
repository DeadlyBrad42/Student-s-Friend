<?php
  require_once("Database.php");
  
  class FlashCard {
    private $id;
	private $title;
	private $answer;
	private $question;
    
    function __construct($fcID, $fctitle, $fcanswer, $fcquestion) {
      $this->id = $fcID;
	  $this->title = $fctitle;
	  $this->answer = $fcanswer;
	  $this->question = $fcquestion;
    }
        
    /* GETTERS */
    
    function get_id() {
      return $this->id;
    }

	
	function get_title() {
      return $this->title;
    }
	
	function get_answer() {
      return $this->answer;
    }
	
	function get_question() {
      return $this->question;
    }    
    
    /* SETTERS */
    
    function set_id($x) {
      $this->id = $x;
    }

    function set_title($x) {
      $this->title = $x;
    }
	
    function set_answer($x) {
      $this->answer = $x;
    }	
	
    function set_question($x) {
      $this->question = $x;
    }    
    
  }
  
?>
