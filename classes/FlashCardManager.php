<?php
  require_once("Database.php");
  require_once("FlashCard.php");
  
  class FlashCardManager {
    private $courseID;
	private $userID;
	private $cardArray;
	private $cardTitleArray;
    
	
    function __construct($fcmCourseID, $fcmUserID){
      $this->courseID = $fcmCourseID;
	  $this->userID = $fcmUserID;
	  $this->getCardTitle();	
	}
	
	function getCard($id){
      $rs = $db->query("CALL sf.get_card('{$id}')");
      $row = $rs->fetch_array(MYSQLI_ASSOC);
	  return $flash = new FlashCard($id, $row['card_title'], $row['card_answer'],$row['card_question']);
	}
    
	function getCardTitle(){
		$rs = $db->query("CALL sf.get_cardTitles('{$this->courseID}')");
		$this->cardTitleArray = $rs->fetch_array(MYSQLI_ASSOC);
	}

	public static function makeDeck($titleArray){
		global $db;
		$cardArray;
		//foreach($titleArray as $title){
			$rs = $db->query("SELECT * FROM flashcard WHERE card_title = '{$titleArray}'");
			while($row = $rs->fetch_array(MYSQLI_ASSOC))
			{
				$holder = array(
								'title' => $row['card_title'],
								'question' => $row['card_question'],
								'answer' => $row['card_answer']);
				$cardArray[]= $holder;
			}
		//}
		return json_encode($cardArray);
	}
	/*	
    function createCard($title, $question, $answer) {
		$db->query("CALL sf.insert_card('{$this->coursID}','{$this->userID}','{$title}','{$question}','{$answer}')");
    }
    
	function deleteCard($id){
		$db->query("CALL sf.delete_card('{$id}')");
	}
   
	function editCard($id, $title, $question, $answer) {
		this->deleteCard($id);
		this->createCard($title, $question, $answer);
	}
	
	function randomize(){
		shuffle($this->cardArray);
	}
	*/
  }
  
?>
