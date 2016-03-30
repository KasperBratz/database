<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();

	$minTime = $_POST['min'];
	$maxTime = $_POST['max'];
	$cookieName = $_POST['cookieName'];
	$amountBlocked = $db->blockPallets($cookieName,$minTime,$maxTime);
	
	$db->closeConnection();
?>

<html>
	<head><title> Result </title><head>
	<body>


	<form method = post action="startPage.php">
		<?php
			print $amountBlocked;
			print " pallets blocked.";
			?>
		<input type=submit value = "Continue">
	</form>
	</body>
	<html>