<?php

	require("lib.php");
	
	$conn= connessioneDB();

	$nomeutente= trim($_POST['nomeutente']);
	$password= trim($_POST['password']);

	$nome= trim($_POST['nome']);
	$cognome= trim($_POST['cognome']);
	$email= trim($_POST['email']);

	$indirizzo= $_POST['indirizzo'];
	$citta= trim($_POST['citta']);
	$carta= trim($_POST['carta']);

	$queryAddUtente= "INSERT INTO Utenti VALUES ('$nomeutente', '$password', '$nome', '$cognome', '$email');";
	$addUtente= mysql_query($queryAddUtente, $conn) or die("
					<p>Nome Utente già presente. Inserire un altro nome utente.</p>
					<p>Torna a <a href= \"../registrazione.html\">Registrazione</a></p>");

	$queryAddCarrello= "INSERT INTO Carrelli VALUES (maxCodCarrello()+1);";
	$addCarrello= mysql_query($queryAddCarrello, $conn) or die("Query fallita " . mysql_error($conn));

	$queryAddRegistrato= "INSERT INTO Registrati VALUES ('$nomeutente', '$indirizzo', NULL, '$carta', maxCodCarrello());";
	$addRegistrato= mysql_query($queryAddRegistrato, $conn) or die("Query fallita " . mysql_error($conn));

	aggiorna_citta($nomeutente, $citta, $conn);

	session_start();

	$_SESSION['tipoUtente']= 'r';
	$_SESSION['nomeutente']= $nomeutente;
	$_SESSION['password']= $password;

	header("Location: ../account.php");
?>