<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$db->closeConnection();
?>

<html>
<head><title> StartPage</title><head>
<body><h1>StartPage</h1>
	<form method=post action="production.php">	
		<input type=submit value="Produce Pallets">
	</form>
	<form method=post action="searchPallets.php">	
		<input type=submit value="Search Pallets">
	</form>
	<form method=post action="blocking.php">	
		<input type=submit value="Block Pallets">
	</form>
</body>
</html>
