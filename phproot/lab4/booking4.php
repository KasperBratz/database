<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$movieName = $_SESSION['movieName'];
	$performanceDate = $_SESSION['performanceDate'];
	$db->openConnection();
	$bookingNbr = $db->bookTicket($userId,$movieName,$performanceDate);
	$db->closeConnection();
?>

<html>
<head><title>Booking 4</title><head>
<body><h1>Booking 4</h1>
	<form method=post action="booking1.php">
		<?php
			if($bookingNbr > 0){
				print "One ticket booked. Booking number ";
				print $bookingNbr;
				print ".";
			}else{
				print "No tickets available. Please come again.";
			}
	
		?>
		<input type=submit value="New reservation">
	</form>
</body>
</html>
