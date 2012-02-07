<?php
require_once("../classes/Database.php");
session_start();
echo "Got here";
$userID = $_GET["userID"];
$_SESSION["userID"] = $userID;
//$_SESSION["userMod"] = new User($userID);
$fname = $_GET["fname"];
$lname = $_GET["lname"];

echo "{$userID}, {$fname}, {$lname}";

$result = $db->query("SELECT COUNT(*) AS num from sfuser WHERE user_ID = '{$userID}'");
$row = mysql_fetch_assoc($result);
if($row['num'] == 0) 
{
	$db->query("INSERT INTO sfuser (user_ID, user_fname, user_lname) VALUES ('{$userID}','{$fname}','{$lname}')");
	echo "Inserted new user.";
} else
{
	echo "Did not insert user.";
}

echo mysql_error();

?>
