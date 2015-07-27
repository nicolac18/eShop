<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">


<head>
	<title>e-Shop Carrello</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />
</head>


<?php
	session_start();
	$_SESSION['pagina']= "carrello.php";
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
					<li><a href= "account.php">Account</a></li>
					<li class= "selezionato"><a href= "carrello.php">Carrello</a></li>
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
					else
						echo_logout();
				?>
			</div>
			
			<div id="centro">
				<?php
					if (!isset($_SESSION['nomeutente']))
						echo "<p>Effettuare login.</p>";
					
					else if ($_SESSION['tipoUtente']== 'r') {

					$utente= $_SESSION['nomeutente'];
					$query= "	SELECT p.CodiceID, p.Nome, p.Prezzo, co.Quantita
								FROM Registrati r JOIN Carrelli ca ON (r.Carrello=ca.CodiceID) JOIN Contiene co ON (ca.CodiceID=co.Carrello) JOIN Prodotti p ON (co.Prodotto=p.CodiceID)
								WHERE r.NomeUtente= '$utente';";
					$prodotti = mysql_query($query, $conn) or die("Query fallita " . mysql_error($conn));
					
					echo "
						<table>
							<tr> 
								<th style=\"width:10%;\">CodID</th>
								<th>Nome</th>
								<th style=\"width:15%;\">Prezzo</th>
								<th style=\"width:10%;\">Q.tà</th>
								<th></th>
							</tr>
						";

					$tot= 0;
					while ($row= mysql_fetch_row($prodotti)) {
						echo_row_carrello($row);
						$tot= $tot+ ($row[2]*$row[3]);
					}
					
					echo "</table> <br />";

					echo "<p style=\"text-align:right;\">Totale Carrello: $tot</p> <br />";

					echo "<p><a href=\"php/confirmkart.php\">Conferma Carrello</a></p>";

					}
					else
						echo "Area riservata agli utenti Registrati.";
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
