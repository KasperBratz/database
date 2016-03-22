<html>
<head><title>Search</title><head>
<body><h1>Search</h1>
	Search by:
	<form method=post action="searchByNbr.php">
		<input type=submit value="Pallet Number">
		<input type = "text" size = "10" name="palletNbr">
	</form>
	<form method=post action="searchByCookie.php">
		<input type=submit value="Cookie Name">
		<input type = "text" size = "10" name="cookieName">
	</form>
	<form method=post action="searchByInterval.php">
		<input type=submit value="Time interval">
		from:
		<input type = "text" size = "10" name="min">
		to:
		<input type = "text" size = "10" name="max">
	</form>
	<form method=post action="searchByBlocked.php">
		<input type=submit value="Blocked products">
		
	</form>
	

</body>
</html>
