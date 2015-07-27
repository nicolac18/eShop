<?php
	session_start();
	require ("lib.php");
	
	$conn= connessioneDB();

	if (isset($_SESSION['nomeutente'])) {

		$codiceAcquisto= $_GET['codice'];

		$queryConfermaAcquisto= "	UPDATE Acquisti
									SET Amministratore= '". $_SESSION['nomeutente']. "'
									WHERE CodiceID= $codiceAcquisto;";
		$confermaAcquisto= mysql_query($queryConfermaAcquisto, $conn) or die("Query fallita " . mysql_error($conn));

		echo "<p>Acquisto confermato.</p>";
		echo "<br />";
		echo "<p>Torna al <a href= \"../amministrazione.php\">Amministrazione</a></p>";
		}

	else
		header("Location: ../amministrazione.php");
?>