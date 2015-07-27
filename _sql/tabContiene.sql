DROP TABLE IF EXISTS Contiene;

CREATE TABLE Contiene (
	Prodotto INT,
	Carrello INT,
	Quantita INT NOT NULL,
	
	PRIMARY KEY (Prodotto, Carrello),
	
	FOREIGN KEY (Prodotto) REFERENCES Prodotti	(CodiceID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
		
	FOREIGN KEY (Carrello) REFERENCES Carrelli (CodiceID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
		
) ENGINE= InnoDB;