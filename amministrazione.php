<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">


<head>
	<title>e-Shop Amministrazione</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />
</head>


<?php
	session_start();
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
					<li><a href= "carrello.php">Carrello</a></li>
					<li class= "selezionato"><a href= "amministrazione.php">Amministrazione</a></li>
				</ul>
			</div>
			<div id="push"></div>
		</div>

		<div id="corpo">
			<div id="sx">
				<?php
					if (isset($_SESSION['nomeutente']) && $_SESSION['tipoUtente']== 'a') {
						echo "<li><a href= \"registrazioneadmin.html\">Registra Admin</a></li>";
						echo "<li><a href= \"nuovoprodotto.html\">Inserisci Prodotto</a></li>";
						echo "<li><a href= \"amministrazione.php?link=elimina\">Elimina Prodotto</a></li>";
						echo "<li><a href= \"amministrazione.php?link=modifica\">Modifica Prodotto</a></li>";
						echo "<li><a href= \"amministrazione.php?link=visualizza\">Visualizza Ordini</a></li>";
						echo "<li><a href= \"amministrazione.php?link=conferma\">Conferma Ordini</a></li>";
					}

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

					else if ($_SESSION['tipoUtente']== 'r')
						echo "Area riservata agli Amministratori.";

					else {
						if (!isset($_GET['link'])) {
							echo "	<p>Area Amministrazione</p>
									<p>Benvenuto <i>". $_SESSION['nomeutente']. ".</i></p>";
						}

						else if ($_GET['link']== 'elimina') {
							echo "
								<form action=\"php/deleteproduct.php\" method=\"get\">
								<fieldset>
								<legend>Inserisci Codice Prodotto da Eliminare</legend>					
					
								<p>
								<label for=\"codice\">CodiceID</label>
								<input type=\"text\" id=\"codice\" name=\"codice\">
								</p>

								<p>
								<input type=\"submit\" value=\"Invia\">
								</p>

								</fieldset>
								</form>
								";
						}

						else if ($_GET['link']== 'modifica') {
							echo "
								<form action=\"aggiornaprodotto.php\" method=\"get\">
								<fieldset>
								<legend>Inserisci Codice Prodotto da Modificare</legend>					
					
								<p>
								<label for=\"codice\">CodiceID</label>
								<input type=\"text\" id=\"codice\" name=\"codice\">
								</p>

								<p>
								<input type=\"submit\" value=\"Invia\">
								</p>

								</fieldset>
								</form>
								";
						}

						else if ($_GET['link']== 'visualizza') {
							$queryAcquistiIntest= "	SELECT a.CodiceID, a.Data, a.Carrello, a.Registrato, a.Amministratore
												FROM Acquisti a JOIN Carrelli ca ON a.Carrello=ca.CodiceID JOIN Contiene co ON ca.CodiceID=co.Carrello JOIN Prodotti p ON co.Prodotto=p.CodiceID
												WHERE a.Amministratore IS NOT NULL
												GROUP BY a.CodiceID";
							$acquistiIntest= mysql_query($queryAcquistiIntest, $conn) or die("Query fallita " . mysql_error($conn));

							while ($row= mysql_fetch_row($acquistiIntest)) {
								echo "	<table>
										<tr>
											<th>CodiceID</th>
											<th>Data</th>
											<th>Carrello</th>
											<th>Registrato</th>
											<th>Amministratore</th>
										</tr>";
								echo_row($row);
								
								echo "	</table>
										<table>
											<tr>
												<th>CodiceProdotto</th>
												<th>Nome</th>
												<th>Quantita</th>
											</tr>";
								$codiceAcquisto= $row[0];
								$queryAcquisti= "	SELECT p.CodiceID AS CodiceProdotto, p.Nome, co.Quantita
													FROM Acquisti a JOIN Carrelli ca ON a.Carrello=ca.CodiceID JOIN Contiene co ON ca.CodiceID=co.Carrello JOIN Prodotti p ON co.Prodotto=p.CodiceID
													WHERE a.Amministratore IS NOT NULL AND a.CodiceID=$codiceAcquisto;";
								$acquisti= mysql_query($queryAcquisti, $conn) or die("Query fallita " . mysql_error($conn));

								while ($row2= mysql_fetch_row($acquisti))
									echo_row($row2);

								echo "	</table>
										<p><br /><br /></p>";
							}
						}

						else if ($_GET['link']== 'conferma') {

							$queryAcquistiIntest= "	SELECT a.CodiceID, a.Data, a.Carrello, a.Registrato, a.Amministratore
													FROM Acquisti a JOIN Carrelli ca ON a.Carrello=ca.CodiceID JOIN Contiene co ON ca.CodiceID=co.Carrello JOIN Prodotti p ON co.Prodotto=p.CodiceID
													WHERE a.Amministratore IS NULL
													GROUP BY a.CodiceID;";
							$acquistiIntest= mysql_query($queryAcquistiIntest, $conn) or die("Query fallita " . mysql_error($conn));

							while ($row= mysql_fetch_row($acquistiIntest)) {
								echo "	<table>
										<tr>
											<th>CodiceID</th>
											<th>Data</th>
											<th>Carrello</th>
											<th>Registrato</th>
											<th>Amministratore</th>
										</tr>";
								echo_row($row);
								
								echo "	</table>
										<table>
											<tr>
												<th>CodiceProdotto</th>
												<th>Nome</th>
												<th>Quantita</th>
											</tr>";

								$codiceAcquisto= $row[0];
								$queryAcquisti= "	SELECT p.CodiceID AS CodiceProdotto, p.Nome, co.Quantita
													FROM Acquisti a JOIN Carrelli ca ON a.Carrello=ca.CodiceID JOIN Contiene co ON ca.CodiceID=co.Carrello JOIN Prodotti p ON co.Prodotto=p.CodiceID
													WHERE a.Amministratore IS NULL;";
								$acquisti= mysql_query($queryAcquisti, $conn) or die("Query fallita " . mysql_error($conn));

								while ($row2= mysql_fetch_row($acquisti))
									echo_row($row2);

								echo "	</table>
										<p><br /><br /></p>";
							}

							echo "
								<form action=\"php/confirmpurchase.php\" method=\"get\">
								<fieldset>
								<legend>Inserisci Codice Acquisto da confermare</legend>					
					
								<p>
								<label for=\"codice\">CodiceID</label>
								<input type=\"text\" id=\"codice\" name=\"codice\">
								</p>

								<p>
								<input type=\"submit\" value=\"Invia\">
								</p>

								</fieldset>
								</form>
								";
						}

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
