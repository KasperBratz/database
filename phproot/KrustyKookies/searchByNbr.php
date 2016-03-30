<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	
	$db->openConnection();
	$palletNbr = $_POST['palletNbr'];
	$pallet = $db->searchByPnbr($palletNbr);
	$customer = $db->findNameFromOrder($palletNbr);
	$db->closeConnection();
?>

<html>
<head><title>Pallet info</title><head>
<body><h1>Pallet info</h1>
	<form method=post action="startPage.php">
		<?php
			if(!empty($pallet)){
				foreach ($pallet as $row ) {
					print "<pre>";
					print "Pallet Number: 		";
					print $row[palletNbr];
					print "<br>";
					print "Content: 		";
					print $row[cookieName];
					print "<br>";
					print "Location: 		";
					if($row[sent]!=true){
						print "Deep-freeze storage";
					}else{
						print "Delivered to ".$customer[0][customerName]; //Add to whom
						print "<br>";
						print "Time Delivered:		".$row[sentDate]; 
					}	
					print "<br>";
					print "Time made:		";
					print $row[timeMade];
					print "<br>";
					print "</pre>";
				}
			}else{
				print "No pallet with id: ".$palletNbr;
				print "<br>";
			}

		?>
		<input type=submit value="Continue">
	</form>

</body>
</html>
