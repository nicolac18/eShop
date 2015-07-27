DROP FUNCTION IF EXISTS totaleCarrello;
CREATE FUNCTION totaleCarrello (codID INT) RETURNS DECIMAL (4,2)
BEGIN
	DECLARE tot DECIMAL (4,2);
	
	SELECT SUM(p.Prezzo*co.Quantita) INTO tot
	FROM Prodotti p JOIN Contiene co ON p.CodiceID=co.Prodotto JOIN Carrelli ca ON co.Carrello=ca.CodiceID
	WHERE ca.CodiceID=codID;
	
	RETURN tot;
END
		