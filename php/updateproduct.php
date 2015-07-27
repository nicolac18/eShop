<?php
	session_start();
	require ("lib.php");
	
	$conn= connessioneDB();

	$queryUpdate="	UPDATE Prodotti
					SET ". $_POST['nomeCampo']. "='". trim($_POST['modifica']).
					"' WHERE CodiceID=". $_POST['codiceID']. ";";
	$aggiorna= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));

	header("Location: ../amministrazione.php");
?>
