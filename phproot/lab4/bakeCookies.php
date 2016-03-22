<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();

	$amount = $_POST['amount'];
	$cookieName = $_POST['cookieName'];
	$succes = $db->bakeCookies($cookieName,$amount);
	
	$db->closeConnection();
?>

<html>
	<head><title> Result </title><head>
	<body>


	<form method = post action="startPage.php">
		<?php
			if($succes){
				print ("Pallets made.");
			
     		 }else{
       			print ("Fail, secret easter egg!!!!!");
       	
       		}
			?>
		<input type=submit value = "Continue">
	</form>
	</body>
	<html>