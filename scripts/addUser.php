<?php
require_once("../classes/Database.php");

$userID = $_GET["userID"];
$fname = $_GET["fname"];
$lname = $_GET["lname"];

echo "{$userID}, {$fname}, {$lname}";

$db->query("INSERT INTO sfuser (user_ID, user_fname, user_lname) VALUES ('{$userID}','{$fname}','{$lname}')");

echo mysql_error();

?>
