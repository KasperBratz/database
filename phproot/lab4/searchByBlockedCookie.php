<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	
	$db->openConnection();
	$cookieName = $_POST['cookieName'];
	$result = $db->getBlockedPalletsByName($cookieName);
	$db->closeConnection();
?>

<html>
<head><title>Blocked cookies</title><head>
<body><h1>Blocked cookies</h1>
<?php 
	print "Blocked pallets containing ".$cookieName;

?>
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
		<input type=submit value="Show pallet">
	</form>
	<form method = post action = "startPage.php">
		<input type = submit value = "Start page">
	</form>

</body>
</html>
