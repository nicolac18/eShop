<?php
	session_start();
	require ("lib.php");
	
	$conn= connessioneDB();

	if (isset($_SESSION['nomeutente'])) {

		if ($_POST['nomeCampo']== "Password" || $_POST['nomeCampo']== "Nome" || $_POST['nomeCampo']== "Cognome" || $_POST['nomeCampo']== "Email") {
			$queryUpdate="	UPDATE Utenti
							SET ". $_POST['nomeCampo']. "='". trim($_POST['modifica']).
							"' WHERE NomeUtente='". $_SESSION['nomeutente']. "';";
			$aggiorna= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));
		}

		else {
			if ($_SESSION['tipoUtente']=='a') {
				$queryUpdate= " UPDATE Amministratori
								SET ". $_POST['nomeCampo']. "='". trim($_POST['modifica']).
								"' WHERE NomeUtente='". $_SESSION['nomeutente']. "';";
				$aggiorna= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));
			}

			else if ($_SESSION['tipoUtente']=='r') {
				if ($_POST['nomeCampo']!= "Citta") {
					$queryUpdate= "	UPDATE Registrati
									SET ". $_POST['nomeCampo']. "='". trim($_POST['modifica']).
									"' WHERE NomeUtente='". $_SESSION['nomeutente']. "';";
					$aggiorna= mysql_query($queryUpdate, $conn) or die("Query fallita " . mysql_error($conn));
				}

				else {
					aggiorna_citta($_SESSION['nomeutente'], trim($_POST['modifica']), $conn);
				}
			}
		}
		
		header("Location: ../account.php");
	}

?>
