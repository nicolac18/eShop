DROP TRIGGER IF EXISTS controlloInserimentoCarrello;
CREATE TRIGGER controlloInserimentoCarrello BEFORE INSERT ON Contiene
FOR EACH ROW
BEGIN
	DECLARE pro INT;
	
	SELECT Prodotto INTO pro
	FROM Contiene c JOIN Prodotti p ON c.Prodotto=p.CodiceID
	WHERE p.CodiceID= NEW.Prodotto AND c.Carrello= NEW.Carrello;

	IF (pro IS NOT NULL) THEN
		INSERT INTO Errori VALUE(NULL);
	END IF;
	
	IF (NEW.Quantita<0) THEN
		INSERT INTO Errori VALUE (NULL);
	END IF;
	
END $