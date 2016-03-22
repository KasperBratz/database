<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$movieName = $_POST['movieName'];
	$_SESSION['movieName'] = $movieName;
	$db->openConnection();
	
	$performances = $db->getPerformances($movieName);
	$db->closeConnection();
?>

<html>
<head><title>Booking 2</title><head>
<body><h1>Booking 2</h1>
	Current user: <?php print $userId ?>
	<p>
	Selected Movie: <?php print $movieName ?>
	<p>
	Performance dates:
	<p>
	<form method=post action="booking3.php">
		<select name="performanceDate" size=10>
		<?php
			$first = true;
			foreach ($performances as $row ) {
				if ($first) {
						print "<option selected>";
						$first = false;
					} else {
						print "<option>";
					}
				print $row[performanceDate];
			}
		?>
		</select>		
		<input type=submit value="Select date">
	</form>
</body>
</html>
