<?php
session_start();

$connect = mysql_connect("localhost", "root") or die(mysql_error());
$database = mysql_select_db("studentFriend", $connect);

$userID =  strip_tags($_POST["userID"]);
$status = strip_tags($_POST["status"]);

// New stuff 1/15/2012
 if($userID) {
	if($status) {
		$result = mysql_query("SELECT USERID FROM $userID"."_friends") or die(mysql_error());
		
		while($row = mysql_fetch_array($result)) {
			$current_friend = $row['USERID'];
			
			 $query = mysql_query("INSERT INTO $current_friend"."_updates (userid, status) VALUES ('$userID','$status')")
			  or die(mysql_error());
			 			
			//echo "INSERT INTO $current_friend"."_updates (user, status) VALUES ('$userID','$status')";
		}
	}
	
	echo "Your status update was successful!";
}
	
// New stuff 1/15/2012
?>