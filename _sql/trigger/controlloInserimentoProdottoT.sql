DROP TRIGGER IF EXISTS controlloInsProdotto;
CREATE TRIGGER controlloInsProdotto BEFORE INSERT ON Prodotti
FOR EACH ROW
BEGIN
	DECLARE tip VARCHAR (10);
	DECLARE mar VARCHAR (10);
	
	SELECT Nome INTO tip FROM Tipologie WHERE Nome= NEW.Tipologia;
	IF (tip IS NULL) THEN
		INSERT INTO Tipologie VALUE(NEW.Tipologia);
	END IF;
	

	SELECT Nome INTO mar FROM Marche WHERE Nome= NEW.Marca;
	IF (mar IS NULL) THEN
		INSERT INTO Marche VALUE(NEW.Marca);
	END IF;
	
END $