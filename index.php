<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">


<head>
	<title>e-Shop Home</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />
</head>


<?php
	session_start();
	$_SESSION['pagina']= "index.php";
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
					<li class= "selezionato"><a href="index.php">Home</a></li>
					<li><a href= "prodotti.php">Prodotti</a></li>
					<li><a href= "account.php">Account</a></li>
					<li><a href= "carrello.php">Carrello</a></li>
					<li><a href= "amministrazione.php">Amministrazione</a></li>
				</ul>
			</div>
			<div id="push"></div>
		</div>

		<div id="corpo">
			<div id="sx">
				<p>Menu</p>
				<ul>
					<li><a href="prodotti.php">Prodotti</a></li>
					<li><a href="account.php">Account</a></li>
					<li><a href="carrello.php">Carrello</a></li>
					<li><a href="amministrazione.php">Amministrazione</a></li>
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
					echo "<h2>Benvenuto in e-Shop";
					if (isset($_SESSION['nomeutente']))
						echo " <i>". $_SESSION['nomeutente'];
					echo "</i></h2>";
				?>
				<p>Nella pagina Prodotti potrai visualizzare e aggiungere al carrello i prodotti desiderati.</p>
				<p>Nella pagina Account puoi visualizzare il tuo account, modificare le tue informazioni e aggiungere la carta di credito.</p>
				<p>Nel Carrello potrai visualizzare i prodotti aggiunti al carrello, rimuovere quelli non più desiderati e confermare l'acquisto.</p>
			</div>
			
			<div id="push"></div>
		</div>
	
			
		<div id="footer">
			<p>Copyright 2013  |  Pesca eShop  |  Nicola Carraro</p>
		</div>
	</div>
</body>
</html>
