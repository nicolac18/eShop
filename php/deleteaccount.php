<?php
	session_start();
	require ("lib.php");
	
	$conn= connessioneDB();

	if ($_GET['elimina']== 'conferma') {
		echo "<p>Se vuoi confermare l'eliminazione dell'account clicca <a href= \"deleteaccount.php?elimina=elimina\">qui</a></p>";
	}

	else if ($_GET['elimina']== 'elimina') {

		if ($_SESSION['tipoUtente']== 'r') {

			$queryCodCarrello= "SELECT Carrello FROM Utenti u NATURAL JOIN Registrati r WHERE NomeUtente='". $_SESSION['nomeutente']. "';";
			$codiceCarrello= mysql_query($queryCodCarrello, $conn) or die("Query fallita " . mysql_error($conn));
			$codiceCarrello= mysql_fetch_row($codiceCarrello);

			$queryCarrelloVuoto= "SELECT * FROM Contiene WHERE Carrello= ". $codiceCarrello[0]. ";";
			$carrelloVuoto= mysql_query($queryCarrelloVuoto, $conn) or die("Query fallita " . mysql_error($conn));
			$carrelloVuoto= mysql_fetch_row($carrelloVuoto);

			if (!empty($carrelloVuoto[0])) {
				$queryProdottiCarrello= "SELECT * FROM Contiene co JOIN Carrelli ca ON co.Carrello=ca.CodiceID WHERE ca.CodiceID=". $codiceCarrello[0]. ";";
				$prodottiCarrello= mysql_query($queryProdottiCarrello, $conn) or die("Query fallita " . mysql_error($conn));

				while ($row= mysql_fetch_assoc($prodottiCarrello)) {
					$queryUpdate="	UPDATE Prodotti
									SET Quantita=Quantita+". $row['Quantita'].
									" WHERE codiceID= ". $row['Prodotto']. ";";
					$update= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));
				}
			}

			$queryCancellaUtente= "DELETE FROM Utenti WHERE NomeUtente= '". $_SESSION['nomeutente']. "';";
			$cancellaUtente= mysql_query($queryCancellaUtente, $conn) or die("Query fallita " . mysql_error($conn));

			$queryCancellaCarrello= "DELETE FROM Carrelli WHERE CodiceID=". $codiceCarrello[0]. ";";
			$cancellaCarrello= mysql_query($queryCancellaCarrello, $conn) or die("Query fallita " . mysql_error($conn));
		
		}

		else if ($_SESSION['tipoUtente']== 'a') {
			$queryCancellaUtente= "DELETE FROM Utenti WHERE NomeUtente= '". $_SESSION['nomeutente']. "';";
			$cancellaUtente= mysql_query($queryCancellaUtente, $conn) or die("Query fallita " . mysql_error($conn));
		}

		session_destroy();
		$_SESSION= array();

		header("Location: ../index.php");
	}
?>