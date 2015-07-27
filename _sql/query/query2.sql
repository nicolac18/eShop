DROP VIEW IF EXISTS sommaTotali;
CREATE VIEW sommaTotali (CodiceID, Totale) AS
	SELECT ca.CodiceID, SUM(p.Prezzo*co.Quantita)
	FROM Prodotti p JOIN Contiene co ON(p.CodiceID=co.Prodotto)
		JOIN Carrelli ca ON (co.Carrello=ca.CodiceID)
	WHERE ca.CodiceID IN (
		SELECT Carrello
		FROM Acquisti)
	GROUP BY ca.CodiceID;
	
SELECT r.NomeUtente, max(st.Totale) AS SpesaMaggiore
FROM sommaTotali st JOIN Acquisti a ON (st.CodiceID=a.Carrello) JOIN Registrati r ON (a.Registrato=r.NomeUtente)
GROUP BY r.NomeUtente;
	