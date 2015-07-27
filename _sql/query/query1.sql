SELECT count(*) AS NCarrelli
FROM Carrelli c JOIN Acquisti a ON c.CodiceID= a.Carrello
WHERE a.Amministratore IS NOT NULL AND a.Data>= "2012-06-01" AND a.Data<= "2012-12-31";