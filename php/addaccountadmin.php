<?php

	session_start();
	
	require("lib.php");
	
	$conn= connessioneDB();

	$nomeutente= trim($_POST['nomeutente']);
	$password= trim($_POST['password']);

	$nome= trim($_POST['nome']);
	$cognome= trim($_POST['cognome']);
	$email= trim($_POST['email']);

	$matricola= $_POST['matricola'];

	$queryAddUtente= "INSERT INTO Utenti VALUES ('$nomeutente', '$password', '$nome', '$cognome', '$email');";
	$addUtente= mysql_query($queryAddUtente, $conn) or die("
					<p>Nome Utente già presente. Inserire un altro nome utente.</p>
					<p>Torna a <a href= \"../registrazioneadmin.html\">Registrazione</a></p>");

	$queryAddAmministratore= "INSERT INTO Amministratori VALUES ('$nomeutente', $matricola);";
	$addAmministratore= mysql_query($queryAddAmministratore, $conn) or die("Query fallita " . mysql_error($conn));

	header("Location: ../amministrazione.php");
?>