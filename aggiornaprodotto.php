<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">


<?php
	session_start();
	$_SESSION['pagina']= "account.php";
	require ("php/lib.php");
	
	$conn= connessioneDB();
?>


<head>
	<title>e-Shop Amministrazione</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />
</head>

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
					<li><a href= "carrello.php">Carrello</a></li>
					<li><a href= "amministrazione.php">Amministrazione</a></li>
				</ul>
			</div>
			<div id="push"></div>
		</div>

		<div id="corpo">
			<div id="sx">
				<p>Aggiorna Prodotto</p>
			</div>
			
			<div id="centro">
				
				<?php
					$codiceID= $_GET['codice'];
					$queryProdotto= "SELECT * FROM Prodotti WHERE CodiceID= $codiceID";
					$prodotto= mysql_query($queryProdotto, $conn) or die("Query fallita " . mysql_error($conn));

					echo "
							<table id= \"account\">
								<tr>
									<th></th>
									<th></th>
									<th>Modifica</th>
									<th></th>
								</tr>
							";
								
					echo_row_prodotti_amm($prodotto);
					
					echo "</table>";

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