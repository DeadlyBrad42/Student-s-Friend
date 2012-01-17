<?php
session_start();

$userID = strip_tags($_POST["userID"]);
?>

<html lang="en">

<form action="registerStatus.php" method="POST">
	<h1>Status Update</h1>
	<table cellpadding="2" cellspacing="2" border="0">
		<?php
			echo "<input type='text' name='userID' readonly='true' value='".htmlspecialchars($userID)."' />\n";
		?>
		<tr>
			<td>Status : </td>
			<td><textarea name="status" cols="40" rows="5"></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" value="Submit Status"></td>
			<td><input type="reset" value="Reset"></td>
		</tr>
	</table>
</form>

<div>

	<?php
	
	$connect = mysql_connect("localhost", "root") or die(mysql_error());
	$database = mysql_select_db("studentFriend", $connect);
	
	$sql_code = mysql_query("SELECT * FROM $userID"."_updates");
	
	while($row = mysql_fetch_assoc($sql_code))
	{
		$user = $row["USERID"];
		$status = $row["STATUS"];
		
		echo "
		User <b>$user</b> posted:
		$status <br><br>
		";
	}
	?>

</div>

</html>