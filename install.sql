DROP DATABASE IF EXISTS graham_db ;
CREATE DATABASE IF NOT EXISTS graham_db ;

GRANT USAGE ON *.* TO graham@localhost ;
DROP USER graham@localhost ;
CREATE USER graham@localhost IDENTIFIED BY 'test_password' ;

USE graham_db ;

CREATE TABLE application
(
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    job_role VARCHAR(255) NOT NULL,
    UNIQUE KEY person (first_name , last_name , email , job_role)
) ;

REVOKE ALL ON *.* FROM graham@localhost ;
GRANT SELECT , INSERT , UPDATE , DELETE , DROP ON graham_db.application TO graham@localhost ;

DELIMITER //
	CREATE TRIGGER ten_people_only
		BEFORE INSERT
		ON graham_db.application
		FOR EACH ROW
		BEGIN
			DECLARE too_big CONDITION FOR SQLSTATE '01337';
  			SELECT COUNT(*) INTO @count FROM graham_db.application;
  			IF @count > 10 THEN
    			SIGNAL too_big 
    			SET MESSAGE_TEXT = 'Only ten rows allowed!';
  			END IF;
		END //
DELIMITER ;