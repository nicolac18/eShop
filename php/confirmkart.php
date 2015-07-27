<?php
	session_start();
	require ("lib.php");
	
	$conn= connessioneDB();

	if (isset($_SESSION['nomeutente'])) {
		$queryCodCarrello= "SELECT Carrello FROM Utenti u NATURAL JOIN Registrati r WHERE NomeUtente='". $_SESSION['nomeutente']. "';";
		$codiceCarrello= mysql_query($queryCodCarrello, $conn) or die("Query fallita " . mysql_error($conn));
		$codiceCarrello= mysql_fetch_row($codiceCarrello);

		$queryCarrelloVuoto= "SELECT * FROM Contiene co JOIN Carrelli ca WHERE co.Carrello=ca.CodiceID";
		$carrelloVuoto= mysql_query($queryCarrelloVuoto, $conn) or die("Query fallita " . mysql_error($conn));
		$carrelloVuoto= mysql_fetch_row($carrelloVuoto);

		if (!empty($carrelloVuoto)) {

			$queryCartaVuota= "SELECT Carta FROM Utenti u NATURAL JOIN Registrati r WHERE NomeUtente='". $_SESSION['nomeutente']. "';";
			$cartaVuota= mysql_query($queryCartaVuota, $conn) or die("Query fallita " . mysql_error($conn));
			$cartaVuota= mysql_fetch_row($cartaVuota);

			if (empty($cartaVuota))
				header("Location: ../account.php");

			else {
				$queryAddAcquisto= "INSERT INTO Acquisti VALUES (maxCodAcquisto()+1, now(), ". $codiceCarrello[0]. ", '". $_SESSION['nomeutente']. "', NULL);" ;
				$addAcquisto= mysql_query($queryAddAcquisto, $conn) or die("Query fallita " . mysql_error($conn));
	
				$queryAddCarrello= "INSERT INTO Carrelli VALUES (maxCodCarrello()+1);";
				$addCarrello= mysql_query($queryAddCarrello, $conn) or die("Query fallita " . mysql_error($conn));
	
				$queryUpdateCarrello= "	UPDATE Registrati
										SET Carrello= maxCodCarrello()
										WHERE NomeUtente= '". $_SESSION['nomeutente']. "' ;";
				$updateCarrello= mysql_query($queryUpdateCarrello, $conn) or die("Query fallita " . mysql_error($conn));
	
				echo "<p>Ordine confermato.</p>";
				echo "<br />";
				echo "<p>Torna al <a href= \"../carrello.php\">Carrello</a></p>";
			}
		}

		else
			header("Location: ../carrello.php");
	}
?>