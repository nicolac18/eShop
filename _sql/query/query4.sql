SELECT CodiceID, Nome
FROM Prodotti
WHERE CodiceID NOT IN (
	SELECT p.CodiceID
	FROM Prodotti p JOIN Contiene co ON (p.CodiceID=co.Prodotto)
		 JOIN Carrelli ca ON (co.Carrello=ca.CodiceID)
		 JOIN Acquisti a ON (ca.CodiceID=a.Carrello)
	WHERE EXTRACT(YEAR FROM a.Data)>=EXTRACT(YEAR FROM DATE_SUB(CURDATE(),INTERVAL 6 MONTH)) AND
		  EXTRACT(MONTH FROM a.Data)>=EXTRACT(MONTH FROM DATE_SUB(CURDATE(),INTERVAL 6 MONTH))
	);

