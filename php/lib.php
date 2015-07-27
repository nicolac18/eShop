<?php
	
	if (!isset($_SESSION)) {
		session_start();
	}

// SELEZIONE DATABASE
function connessioneDB() {
	$host= "localhost";
	$user= "root";
	$pwd= "root";
	
	$conn= mysql_connect($host, $user, $pwd) or die($_SERVER['PHP_SELF'] . " Connessione fallita!");
	
	$dbname= "ncarraro";

	mysql_select_db($dbname);
	
	return $conn;
};

//STAMPA TABELLA
function echo_row($row) {
	echo "<tr>";
	foreach ($row as $field) 
		echo "<td>$field</td>";
	echo "</tr>";
};

//STAMPA TABELLA PRODOTTI
function echo_row_prodotti($row) {
	echo "<form action=\"php/addtokart.php\" method=\"post\"> <fieldset>";
	echo "<tr>";
	foreach ($row as $field) 
		echo "<td>$field</td>";
	echo "<td style= \"text-align: center;\"><input style=\"width:30px;\" type=\"text\" id=\"quantita\" name=\"quantita\"></td>";
	echo "<td style= \"text-align: center;\"><input style=\"border:0;\" type=\"image\" src=\"images/kart.jpg\"></td>";
	echo "</tr>";
	echo "<input type=\"hidden\" name=\"disponibilita\" value=\"". $row[5]. "\">";
	echo "<input type=\"hidden\" name=\"codiceID\" value=\"". $row[0]. "\"> </fieldset> </form>";
};

function echo_row_prodotti_admin($row) {
	
}

//STAMPA TABELLE ACCOUNT
function echo_row_account($query) {
	$num_colonne= mysql_num_fields($query);
	$i= 0;
	$row= mysql_fetch_row($query);
	while ($i<$num_colonne) {
		echo "<form action=\"php/updateaccount.php\" method=\"post\"> <fieldset>";
		echo "<tr>";
		echo "<td style= \"font-style: italic;\">". mysql_field_name($query, $i). ":</td>";
		echo "<td>". $row[$i]. "</td>";
		echo "<td>";
			if ($i!= 0 && $i!= 7)
				echo "<input type=\"text\" id=\"modifica\" name=\"modifica\">";
			echo "</td>";
		echo "<td style= \"text-align: center;\">";
			if ($i!= 0 && $i!= 7)
				echo "<input style=\"border:0; width:25px;\" type=\"image\" src=\"images/ok.jpg\">";
			echo "</td>";
		echo "</tr>";
		echo "<input type=\"hidden\" name=\"nomeCampo\" value=\"". mysql_field_name($query, $i). "\"> </fieldset> </form>";
		$i= $i+1;
	}

	if ($_SESSION['tipoUtente']== 'r' && $num_colonne< 8) {
		echo "<form action=\"php/updateaccount.php\" method=\"post\"> <fieldset>";
		echo "<tr>";
		echo "<td style= \"font-style: italic;\">Citta:</td>";
		echo "<td></td>";
		echo "<td><input type=\"text\" id=\"modifica\" name=\"modifica\"></td>";
		echo "<td style= \"text-align: center;\"><input style=\"border:0; width:25px;\" type=\"image\" src=\"images/ok.jpg\"></td>";
		echo "</tr>";
		echo "<input type=\"hidden\" name=\"nomeCampo\" value=\"Citta\"> </fieldset> </form>";
		echo "<tr><td style= \"font-style: italic;\">Provincia:</td>";
		echo "<td></td><td></td><td></td></tr>";
	}
};

