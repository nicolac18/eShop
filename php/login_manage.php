<?php

	require("lib.php");
	
	$conn= connessioneDB();

	$nomeutente= $_POST['nomeutente'];
	$password= $_POST['password'];
	
	$queryUtente= "	SELECT NomeUtente, Password
					FROM Utenti
					WHERE NomeUtente= '$nomeutente';";
	$utente= mysql_query($queryUtente, $conn) or die("Query fallita " . mysql_error($conn));
	
	$row= mysql_fetch_assoc($utente);
	
	if ($row['NomeUtente']!= "" && $row['Password']== $password) {
		session_start();

		$_SESSION['nomeutente']= $nomeutente;
		$_SESSION['password']= $password;
		
		$query= "SELECT verificaTipoUtente('$nomeutente');";
		$tipoUtente= mysql_query($query, $conn)  or die("Query fallita " . mysql_error($conn));
		$tipoUtente= mysql_fetch_row($tipoUtente);

		$_SESSION['tipoUtente']= $tipoUtente[0];
		
		$pagina= $_SESSION['pagina'];
		header("Location: ../$pagina");
	}
	
	else
		header("Location: ../login.html");
?>