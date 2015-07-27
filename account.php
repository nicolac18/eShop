<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">


<head>
	<title>e-Shop Account</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />
</head>


<?php
	session_start();
	$_SESSION['pagina']= "account.php";
	require ("php/lib.php");
	
	$conn= connessioneDB();
?>


<body>
	<div class="wrap">
		<div id="header">
			<div id="logo">
				<a href="index.php"><h1>Pesca eShop</h1></a>
				<a href="index.php"><img src="images/logo.png"></a>
			</div>
			<div id="menu">
				<ul>
					<li><a href= "index.php">Home</a></li>
					<li><a href="prodotti.php">Prodotti</a></li>
					<li class= "selezionato"><a href= "account.php">Account</a></li>
					<li><a href= "carrello.php">Carrello</a></li>
					<li><a href= "amministrazione.php">Amministrazione</a></li>
				</ul>
			</div>
			<div id="push"></div>
		</div>

		<div id="corpo">
			<div id="sx">
				<?php
					if (!isset($_SESSION['nomeutente']))
						echo_login();
					else {
						echo "	<ul>
								<li><a href=\"php/deleteaccount.php?elimina=conferma\">Elimina account</a></li>
								</ul>";
						echo_logout();
					}
				?>
			</div>
			
			<div id="centro">
				<?php
					if (!isset($_SESSION['nomeutente']))
						echo "<p>Effettuare login.</p>";

					else {
						$nome= $_SESSION['nomeutente'];
						$tipo;
						if ($_SESSION['tipoUtente']=='a') {
							$tipo= "Amministratori";
							$query= "SELECT *
									 FROM Utenti u NATURAL JOIN $tipo t
									 WHERE t.NomeUtente= '$nome'";
							$informazioni= mysql_query($query, $conn) or die("Query fallita " . mysql_error($conn));
						}

						else if ($_SESSION['tipoUtente']=='r') {
							$tipo= "Registrati";
							$query= "SELECT u.NomeUtente, u.Password, u.Nome, u.Cognome, u.Email, t.Indirizzo, c.Nome AS Citta, c.Provincia, t.Carta
									 FROM Utenti u NATURAL JOIN $tipo t JOIN Citta c ON t.Citta= c.CodiceID
									 WHERE t.NomeUtente= '$nome'";
							$informazioni= mysql_query($query, $conn) or die("Query fallita " . mysql_error($conn));
							
							$info=  mysql_query($query, $conn) or die("Query fallita " . mysql_error($conn));
							$info= mysql_fetch_row($info);

							if (empty($info)) {
								$query= "SELECT u.NomeUtente, u.Password, u.Nome, u.Cognome, u.Email, t.Indirizzo, t.Carta
									 FROM Utenti u NATURAL JOIN $tipo t
									 WHERE t.NomeUtente= '$nome'";
								$informazioni= mysql_query($query, $conn) or die("Query fallita " . mysql_error($conn));
							}
						}
						
						echo "
							<table id= \"account\">
								<tr>
									<th></th>
									<th></th>
									<th>Modifica</th>
									<th></th>
								</tr>
							";
							
						echo_row_account($informazioni);
					
						echo "</table>";
					}
				?>
			</div>
			
			<div id="push"></div>
		</div>
	
			
		<div id="footer">
			<p>Copyright 2013  |  Pesca eShop  |  Nicola Carraro</p>
		</div>
	</div>
</body>
</html>