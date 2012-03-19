<?php
  require_once("Database.php");
  require_once("FlashCard.php");
  
  class FlashCardManager {	
	
	public static function insertFlashCards($cor, $uID, $t, $q, $a){
		global $db;
		$db->query("INSERT INTO flashcard (course_ID, user_ID, card_title, card_question, card_answer)
					VALUES({$cor},'{$uID}','{$t}','{$q}','{$a}')");
	}
	public static function flashCardEdit($results, $cor, $uID){
		global $db;
		for( $i=0; $i<count($results)-4; $i+=4){
			$db->query("DELETE FROM flashcard WHERE card_ID= {$results[$i]}");
			$db->query("INSERT INTO flashcard (course_ID, user_ID, card_title, card_question, card_answer)
					VALUES({$cor},'{$uID}','{$results[$i+1]}','{$results[$i+2]}','{$results[$i+3]}')");
		}
		
	}
	
	public static function getCardTitle($courseID){
		global $db;
		$rs = $db->query("SELECT card_title FROM flashcard WHERE course_ID = {$courseID} GROUP BY card_title");
		while($row = $rs->fetch_array(MYSQLI_ASSOC))
		{
			$holder = array('title' => $row['card_title']);
			$cardTitleArray[]= $holder;
		}
		return json_encode($cardTitleArray);
	}
	
	public static function makeDeck($titleArray){
		global $db;
		$cardArray;
		for($i = 0; $i < count($titleArray); $i++){
			$rs = $db->query("SELECT * FROM flashcard WHERE card_title = '{$titleArray[$i]}'");
			while($row = $rs->fetch_array(MYSQLI_ASSOC))
			{
				$holder = array(
								'title' => $row['card_title'],
								'question' => $row['card_question'],
								'answer' => $row['card_answer'],
								'id'=> $row['card_ID']);
				$cardArray[]= $holder;
			}
		}
		return json_encode($cardArray);
	}
	
	/*	
    function createCard($title, $question, $answer) {
		$db->query("CALL sf.insert_card('{$this->coursID}','{$this->userID}','{$title}','{$question}','{$answer}')");
    }
    
	function getCard($id){
      $rs = $db->query("CALL sf.get_card('{$id}')");
      $row = $rs->fetch_array(MYSQLI_ASSOC);
	  return $flash = new FlashCard($id, $row['card_title'], $row['card_answer'],$row['card_question']);
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
