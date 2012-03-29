<?php
  require_once("Database.php");
  
  class FlashCardManager {	
	
	public static function insertFlashCards($cor, $uID, $t, $q, $a){
		global $db;
		$db->query("CALL insert_card({$cor},'{$uID}','{$t}','{$q}','{$a}')");
	}
	
	public static function flashCardEdit($cor, $uID, $cardID, $t, $q, $a){
		global $db;
			$db->query("CALL delete_card({$cardID})");
			if( $q != '' && $a != '' ){
				$db->query("CALL insert_card({$cor},'{$uID}','{$t}','{$q}','{$a}')");
			}

		
	}
	
	public static function getCardTitle($courseID){
		global $db;
		$rs = $db->query("CALL get_title({$courseID})");
		while($row = $rs->fetch_array(MYSQLI_ASSOC))
		{
			$holder = array('title' => $row['card_title']);
			$cardTitleArray[]= $holder;
		}
		return json_encode($cardTitleArray);
	}

	public static function makeDeck($titleArray, $flag){
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
								'id'=> $row['card_ID'],
								'uid'=> $row['user_ID']);
								
				$cardArray[]= $holder;
			}
		}
		if($flag)
			shuffle( $cardArray );
		return json_encode($cardArray);
	}
	
  }

?>
