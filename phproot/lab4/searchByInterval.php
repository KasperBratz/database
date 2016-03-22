<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	
	$db->openConnection();
	$min = $_POST['min'];
	$max = $_POST['max'];
	$result = $db->getPalletsByInterval($min,$max);
	$db->closeConnection();
?>

<html>
<head><title>Search Interval</title><head>
<body><h1>Pallets produced between <?php print $min . " and " . $max ?></h1>
	<form method=post action="searchByNbr.php">
		<select name="palletNbr" size=10 width="260" style="width:260px">
		<?php
			$first = true;
			foreach ($result as $row ) {
				if ($first) {
						print "<option selected>";
						$first = false;
					} else {
						print "<option>";
					}
				print $row[palletNbr];
			}
		?>
		</select>
		<p>
		<input type=submit value="Show pallet">
	</form>
	<form method = post action = "startPage.php">
		<input type = submit value = "Start page">
	</form>

</body>
</html>
