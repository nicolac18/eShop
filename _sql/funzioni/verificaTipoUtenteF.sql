DROP FUNCTION IF EXISTS verificaTipoUtente;
CREATE FUNCTION verificaTipoUtente (nomeUt VARCHAR(10)) RETURNS CHAR(1) 
BEGIN
	DECLARE test VARCHAR(10);
	DECLARE tipo CHAR(1);
	
	SELECT NomeUtente INTO test
	FROM Utenti NATURAL JOIN Registrati
	WHERE NomeUtente= nomeUt;
	
	IF (test IS NOT NULL) THEN SET tipo= 'r';

	ELSE
		SET tipo= 'a';
			
	END IF;
	
	RETURN tipo;
END