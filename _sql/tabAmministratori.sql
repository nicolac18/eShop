DROP TABLE IF EXISTS Amministratori;

CREATE TABLE Amministratori (
	NomeUtente VARCHAR (20) PRIMARY KEY,
	Matricola INT,
	
	FOREIGN KEY (NomeUtente) REFERENCES Utenti (NomeUtente)
		ON DELETE CASCADE
		ON UPDATE CASCADE
		
) ENGINE= InnoDB;