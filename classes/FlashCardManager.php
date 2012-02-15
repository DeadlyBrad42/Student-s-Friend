<?php
  require_once("Database.php");
  require_once("FlashCard.php");
  
  class FlashCardManager {
    private $courseID;
	private $cardArray;
	private $cardTitleArray;
    global $db;
	
    function __construct($fcmCourseID){
      $this->CourseID = $fcmCourseID;
	  $this->getCardTitle();	
	}
	
	function getCard($id){
      $rs = $db->query("SELECT * FROM sfflashcard WHERE flashcard_id = '{$id}'");
      $row = $rs->fetch_array(MYSQLI_ASSOC);
	  return $flash = new FlashCard($id, $row['card_title'], $row['card_answer'],$row['card_question']);
	}
    
	function getCardTitle(){
		$rs = $db->query("SELECT flashcard_title FROM sfflashcard WHERE course_id = '{$this->courseID}'");
		$this->cardTitleArray = $rs->fetch_array(MYSQLI_ASSOC);
	}

	function makeDeck($titleArray){
		foreach($title as $titleArray){
			$rs = $db->query("SELECT * FROM sfflashcard WHERE flashcard_title = '{$this->title}' AND course_id = '{$this->courseID}'");
			$result = $rs->fetch_array(MYSQLI_ASSOC);
			foreach($result as $row){
				$holder = new FlashCard($row['flashcard_id'],$row['flashcard_title'],$row['flashcard_question'],$row['flashcard_answer']);
				array_push($this->cardArray;, $holder);
			}
		}
	}
	
    function createCard($title, $question, $answer) {
		$db->query("INSERT INTO sfflashcard (flashcard_title, flashcard_question, flashcard_answer) VALUES ('{$title}','{$question}','{$answer}')");
    }
    
	function deleteCard($id){
		$db->query("DELETE FROM sfflashcard WHERE flashcard_id = '{$id}'");
	}
   
	function editCard($id, $title, $question, $answer) {
		this->deleteCard($id);
		this->createCard($title, $question, $answer);
	}
	
	function randomize(){
		shuffle($this->cardArray);
	}
  
  }
  
?>
