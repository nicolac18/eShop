DROP VIEW IF EXISTS contaProdotti;
CREATE VIEW contaProdotti (Nome, Conta) AS
	SELECT p.Nome, SUM(co.Quantita)
	FROM Acquisti a JOIN Carrelli ca ON (a.Carrello=ca.CodiceID)
		JOIN Contiene co ON (ca.CodiceID=co.Carrello)
		JOIN Prodotti p ON (co.Prodotto=p.CodiceID)
	GROUP BY p.CodiceID;
	
SELECT Nome, Conta
FROM contaProdotti
WHERE Conta= (SELECT max(Conta) FROM contaProdotti);