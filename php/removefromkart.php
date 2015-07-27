<?php
	session_start();
	require ("lib.php");
	
	$conn= connessioneDB();

	if (isset($_SESSION['nomeutente'])) {
		
		$queryUpdate="	UPDATE Prodotti
						SET Quantita=Quantita+". $_POST['quantita'].
						" WHERE codiceID= ". $_POST['codiceID']. ";";
		$update= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));

		$queryCodCarrello=" SELECT Carrello FROM Utenti u NATURAL JOIN Registrati r WHERE NomeUtente='". $_SESSION['nomeutente']. "';";
		$codiceCarrello= mysql_query($queryCodCarrello, $conn) or die("Query fallita " . mysql_error($conn));
		$codiceCarrello= mysql_fetch_row($codiceCarrello);

		$queryRemove="	DELETE FROM Contiene WHERE (Prodotto=". $_POST['codiceID']. " AND Carrello=". $codiceCarrello[0]. ");";
		$rimuoviProdotto=  mysql_query($queryRemove, $conn) or die("Query fallita " . mysql_error($conn));

		header("Location: ../carrello.php");
	}
?>
