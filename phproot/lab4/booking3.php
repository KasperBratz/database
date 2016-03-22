<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$movieName = $_SESSION['movieName'];
	$performanceDate = $_POST['performanceDate'];
	$_SESSION['performanceDate'] = $performanceDate;
	$db->openConnection();
	
	$performanceInfo = $db->getPerformanceInfo($movieName,$performanceDate);
	$db->closeConnection();
?>

<html>
<head><title>Booking 3</title><head>
<body><h1>Booking 3</h1>
	Current user: <?php print $userId ?>
	<p>
	Data for selected performance:
	<p>
	
	<form method=post action="booking4.php">
		<?php

			foreach ($performanceInfo as $row) {
				print "<pre>";
				print "Movie 		";
				print $row[movieName];
				print "<br>";
				print "Date 		";
				print $row[performanceDate];
				print "<br>";
				print "Theater 	";
				print $row[theaterName];
				print "<br>";
				print "Free seats 	";
				print $row[freeSeats];
				print "<br>";
				print "</pre>";
			}
		?>
		<input type=submit value="Book ticket">

	</form>
</body>
</html>
