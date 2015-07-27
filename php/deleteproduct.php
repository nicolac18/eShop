<?php
	session_start();
	require ("lib.php");
	
	$conn= connessioneDB();
		
	$codiceID= $_GET['codice'];

	$queryDelete= "DELETE FROM Prodotti WHERE codiceID= $codiceID;";
	$delete= mysql_query($queryDelete, $conn) or die("Query fallita " . mysql_error($conn));

	header("Location: ../amministrazione.php");
?>
