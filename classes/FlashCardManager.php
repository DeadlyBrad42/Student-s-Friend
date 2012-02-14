<?php
  require_once("Database.php");
  require_once("FlashCard.php");
  
  class FlashCardManager {
    private $CourseID;
	private $cardArray;
    global $db;
	
    function __construct($fcmCourseID) {
      $this->CourseID = $fcmCourseID;
    }
	
	function getCard($id){
      $rs = $db->query("CALL getFlashCard('{$id}')");
      $row = $rs->fetch_array(MYSQLI_ASSOC);
	  return $flash = new FlashCard($id, $row['card_title'], $row['card_answer'],$row['card_question']);
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
		shuffle($cardArray)
	}
  
  }
  
?>