//STAMPA TABELLE MODIFICA PRODOTTI
function echo_row_prodotti_amm($query) {
	$num_colonne= mysql_num_fields($query);
	$i= 0;
	$row= mysql_fetch_row($query);
	while ($i<$num_colonne) {
		echo "<form action=\"php/updateproduct.php\" method=\"post\"> <fieldset>";
		echo "<tr>";
		echo "<td style= \"font-style: italic;\">". mysql_field_name($query, $i). ":</td>";
		echo "<td>". $row[$i]. "</td>";
		echo "<td>";
			if ($i!= 0)
				echo "<input type=\"text\" id=\"modifica\" name=\"modifica\">";
			echo "</td>";
		echo "<td style= \"text-align: center;\">";
			if ($i!= 0)
				echo "<input style=\"border:0; width:25px;\" type=\"image\" src=\"images/ok.jpg\">";
			echo "</td>";
		echo "</tr>";
		echo "<input type=\"hidden\" name=\"codiceID\" value=\"". $row[0]. "\">";
		echo "<input type=\"hidden\" name=\"nomeCampo\" value=\"". mysql_field_name($query, $i). "\"> </fieldset> </form>";
		$i= $i+1;
	}
};

//STAMPA TABELLA CARRELLO
function echo_row_carrello($row) {
	echo "<form action=\"php/removefromkart.php\" method=\"post\"> <fieldset>";
	echo "<tr>";
	foreach ($row as $field) 
		echo "<td>$field</td>";
	echo "<td style= \"text-align: center;\"><input style=\"border:0;\" type=\"image\" src=\"images/delete.jpg\"></td>";
	echo "</tr>";
	echo "<input type=\"hidden\" name=\"codiceID\" value=\"". $row[0]. "\">";
	echo "<input type=\"hidden\" name=\"quantita\" value=\"". $row[3]. "\"> </fieldset> </form>";
};

//STAMPA MENU CATEGORIE
function echo_menu_categorie($conn) {
	$query= "SELECT * FROM Tipologie;";
	$categorie= mysql_query($query, $conn) or die("Query fallita " . mysql_error($conn));
	$num_righe= mysql_num_rows($categorie);
	if (!$num_righe)
		echo "<li> vuoto <li>";
	else
 		while ($row= mysql_fetch_assoc($categorie)) {
 			$url= "prodotti.php?nome=". urlencode($row['Nome']);
 			$row['Nome']= "<a href= \" $url \">". ucwords($row['Nome']). "</a>";
 			$tmp= $row['Nome'];
 			echo "<li> $tmp </li>";
 		}
};

//STAMPA LINK LOGIN
function echo_login() {
	echo "	<ul id= \"log\">
				<li><a href=\"login.html\">Login</a></li>
			</ul>";
};

//STAMPA LINK LOGOUT
function echo_logout() {
	echo "	<ul id= \"log\">
				<li><a href=\"logout.php\">Logout</a></li>
			</ul>";
};

//AGGIORNA CITTA
function aggiorna_citta($nomeutente, $citta, $conn) {
	$queryTrovaCitta= "	SELECT CodiceID
						FROM Citta
						WHERE Nome='$citta';";
	$trovaCitta= mysql_query($queryTrovaCitta, $conn) or die("Query fallita " . mysql_error($conn));
	$trovaCitta= mysql_fetch_row($trovaCitta);
	if (!empty($trovaCitta)) {
		$queryUpdate= "	UPDATE Registrati
						SET Citta= '". $trovaCitta[0].
						"' WHERE NomeUtente='$nomeutente';";
		$aggiorna= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));
	}
	else {
		$queryMaxCitta= "SELECT MAX(CodiceID) FROM Citta;";
		$maxCitta= mysql_query($queryMaxCitta, $conn) or die("Query fallita " . mysql_error($conn));
		$maxCitta= mysql_fetch_row($maxCitta);
		$idCitta= $maxCitta[0]+ 1;

		$queryInserisciCitta= "INSERT INTO Citta VALUES ($idCitta, '$citta', NULL);";
		$inserisciCitta= mysql_query($queryInserisciCitta, $conn) or die("Query fallita " . mysql_error($conn));

		$queryUpdate="	UPDATE Registrati
						SET Citta= '$idCitta'
						WHERE NomeUtente='$nomeutente';";
		$aggiorna= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));
	}
};
