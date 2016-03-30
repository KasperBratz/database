<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$cookies = $db->getCookies();
	$db->closeConnection();
?>

<html>
<head><title>Bake cookies</title><head>
<body><h1>Bake cookies</h1>
	Cookies:
	<p>
	<form method=post action="bakeCookies.php">
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
		Number of pallets:
		<input type = "text" size="5" name="amount">		
		<p>
		<input type=submit value="Bake cookies">
	</form>
</body>
</html>
