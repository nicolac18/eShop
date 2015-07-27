DROP TABLE IF EXISTS Acquisti;

CREATE TABLE Acquisti (
	CodiceID INT PRIMARY KEY,
	Data DATE,
	Carrello INT NOT NULL,
	Registrato VARCHAR (20),
	Amministratore VARCHAR (20),
	
	FOREIGN KEY (Carrello) REFERENCES Carrelli (CodiceID)
		ON DELETE NO ACTION
		ON UPDATE CASCADE,
		
	FOREIGN KEY (Registrato) REFERENCES Registrati (NomeUtente)
		ON DELETE SET NULL
		ON UPDATE CASCADE,
		
	FOREIGN KEY (Amministratore) REFERENCES Amministratori (NomeUtente)		
		ON DELETE SET NULL
		ON UPDATE CASCADE
		
) ENGINE= InnoDB;