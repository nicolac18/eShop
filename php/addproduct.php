<?php

	session_start();
	require("lib.php");
	
	$conn= connessioneDB();

	$nome= trim($_POST['nome']);
	$prezzo= trim($_POST['prezzo']);
	$quantita= trim($_POST['quantita']);
	$marca= trim($_POST['marca']);
	$tipologia= trim($_POST['tipologia']);
	$descrizione= $_POST['descrizione'];
	$immagine= trim($_POST['immagine']);

	$queryAdd= "INSERT INTO Prodotti VALUES (maxCodProdotto()+1, '$nome', '$prezzo', '$quantita', '$marca', '$tipologia', '$descrizione', '$immagine')";
	$add= mysql_query($queryAdd, $conn)  or die("Query fallita " . mysql_error($conn));
	
	header("Location: ../amministrazione.php");

?>