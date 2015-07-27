<?php
	session_start();
	require ("lib.php");
	
	$conn= connessioneDB();

	if (isset($_SESSION['nomeutente'])) {
		if ($_POST['quantita']<=$_POST['disponibilita']) {
			
			$queryCodCarrello="SELECT r.Carrello FROM Utenti u NATURAL JOIN Registrati r WHERE u.NomeUtente='". $_SESSION['nomeutente']. "';";
			$codiceCarrello= mysql_query($queryCodCarrello, $conn) or die("Query fallita " . mysql_error($conn));
			$codiceCarrello= mysql_fetch_row($codiceCarrello);

				$queryAdd= "INSERT INTO Contiene VALUES (". $_POST['codiceID']. ", ". $codiceCarrello[0]. ", ". $_POST['quantita']. ");";
				$aggiungiProdotto=  mysql_query($queryAdd, $conn) or die("
											<p>Prodotto gia' presente nel carrello o Quantita minore di zero.<p>
											<p>Torna alla pagina <a href= \"../prodotti.php\">Prodotti</a></p>");

				$queryUpdate= "UPDATE Prodotti
								SET Quantita=Quantita-". $_POST['quantita'].
								" WHERE codiceID=". $_POST['codiceID']. ";";
				$update= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));

				header("Location: ../carrello.php");
		}

		else {
			echo "Aggiunta al carrello fallita. Inserire una quantità inferiore alla disponibilità in magazzino.";
			echo "<br />";
			echo "<p>Torna alla pagina <a href= \"../prodotti.php\">Prodotti</a></p>";
		}
	}

	else
		header("Location: ../login.html");

?>
