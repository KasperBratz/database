<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	
	$db->openConnection();
	$cookieName = $_POST['cookieName'];
	$result = $db->getPalletsByName($cookieName);
	$db->closeConnection();
?>

<html>
<head><title>Search Cookie</title><head>
<body><h1>Pallets containing <?php print $cookieName ?> </h1>

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
