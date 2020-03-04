
-- TRIGGERS y procedimientos asociados.

CREATE OR REPLACE FUNCTION "smartpoke".update_radpostauth()
    RETURNS trigger
    LANGUAGE 'plpgsql'
AS $BODY$
    BEGIN
        NEW.authdate := current_timestamp;
        RETURN NEW;
    END;
$BODY$;


-- Trigger: update_radpostauth

-- DROP TRIGGER update_radpostauth ON "eatoutg".radpostauth;

CREATE TRIGGER update_radpostauth
    BEFORE UPDATE
    ON "smartpoke".radpostauth
    FOR EACH ROW
    EXECUTE PROCEDURE "smartpoke".update_radpostauth();

-----   FIN TRIGGER

CREATE OR REPLACE FUNCTION "smartpoke".update_radacct()
    RETURNS trigger
    LANGUAGE 'plpgsql'
AS $BODY$
    BEGIN
	--- cuando modifico un registro del radacct, debo modificar el trafico de rs_userdevice
		UPDATE "smartpoke".rs_userdevice
			SET traffic= traffic + (COALESCE(NEW.acctinputoctets,0)-COALESCE(OLD.acctinputoctets,0)) +
			                       (COALESCE(NEW.acctoutputoctets,0)-COALESCE(OLD.acctoutputoctets,0))
			WHERE rs_userdevice.callingstationid = new.callingstationid;
        RETURN NULL;
    END;
$BODY$;


-- Trigger: update_radacct

-- DROP TRIGGER update_radacct ON "smartpoke".radacct;

CREATE TRIGGER update_radacct
    AFTER UPDATE
    ON "smartpoke".radacct
    FOR EACH ROW
    EXECUTE PROCEDURE "smartpoke".update_radacct();

-----   FIN TRIGGER


CREATE OR REPLACE FUNCTION "smartpoke".insert_radacct()
    RETURNS trigger
    LANGUAGE 'plpgsql'
AS $BODY$
    BEGIN
	--- cuando creo un registro del radacct, debo crear uno de rs_userdevice o modificar el que ya exista
	   BEGIN
		 INSERT INTO "smartpoke".rs_userdevice(
				username, callingstationid, traffic)
				VALUES (new.username, new.callingstationid, COALESCE(NEW.acctinputoctets,0) + COALESCE(NEW.acctoutputoctets,0));
       EXCEPTION
	     WHEN OTHERS THEN
		    UPDATE "smartpoke".rs_userdevice
				SET traffic= traffic + COALESCE(NEW.acctinputoctets,0) + COALESCE(NEW.acctoutputoctets,0)
				WHERE rs_userdevice.callingstationid = new.callingstationid;
	   END;
	   RETURN NULL;
    END;
$BODY$;


-- Trigger: insert_radacct

-- DROP TRIGGER insert_radacct ON "smartpoke".radpostauth;

CREATE TRIGGER insert_radacct
    AFTER INSERT
    ON "smartpoke".radacct
    FOR EACH ROW
    EXECUTE PROCEDURE "smartpoke".insert_radacct();


-----   FIN TRIGGER