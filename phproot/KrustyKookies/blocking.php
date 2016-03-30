<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	
	$db->openConnection();
	$cookies = $db->getCookies();
	$db->closeConnection();
?>

<html>
<head><title>BlockPallets</title><head>
<body><h1>Block pallets</h1>
	<form method=post action="blockPallets.php">
		<select name="cookieName" size=10 width="260" style="width:260px">
		<?php
			$first = true;
			foreach ($cookies as $row ) {
				if ($first) {
						print "<option selected>";
						$first = false;
					} else {
						print "<option>";
					}
				print $row[cookieName];
			}
		?>
		</select>
		<p>
		Block pallets <p>
		from:
		<input type = "text" size="10" name="min">	
		<p>
		to:
		<input type = "text" size="10" name="max">
		<p>
		<input type=submit value="Block pallets">
	</form>

</body>
</html>
