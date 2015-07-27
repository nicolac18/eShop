<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">


<head>
	<title>e-Shop Prodotti</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />
</head>


<?php
	session_start();
	$_SESSION['pagina']= "prodotti.php";
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
					<li class= "selezionato"><a href="prodotti.php">Prodotti</a></li>
					<li><a href= "account.php">Account</a></li>
					<li><a href= "carrello.php">Carrello</a></li>
					<li><a href= "amministrazione.php">Amministrazione</a></li>
				</ul>
			</div>
			<div id="push"></div>
		</div>

		<div id="corpo">
			<div id="sx">
				<p>Categorie</p>
				<ul>
					<?php
						echo_menu_categorie($conn);
					?>
				</ul>
				
				<?php
					if (!isset($_SESSION['nomeutente']))
						echo_login();
					else
						echo_logout();
				?>
			</div>
			
			<div id="centro">
				
				<?php
				
				if (isset($_GET['nome'])) {
					$categoria= $_GET['nome'];
					$query= "	SELECT p.CodiceID, p.Nome, p.Prezzo, p.Marca, p.Descrizione, p.Quantita
								FROM Prodotti p JOIN Tipologie t ON p.Tipologia= t.Nome
								WHERE p.Tipologia= '$categoria';";
					$prodotti = mysql_query($query, $conn) or die("Query fallita " . mysql_error($conn));
					echo "
						<table id=\"prodotti\">
							<tr> 
								<th style=\"font-size: small;\">Cod</th>
								<th>Nome</th>
								<th>Prezzo</th>
								<th>Marca</th>
								<th>Descrizione</th>
								<th>Disp</th>
								<th>Q.tà</th>
								<th></th>
							</tr>
						";

					while ($row = mysql_fetch_row($prodotti))
						echo_row_prodotti($row);
					
					echo "</table>";
				}
				
				else
					echo "Selezionare una categoria dal menù a sinistra.";
				
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
