<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	
	$db->openConnection();

	$result = $db->getBlockedCookies();
	$db->closeConnection();
?>

<html>
<head><title>Blocked Cookies</title><head>
<body><h1>Blocked Cookies</h1>
	<form method=post action="searchByBlockedCookie.php">
		<select name="cookieName" size=10 width="260" style="width:260px">
		<?php
			$first = true;
			foreach ($result as $row ) {
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
		<input type=submit value="Show pallets">
	</form>

</body>
</html>
