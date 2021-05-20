--- TUTORIAL INSTALARE Oracle 12c
https://www.youtube.com/watch?v=DCafeAz9aJ0

-- TUTORIAL CREARE USER din SQL Developer 
https://www.youtube.com/watch?v=58V-w3buWm4&t=305s

(daca la creare user aveti eroarea: "ORA-65096: invalid common user or role name", folositi comanda de mai jos)
alter session set "_ORACLE_SCRIPT"=true;  

--// -------------- REGION -------------- //



--creare tabel
CREATE TABLE "REGION" 
	(	
	"ID_REGION" NUMBER, 
	"NAME" VARCHAR2(80)
	) ;
   
CREATE UNIQUE INDEX "REGION_UK1" ON "REGION" ("NAME");
CREATE UNIQUE INDEX "REGION_PK" ON "REGION" ("ID_REGION");
ALTER TABLE "REGION" MODIFY ("ID_REGION" NOT NULL ENABLE);
ALTER TABLE "REGION" MODIFY ("NAME" NOT NULL ENABLE);
ALTER TABLE "REGION" ADD CONSTRAINT "REGION_PK" PRIMARY KEY ("ID_REGION")
	USING INDEX  ENABLE;
ALTER TABLE "REGION" ADD CONSTRAINT "REGION_UK1" UNIQUE ("NAME")
	USING INDEX  ENABLE;

-- creare secventa
CREATE SEQUENCE  "REGION_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;

-- creare trigger
CREATE OR REPLACE TRIGGER "REGION_TRG" 
	  BEFORE INSERT OR UPDATE ON REGION
	  FOR EACH ROW
DECLARE
	  ICOUNTER REGION.ID_REGION%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT REGION_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_REGION:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_REGION=:OLD.ID_REGION) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/



-- -------------- CITY -------------- --

-- creare tabel
CREATE TABLE "CITY" 
	(	
	"ID_CITY" NUMBER, 
	"ID_REGION" NUMBER, 
	"NAME" VARCHAR2(160)
	) ;
 
CREATE UNIQUE INDEX "CITY_UK1" ON "CITY" ("ID_REGION", "NAME");
CREATE UNIQUE INDEX "CITY_PK" ON "CITY" ("ID_CITY");
ALTER TABLE "CITY" MODIFY ("ID_CITY" NOT NULL ENABLE);
ALTER TABLE "CITY" MODIFY ("ID_REGION" NOT NULL ENABLE);
ALTER TABLE "CITY" MODIFY ("NAME" NOT NULL ENABLE);
ALTER TABLE "CITY" ADD CONSTRAINT "CITY_PK" PRIMARY KEY ("ID_CITY")
	USING INDEX  ENABLE;
ALTER TABLE "CITY" ADD CONSTRAINT "CITY_UK1" UNIQUE ("ID_REGION", "NAME")
	USING INDEX  ENABLE;
  
-- creare secventa
CREATE SEQUENCE  "CITY_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;

-- creare trigger
CREATE OR REPLACE TRIGGER "CITY_TRG" 
	  BEFORE INSERT OR UPDATE ON CITY
	  FOR EACH ROW
DECLARE
	  ICOUNTER CITY.ID_CITY%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT CITY_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_CITY:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_CITY=:OLD.ID_CITY) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- VEHICLE_BRAND -------------- --

-- creare tabel
CREATE TABLE "VEHICLE_BRAND" 
	(	
	"ID_VEHICLE_BRAND" NUMBER, 
	"NAME" VARCHAR2(80)
	) ;
	
CREATE UNIQUE INDEX "VEHICLE_BRAND_PK" ON "VEHICLE_BRAND" ("ID_VEHICLE_BRAND");
CREATE UNIQUE INDEX "VEHICLE_BRAND_UK1" ON "VEHICLE_BRAND" ("NAME");
ALTER TABLE "VEHICLE_BRAND" MODIFY ("ID_VEHICLE_BRAND" NOT NULL ENABLE);
ALTER TABLE "VEHICLE_BRAND" MODIFY ("NAME" NOT NULL ENABLE);
ALTER TABLE "VEHICLE_BRAND" ADD CONSTRAINT "VEHICLE_BRAND_PK" PRIMARY KEY ("ID_VEHICLE_BRAND")
	USING INDEX  ENABLE;
ALTER TABLE "VEHICLE_BRAND" ADD CONSTRAINT "VEHICLE_BRAND_UK1" UNIQUE ("NAME")
	USING INDEX  ENABLE;

--creare secventa
CREATE SEQUENCE  "VEHICLE_BRAND_SEQ"  
MINVALUE 1 
MAXVALUE 99999999999999 
INCREMENT BY 1 START WITH 1 
NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;

--creare trigger
  CREATE OR REPLACE TRIGGER "VEHICLE_BRAND_TRG" 
          BEFORE INSERT OR UPDATE ON VEHICLE_BRAND
          FOR EACH ROW
DECLARE
          ICOUNTER VEHICLE_BRAND.ID_VEHICLE_BRAND%TYPE;
          CANNOT_CHANGE_COUNTER EXCEPTION;
          BEGIN
          IF INSERTING THEN
          SELECT VEHICLE_BRAND_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
          :NEW.ID_VEHICLE_BRAND:=ICOUNTER;
          END IF;
          IF UPDATING THEN
          IF NOT(:NEW.ID_VEHICLE_BRAND=:OLD.ID_VEHICLE_BRAND) THEN
          RAISE CANNOT_CHANGE_COUNTER;
          END IF;
          END IF;
          EXCEPTION
          WHEN CANNOT_CHANGE_COUNTER THEN
          RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- VEHICLE_MODEL -------------- --

-- creare tabel
CREATE TABLE "VEHICLE_MODEL" 
	(	
	"ID_VEHICLE_MODEL" NUMBER, 
	"ID_VEHICLE_BRAND" NUMBER, 
	"NAME" VARCHAR2(80)
	) ;

CREATE UNIQUE INDEX "VEHICLE_MODEL_PK" ON "VEHICLE_MODEL" ("ID_VEHICLE_MODEL");
CREATE UNIQUE INDEX "VEHICLE_MODEL_UK1" ON "VEHICLE_MODEL" ("ID_VEHICLE_BRAND", "NAME");
ALTER TABLE "VEHICLE_MODEL" MODIFY ("ID_VEHICLE_MODEL" NOT NULL ENABLE);
ALTER TABLE "VEHICLE_MODEL" MODIFY ("ID_VEHICLE_BRAND" NOT NULL ENABLE);
ALTER TABLE "VEHICLE_MODEL" ADD CONSTRAINT "VEHICLE_MODEL_PK" PRIMARY KEY ("ID_VEHICLE_MODEL")
	USING INDEX  ENABLE;
ALTER TABLE "VEHICLE_MODEL" ADD CONSTRAINT "VEHICLE_MODEL_UK1" UNIQUE ("ID_VEHICLE_BRAND", "NAME")
	USING INDEX  ENABLE;

--creare secventa
CREATE SEQUENCE  "VEHICLE_MODEL_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;

--creare trigger
CREATE OR REPLACE TRIGGER "VEHICLE_MODEL_TRG" 
	  BEFORE INSERT OR UPDATE ON VEHICLE_MODEL
	  FOR EACH ROW
DECLARE
	  ICOUNTER VEHICLE_MODEL.ID_VEHICLE_MODEL%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT VEHICLE_MODEL_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_VEHICLE_MODEL:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_VEHICLE_MODEL=:OLD.ID_VEHICLE_MODEL) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- VEHICLE -------------- --

-- creare tabel
CREATE TABLE "VEHICLE" 
	(	"ID_VEHICLE" NUMBER, 
	"ID_VEHICLE_MODEL" NUMBER, 
	"PLATE" VARCHAR2(10), 
	"VIN" VARCHAR2(17), 
	"COLOR" VARCHAR2(30)
	) ;
	
CREATE UNIQUE INDEX "VEHICLE_PK" ON "VEHICLE" ("ID_VEHICLE");
CREATE UNIQUE INDEX "VEHICLE_UK1" ON "VEHICLE" ("VIN");
CREATE UNIQUE INDEX "VEHICLE_UK2" ON "VEHICLE" ("PLATE");
ALTER TABLE "VEHICLE" MODIFY ("ID_VEHICLE" NOT NULL ENABLE);
ALTER TABLE "VEHICLE" MODIFY ("ID_VEHICLE_MODEL" NOT NULL ENABLE);
ALTER TABLE "VEHICLE" MODIFY ("PLATE" NOT NULL ENABLE);
ALTER TABLE "VEHICLE" ADD CONSTRAINT "VEHICLE_PK" PRIMARY KEY ("ID_VEHICLE")
	USING INDEX  ENABLE;
ALTER TABLE "VEHICLE" ADD CONSTRAINT "VEHICLE_UK1" UNIQUE ("VIN")
	USING INDEX  ENABLE;
ALTER TABLE "VEHICLE" ADD CONSTRAINT "VEHICLE_UK2" UNIQUE ("PLATE")
	USING INDEX  ENABLE;
	
--creare secventa
CREATE SEQUENCE  "VEHICLE_SEQ"  
MINVALUE 1 
MAXVALUE 99999999999999 
INCREMENT BY 1 START WITH 1 
NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;

--creare trigger
  CREATE OR REPLACE TRIGGER "VEHICLE_TRG" 
          BEFORE INSERT OR UPDATE ON VEHICLE
          FOR EACH ROW
DECLARE
          ICOUNTER VEHICLE.ID_VEHICLE%TYPE;
          CANNOT_CHANGE_COUNTER EXCEPTION;
          BEGIN
          IF INSERTING THEN
          SELECT VEHICLE_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
          :NEW.ID_VEHICLE:=ICOUNTER;
          END IF;
          IF UPDATING THEN
          IF NOT(:NEW.ID_VEHICLE=:OLD.ID_VEHICLE) THEN
          RAISE CANNOT_CHANGE_COUNTER;
          END IF;
          END IF;
          EXCEPTION
          WHEN CANNOT_CHANGE_COUNTER THEN
          RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- DRIVER -------------- --

-- creare tabel
CREATE TABLE "DRIVER" 
	(	
	"ID_DRIVER" NUMBER, 
	"FIRST_NAME" VARCHAR2(80), 
	"LAST_NAME" VARCHAR2(80), 
	"CNP" NUMBER, 
	"PHONE" VARCHAR2(11)
	) ;
	
CREATE UNIQUE INDEX "DRIVER_UK1" ON "DRIVER" ("CNP");
CREATE UNIQUE INDEX "DRIVER_PK" ON "DRIVER" ("ID_DRIVER");
ALTER TABLE "DRIVER" MODIFY ("ID_DRIVER" NOT NULL ENABLE);
ALTER TABLE "DRIVER" MODIFY ("FIRST_NAME" NOT NULL ENABLE);
ALTER TABLE "DRIVER" MODIFY ("LAST_NAME" NOT NULL ENABLE);
ALTER TABLE "DRIVER" MODIFY ("PHONE" NOT NULL ENABLE);
ALTER TABLE "DRIVER" ADD CONSTRAINT "DRIVER_PK" PRIMARY KEY ("ID_DRIVER")
	USING INDEX  ENABLE;
ALTER TABLE "DRIVER" MODIFY ("CNP" NOT NULL ENABLE);
ALTER TABLE "DRIVER" ADD CONSTRAINT "DRIVER_UK1" UNIQUE ("CNP")
	USING INDEX  ENABLE;

--creare secventa
CREATE SEQUENCE  "DRIVER_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;

--creare trigger
CREATE OR REPLACE TRIGGER "DRIVER_TRG" 
	  BEFORE INSERT OR UPDATE ON DRIVER
	  FOR EACH ROW
DECLARE
	  ICOUNTER DRIVER.ID_DRIVER%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT DRIVER_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_DRIVER:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_DRIVER=:OLD.ID_DRIVER) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- DRIVER_VEHICLE -------------- --

-- creare tabel
CREATE TABLE "DRIVER_VEHICLE" 
	(	
	"ID_DRIVER_VEHICLE" NUMBER, 
	"ID_DRIVER" NUMBER, 
	"ID_VEHICLE" NUMBER
	) ;

CREATE UNIQUE INDEX "DRIVER_VEHICLE_PK" ON "DRIVER_VEHICLE" ("ID_DRIVER_VEHICLE");
ALTER TABLE "DRIVER_VEHICLE" MODIFY ("ID_DRIVER_VEHICLE" NOT NULL ENABLE);
ALTER TABLE "DRIVER_VEHICLE" MODIFY ("ID_DRIVER" NOT NULL ENABLE);
ALTER TABLE "DRIVER_VEHICLE" MODIFY ("ID_VEHICLE" NOT NULL ENABLE);
ALTER TABLE "DRIVER_VEHICLE" ADD CONSTRAINT "DRIVER_VEHICLE_PK" PRIMARY KEY ("ID_DRIVER_VEHICLE")
	USING INDEX  ENABLE;

--creare secventa
CREATE SEQUENCE  "DRIVER_VEHICLE_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;

-- creare trigger
CREATE OR REPLACE TRIGGER "DRIVER_VEHICLE_TRG" 
	  BEFORE INSERT OR UPDATE ON DRIVER_VEHICLE
	  FOR EACH ROW
DECLARE
	  ICOUNTER DRIVER_VEHICLE.ID_DRIVER_VEHICLE%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT DRIVER_VEHICLE_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_DRIVER_VEHICLE:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_DRIVER_VEHICLE=:OLD.ID_DRIVER_VEHICLE) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- STATUS -------------- --

-- creare tabel
CREATE TABLE "STATUS" 
	(	
	"ID_STATUS" NUMBER, 
	"DESCRIPTION" VARCHAR2(80)
	) ;
	
CREATE UNIQUE INDEX "STATUS_PK" ON "STATUS" ("ID_STATUS");   
CREATE UNIQUE INDEX "STATUS_UK1" ON "STATUS" ("DESCRIPTION");
ALTER TABLE "STATUS" MODIFY ("ID_STATUS" NOT NULL ENABLE);
ALTER TABLE "STATUS" MODIFY ("DESCRIPTION" NOT NULL ENABLE);
ALTER TABLE "STATUS" ADD CONSTRAINT "STATUS_PK" PRIMARY KEY ("ID_STATUS")
	USING INDEX  ENABLE;
ALTER TABLE "STATUS" ADD CONSTRAINT "STATUS_UK1" UNIQUE ("DESCRIPTION")
	USING INDEX  ENABLE;
	
-- -------------- CLIENT -------------- --

-- creare tabel
CREATE TABLE "CLIENT" 
	(	"ID_CLIENT" NUMBER, 
	"FIRST_NAME" VARCHAR2(60), 
	"LAST_NAME" VARCHAR2(60), 
	"PHONE" VARCHAR2(11), 
	"ID_CITY" NUMBER, 
	"ADDRESS" VARCHAR2(150), 
	"POSTAL_CODE" VARCHAR2(20), 
	"EMAIL" VARCHAR2(50)
	) ;

CREATE UNIQUE INDEX "CLIENT_PK" ON "CLIENT" ("ID_CLIENT") ;
ALTER TABLE "CLIENT" MODIFY ("ID_CLIENT" NOT NULL ENABLE);
ALTER TABLE "CLIENT" MODIFY ("FIRST_NAME" NOT NULL ENABLE);
ALTER TABLE "CLIENT" MODIFY ("LAST_NAME" NOT NULL ENABLE);
ALTER TABLE "CLIENT" MODIFY ("PHONE" NOT NULL ENABLE);
ALTER TABLE "CLIENT" ADD CONSTRAINT "CLIENT_PK" PRIMARY KEY ("ID_CLIENT")
	USING INDEX  ENABLE;
	
--creare secventa
CREATE SEQUENCE  "CLIENT_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;

--creare trigger
CREATE OR REPLACE TRIGGER "CLIENT_TRG" 
	  BEFORE INSERT OR UPDATE ON CLIENT
	  FOR EACH ROW
DECLARE
	  ICOUNTER CLIENT.ID_CLIENT%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT CLIENT_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_CLIENT:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_CLIENT=:OLD.ID_CLIENT) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/  
  
-- -------------- INVOICE -------------- --

-- creare tabel
CREATE TABLE "INVOICE" 
	(	"ID_INVOICE" NUMBER, 
	"ID_CLIENT" NUMBER, 
	"INVOICE_DATE" DATE DEFAULT SYSDATE, 
	"REMARKS" VARCHAR2(250), 
	"TRANSPORT_VALUE" NUMBER DEFAULT 0, 
	"INVOICE_VALUE" NUMBER, 
	"INVOICE_FILE" BLOB
	) ;

COMMENT ON COLUMN "INVOICE"."INVOICE_FILE" IS 'DIGITAL FILE';
CREATE UNIQUE INDEX "INVOICE_PK" ON "INVOICE" ("ID_INVOICE");
ALTER TABLE "INVOICE" MODIFY ("ID_INVOICE" NOT NULL ENABLE);
ALTER TABLE "INVOICE" MODIFY ("ID_CLIENT" NOT NULL ENABLE);
ALTER TABLE "INVOICE" MODIFY ("INVOICE_DATE" NOT NULL ENABLE);
ALTER TABLE "INVOICE" MODIFY ("INVOICE_VALUE" NOT NULL ENABLE);
ALTER TABLE "INVOICE" ADD CONSTRAINT "INVOICE_PK" PRIMARY KEY ("ID_INVOICE")
	USING INDEX  ENABLE;
--creare secventa
CREATE SEQUENCE  "INVOICE_SEQ"  
	MINVALUE 20200000 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 20200000 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;


--creare trigger
CREATE OR REPLACE TRIGGER "INVOICE_TRG" 
	  BEFORE INSERT OR UPDATE ON INVOICE
	  FOR EACH ROW
DECLARE
	  ICOUNTER INVOICE.ID_INVOICE%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT INVOICE_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_INVOICE:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_INVOICE=:OLD.ID_INVOICE) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- LIFT_PERSON -------------- --

-- creare tabel

CREATE TABLE "LIFT_PERSON" 
	(	"ID_LIFT_PERSON" NUMBER, 
	"FIRST_NAME" VARCHAR2(80), 
	"LAST_NAME" VARCHAR2(80), 
	"PHONE" VARCHAR2(11), 
	"CNP" VARCHAR2(20)
	) ;

CREATE UNIQUE INDEX "LIFT_PERSON_PK" ON "LIFT_PERSON" ("ID_LIFT_PERSON");
ALTER TABLE "LIFT_PERSON" MODIFY ("ID_LIFT_PERSON" NOT NULL ENABLE);
ALTER TABLE "LIFT_PERSON" MODIFY ("FIRST_NAME" NOT NULL ENABLE);
ALTER TABLE "LIFT_PERSON" MODIFY ("LAST_NAME" NOT NULL ENABLE);
ALTER TABLE "LIFT_PERSON" MODIFY ("PHONE" NOT NULL ENABLE);
ALTER TABLE "LIFT_PERSON" ADD CONSTRAINT "LIFT_PERSON_PK" PRIMARY KEY ("ID_LIFT_PERSON")
	USING INDEX  ENABLE;
 
--creare secventa
CREATE SEQUENCE  "LIFT_PERSON_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;  

-- creare trigger
CREATE OR REPLACE EDITIONABLE TRIGGER "LIFT_PERSON_TRG" 
	  BEFORE INSERT OR UPDATE ON LIFT_PERSON
	  FOR EACH ROW
DECLARE
	  ICOUNTER LIFT_PERSON.ID_LIFT_PERSON%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT LIFT_PERSON_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_LIFT_PERSON:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_LIFT_PERSON=:OLD.ID_LIFT_PERSON) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- LIFT_POINT -------------- --

-- creare tabel

CREATE TABLE "LIFT_POINT" 
	(	"ID_LIFT_POINT" NUMBER, 
	"ID_LIFT_PERSON" NUMBER, 
	"LIFT_DATE" DATE, 
	"ID_CITY" NUMBER, 
	"STREET_NAME" VARCHAR2(60), 
	"STREET_NUMBER" VARCHAR2(20), 
	"FLOOR" VARCHAR2(20), 
	"POSTAL_CODE" NUMBER
	) ;

CREATE UNIQUE INDEX "LIFT_POINT_PK" ON "LIFT_POINT" ("ID_LIFT_POINT") ;
ALTER TABLE "LIFT_POINT" MODIFY ("ID_LIFT_POINT" NOT NULL ENABLE);
ALTER TABLE "LIFT_POINT" MODIFY ("ID_LIFT_PERSON" NOT NULL ENABLE);
ALTER TABLE "LIFT_POINT" MODIFY ("LIFT_DATE" NOT NULL ENABLE);
ALTER TABLE "LIFT_POINT" MODIFY ("ID_CITY" NOT NULL ENABLE);
ALTER TABLE "LIFT_POINT" MODIFY ("STREET_NAME" NOT NULL ENABLE);
ALTER TABLE "LIFT_POINT" MODIFY ("STREET_NUMBER" NOT NULL ENABLE);
ALTER TABLE "LIFT_POINT" MODIFY ("POSTAL_CODE" NOT NULL ENABLE);
ALTER TABLE "LIFT_POINT" ADD CONSTRAINT "LIFT_POINT_PK" PRIMARY KEY ("ID_LIFT_POINT")
	USING INDEX  ENABLE;

--creare secventa
CREATE SEQUENCE  "LIFT_POINT_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;  

-- creare trigger
CREATE OR REPLACE TRIGGER "LIFT_POINT_TRG" 
	  BEFORE INSERT OR UPDATE ON LIFT_POINT
	  FOR EACH ROW
DECLARE
	  ICOUNTER LIFT_POINT.ID_LIFT_POINT%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT LIFT_POINT_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_LIFT_POINT:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_LIFT_POINT=:OLD.ID_LIFT_POINT) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- DELIVERY_PERSON -------------- --

-- creare tabel

CREATE TABLE "DELIVERY_PERSON" 
	(	
	"ID_DELIVERY_PERSON" NUMBER, 
	"FIRST_NAME" VARCHAR2(80), 
	"LAST_NAME" VARCHAR2(80), 
	"PHONE" VARCHAR2(11), 
	"CNP" VARCHAR2(20)
	) ;
 

CREATE UNIQUE INDEX "DELIVERY_PERSON_PK" ON "DELIVERY_PERSON" ("ID_DELIVERY_PERSON");
ALTER TABLE "DELIVERY_PERSON" MODIFY ("ID_DELIVERY_PERSON" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_PERSON" MODIFY ("FIRST_NAME" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_PERSON" MODIFY ("LAST_NAME" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_PERSON" MODIFY ("PHONE" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_PERSON" ADD CONSTRAINT "DELIVERY_PERSON_PK" PRIMARY KEY ("ID_DELIVERY_PERSON")
	USING INDEX  ENABLE;

--creare secventa
CREATE SEQUENCE  "DELIVERY_PERSON_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;  


--creare trigger
CREATE OR REPLACE TRIGGER "DELIVERY_PERSON_TRG" 
	  BEFORE INSERT OR UPDATE ON DELIVERY_PERSON
	  FOR EACH ROW
DECLARE
	  ICOUNTER DELIVERY_PERSON.ID_DELIVERY_PERSON%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT DELIVERY_PERSON_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_DELIVERY_PERSON:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_DELIVERY_PERSON=:OLD.ID_DELIVERY_PERSON) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- DELIVERY_POINT -------------- --

-- creare tabel
CREATE TABLE "DELIVERY_POINT" 
	(	
	"ID_DELIVERY_POINT" NUMBER, 
	"ID_DELIVERY_PERSON" NUMBER, 
	"ID_CITY" NUMBER, 
	"DELIVERY_DATE" DATE, 
	"STREET_NAME" VARCHAR2(80), 
	"STREET_NUMBER" VARCHAR2(20), 
	"FLOOR" VARCHAR2(10), 
	"POSTAL_CODE" VARCHAR2(20)
	) ;
CREATE UNIQUE INDEX "DELIVERY_POINT_PK" ON "DELIVERY_POINT" ("ID_DELIVERY_POINT");
ALTER TABLE "DELIVERY_POINT" MODIFY ("ID_DELIVERY_POINT" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_POINT" MODIFY ("ID_DELIVERY_PERSON" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_POINT" MODIFY ("ID_CITY" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_POINT" MODIFY ("STREET_NAME" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_POINT" MODIFY ("STREET_NUMBER" NOT NULL ENABLE);
ALTER TABLE "DELIVERY_POINT" ADD CONSTRAINT "DELIVERY_POINT_PK" PRIMARY KEY ("ID_DELIVERY_POINT")
	USING INDEX  ENABLE;
--creare secventa
CREATE SEQUENCE  "DELIVERY_POINT_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL;  

--creare trigger
CREATE OR REPLACE TRIGGER "DELIVERY_POINT_TRG" 
	  BEFORE INSERT OR UPDATE ON DELIVERY_POINT
	  FOR EACH ROW
DECLARE
	  ICOUNTER DELIVERY_POINT.ID_DELIVERY_POINT%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT DELIVERY_POINT_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_DELIVERY_POINT:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_DELIVERY_POINT=:OLD.ID_DELIVERY_POINT) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- REQUEST_ORDER -------------- --

-- creare tabel
CREATE TABLE "REQUEST_ORDER" 
	(	
	"ID_ORDER" NUMBER, 
	"ID_CLIENT" NUMBER, 
	"ID_LIFT_POINT" NUMBER, 
	"ID_DELIVERY_POINT" NUMBER, 
	"ID_STATUS" NUMBER DEFAULT 1, 
	"ORDER_DATE" DATE DEFAULT SYSDATE, 
	"ID_DRIVER_VEHICLE" NUMBER, 
	"ID_INVOICE" NUMBER
	) ;

--creare secventa
CREATE SEQUENCE  "REQUEST_ORDER_SEQ"  
	MINVALUE 10000 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 10001 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;

CREATE UNIQUE INDEX "DELIVERY_ORDER_PK" ON "REQUEST_ORDER" ("ID_ORDER");
ALTER TABLE "REQUEST_ORDER" MODIFY ("ID_ORDER" NOT NULL ENABLE);
ALTER TABLE "REQUEST_ORDER" MODIFY ("ID_CLIENT" NOT NULL ENABLE);
ALTER TABLE "REQUEST_ORDER" MODIFY ("ID_LIFT_POINT" NOT NULL ENABLE);
ALTER TABLE "REQUEST_ORDER" MODIFY ("ID_DELIVERY_POINT" NOT NULL ENABLE);
ALTER TABLE "REQUEST_ORDER" MODIFY ("ID_STATUS" NOT NULL ENABLE);
ALTER TABLE "REQUEST_ORDER" ADD CONSTRAINT "DELIVERY_ORDER_PK" PRIMARY KEY ("ID_ORDER")
	USING INDEX  ENABLE;
ALTER TABLE "REQUEST_ORDER" ADD CONSTRAINT "REQUEST_ORDER_CHK1" CHECK (ID_STATUS IN (1,2,3,4)) ENABLE;


--creare trigger
CREATE OR REPLACE TRIGGER "REQUEST_ORDER_TRG" 
	  BEFORE INSERT OR UPDATE ON REQUEST_ORDER
	  FOR EACH ROW
DECLARE
	  ICOUNTER REQUEST_ORDER.ID_ORDER%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT REQUEST_ORDER_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.ID_ORDER:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.ID_ORDER=:OLD.ID_ORDER) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- -------------- MESSAGE -------------- --

-- creare tabel
CREATE TABLE "MESSAGE" 
   (	
   "MESSAGE_ID" NUMBER, 
	"MESSAGE" VARCHAR2(255), 
	"MESSAGE_TYPE" VARCHAR2(1), 
	"CREATED_BY" VARCHAR2(40), 
	"CREATED_AT" DATE
   ) ;
COMMENT ON COLUMN "MESSAGE"."MESSAGE_TYPE" IS 'E- Error, W-Warning, I-Information';
CREATE UNIQUE INDEX "MESSAGE_PK" ON "MESSAGE" ("MESSAGE_ID");
ALTER TABLE "MESSAGE" MODIFY ("MESSAGE_ID" NOT NULL ENABLE);
ALTER TABLE "MESSAGE" MODIFY ("CREATED_BY" NOT NULL ENABLE);
ALTER TABLE "MESSAGE" MODIFY ("CREATED_AT" NOT NULL ENABLE);
ALTER TABLE "MESSAGE" ADD CONSTRAINT "MESSAGE_PK" PRIMARY KEY ("MESSAGE_ID")
	USING INDEX  ENABLE;
ALTER TABLE "MESSAGE" ADD CONSTRAINT "CK_MESSAGE_TYPE" CHECK (MESSAGE_TYPE IN ('E','W','I')) ENABLE;


--creare secventa
CREATE SEQUENCE  "MESSAGE_SEQ"  
	MINVALUE 1 
	MAXVALUE 99999999999999 
	INCREMENT BY 1 START WITH 1 
	NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;

--creare trigger
CREATE OR REPLACE TRIGGER "MESSAGE_TRG" 
	  BEFORE INSERT OR UPDATE ON MESSAGE
	  FOR EACH ROW
DECLARE
	  ICOUNTER message.message_id%TYPE;
	  CANNOT_CHANGE_COUNTER EXCEPTION;
	  BEGIN
	  IF INSERTING THEN
	  SELECT MESSAGE_SEQ.NEXTVAL INTO ICOUNTER FROM DUAL;
	  :NEW.MESSAGE_id:=ICOUNTER;
	  END IF;
	  IF UPDATING THEN
	  IF NOT(:NEW.MESSAGE_ID=:OLD.MESSAGE_ID) THEN
	  RAISE CANNOT_CHANGE_COUNTER;
	  END IF;
	  END IF;
	  EXCEPTION
	  WHEN CANNOT_CHANGE_COUNTER THEN
	  RAISE_APPLICATION_ERROR(-20000, 'CANNOT CHANGE COUNTER VALUE');
END;
/

-- --------- FK-uri --------------------

ALTER TABLE CITY
ADD CONSTRAINT CITY_FK1
  FOREIGN KEY (ID_REGION)
  REFERENCES REGION(ID_REGION);
  
ALTER TABLE CLIENT
ADD CONSTRAINT CLIENT_FK1
  FOREIGN KEY (ID_CITY)
  REFERENCES CITY(ID_CITY);
  
  ALTER TABLE DELIVERY_POINT
ADD CONSTRAINT DELIVERY_POINT_FK1
  FOREIGN KEY (ID_CITY)
  REFERENCES CITY(ID_CITY);
  
   ALTER TABLE DELIVERY_POINT
ADD CONSTRAINT DELIVERY_POINT_FK2
  FOREIGN KEY (ID_DELIVERY_PERSON)
  REFERENCES DELIVERY_PERSON(ID_DELIVERY_PERSON);
  
   ALTER TABLE LIFT_POINT
ADD CONSTRAINT LIFT_POINT_FK1
  FOREIGN KEY (ID_CITY)
  REFERENCES CITY(ID_CITY);
  
    ALTER TABLE LIFT_POINT
ADD CONSTRAINT LIFT_POINT_FK2
  FOREIGN KEY (ID_LIFT_PERSON)
  REFERENCES LIFT_PERSON(ID_LIFT_PERSON);
  
    ALTER TABLE VEHICLE_MODEL
ADD CONSTRAINT VEHICLE_MODEL_FK1
  FOREIGN KEY (ID_VEHICLE_BRAND)
  REFERENCES VEHICLE_BRAND(ID_VEHICLE_BRAND);  
  
    ALTER TABLE VEHICLE
ADD CONSTRAINT VEHICLE_FK1
  FOREIGN KEY (ID_VEHICLE_MODEL)
  REFERENCES VEHICLE_MODEL(ID_VEHICLE_MODEL); 
  
  ALTER TABLE DRIVER_VEHICLE
ADD CONSTRAINT DRIVER_VEHICLE_FK1
  FOREIGN KEY (ID_DRIVER)
  REFERENCES DRIVER(ID_DRIVER); 
  
   ALTER TABLE DRIVER_VEHICLE
ADD CONSTRAINT DRIVER_VEHICLE_FK2
  FOREIGN KEY (ID_VEHICLE)
  REFERENCES VEHICLE(ID_VEHICLE); 
    
 ALTER TABLE INVOICE
ADD CONSTRAINT INVOICE_FK2
  FOREIGN KEY (ID_CLIENT)
  REFERENCES CLIENT(ID_CLIENT);  
  
  ALTER TABLE REQUEST_ORDER
ADD CONSTRAINT REQUEST_ORDER_FK1
  FOREIGN KEY (ID_CLIENT)
  REFERENCES CLIENT(ID_CLIENT); 
  
  ALTER TABLE REQUEST_ORDER
ADD CONSTRAINT REQUEST_ORDER_FK2
  FOREIGN KEY (ID_DELIVERY_POINT)
  REFERENCES DELIVERY_POINT(ID_DELIVERY_POINT);
  
  ALTER TABLE REQUEST_ORDER
ADD CONSTRAINT REQUEST_ORDER_FK3
  FOREIGN KEY (ID_LIFT_POINT)
  REFERENCES LIFT_POINT(ID_LIFT_POINT);
  
  ALTER TABLE REQUEST_ORDER
ADD CONSTRAINT REQUEST_ORDER_FK4
  FOREIGN KEY (ID_DRIVER_VEHICLE)
  REFERENCES DRIVER_VEHICLE(ID_DRIVER_VEHICLE); 
  
    ALTER TABLE REQUEST_ORDER
ADD CONSTRAINT REQUEST_ORDER_FK5
  FOREIGN KEY (ID_STATUS)
  REFERENCES STATUS(ID_STATUS);
  
 ALTER TABLE REQUEST_ORDER
ADD CONSTRAINT REQUEST_ORDER_FK6
  FOREIGN KEY (ID_INVOICE)
  REFERENCES INVOICE(ID_INVOICE);

-- --------- POPULARE TABEL REGION -------------- --
insert into region (name) values ('Alba');
insert into region (name) values ('Arad');
insert into region (name) values ('Arges');
insert into region (name) values ('Bacau');
insert into region (name) values ('Bihor');
insert into region (name) values ('Bistrita-Nasaud');
insert into region (name) values ('Botosani');
insert into region (name) values ('Brasov');
insert into region (name) values ('Braila');
insert into region (name) values ('Buzau');
insert into region (name) values ('Caras-Severin');
insert into region (name) values ('Cluj');
insert into region (name) values ('Constanta');
insert into region (name) values ('Covasna');
insert into region (name) values ('Dambovita');
insert into region (name) values ('Dolj');
insert into region (name) values ('Galati');
insert into region (name) values ('Gorj');
insert into region (name) values ('Harghita');
insert into region (name) values ('Hunedoara');
insert into region (name) values ('Calarasi');
insert into region (name) values ('Ialomita');
insert into region (name) values ('Iasi');
insert into region (name) values ('Giurgiu');
insert into region (name) values ('Ilfov');
insert into region (name) values ('Maramures');
insert into region (name) values ('Mehedinti');
insert into region (name) values ('Mures');
insert into region (name) values ('Neamt');
insert into region (name) values ('Olt');
insert into region (name) values ('Prahova');
insert into region (name) values ('Satu Mare');
insert into region (name) values ('Salaj');
insert into region (name) values ('Sibiu');
insert into region (name) values ('Suceava');
insert into region (name) values ('Teleorman');
insert into region (name) values ('Timis');
insert into region (name) values ('Tulcea');
insert into region (name) values ('Vaslui');
insert into region (name) values ('Valcea');
insert into region (name) values ('Vrancea');
insert into region (name) values ('Bucuresti');

-- --------- POPULARE TABEL CITY -------------- --
insert into city (id_region, name) select id_region, 'Alba Iulia' from region where region.name = 'Alba';
insert into city (id_region, name) select id_region, 'Barabant' from region where region.name = 'Alba';
insert into city (id_region, name) select id_region, 'Micesti' from region where region.name = 'Alba';
insert into city (id_region, name) select id_region, 'Oarda' from region where region.name = 'Alba';
insert into city (id_region, name) select id_region, 'Paclisa' from region where region.name = 'Alba';
insert into city (id_region, name) select id_region, 'Botosani' from region where region.name = 'Botosani';
insert into city (id_region, name) select id_region, 'Curtesti' from region where region.name = 'Botosani';
insert into city (id_region, name) select id_region, 'Agafton' from region where region.name = 'Botosani';
insert into city (id_region, name) select id_region, 'Baiceni' from region where region.name = 'Botosani';
insert into city (id_region, name) select id_region, 'Hudum' from region where region.name = 'Botosani';
insert into city (id_region, name) select id_region, 'Manastirea Doamnei' from region where region.name = 'Botosani';
insert into city (id_region, name) select id_region, 'Oraseni-Deal' from region where region.name = 'Botosani';
insert into city (id_region, name) select id_region, 'Oraseni-Vale' from region where region.name = 'Botosani';
insert into city (id_region, name) select id_region, 'Poieni' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Bologa' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Cerbesti' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Hodisu' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Lunca Visagului' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Morlaca' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Tranisu' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Valea Draganului' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Recea-Cristur' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Caprioara' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Ciubanca' from region where region.name = 'Cluj';
insert into city (id_region, name) select id_region, 'Liesti' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Matca' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Mastacani' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Chiraftei' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Movileni' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Namoloasa' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Crangeni' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Namoloasa Sat' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Nicoresti' from region where region.name = 'Galati';
insert into city (id_region, name) select id_region, 'Coasta Magurii' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Costesti' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Dadesti' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Ganesti' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Giurgesti' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Ion Neculce' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Prigoreni' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Razboieni' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Alexandru I. Cuza' from region where region.name = 'Iasi';
insert into city (id_region, name) select id_region, 'Plataresti' from region where region.name = 'Calarasi';
insert into city (id_region, name) select id_region, 'Cucuieti' from region where region.name = 'Calarasi';
insert into city (id_region, name) select id_region, 'Dorobantu' from region where region.name = 'Calarasi';
insert into city (id_region, name) select id_region, 'Podu Pitarului' from region where region.name = 'Calarasi';
insert into city (id_region, name) select id_region, 'Maineasca' from region where region.name = 'Ilfov';
insert into city (id_region, name) select id_region, 'Surlari' from region where region.name = 'Ilfov';
insert into city (id_region, name) select id_region, 'Vanatori' from region where region.name = 'Ilfov';
insert into city (id_region, name) select id_region, 'Valea Popii' from region where region.name = 'Calarasi';
insert into city (id_region, name) select id_region, 'Rasuceni' from region where region.name = 'Giurgiu';
insert into city (id_region, name) select id_region, 'Carapancea' from region where region.name = 'Giurgiu';
insert into city (id_region, name) select id_region, 'Cucuruzu' from region where region.name = 'Giurgiu';
insert into city (id_region, name) select id_region, 'Satu Nou' from region where region.name = 'Giurgiu';
insert into city (id_region, name) select id_region, 'Roata de Jos' from region where region.name = 'Giurgiu';
insert into city (id_region, name) select id_region, 'Sinesti' from region where region.name = 'Ialomita';
insert into city (id_region, name) select id_region, 'Boteni' from region where region.name = 'Ialomita';
insert into city (id_region, name) select id_region, 'Catrunesti' from region where region.name = 'Ialomita';
insert into city (id_region, name) select id_region, 'Hagiesti' from region where region.name = 'Ialomita';
insert into city (id_region, name) select id_region, 'Lilieci' from region where region.name = 'Ialomita';
insert into city (id_region, name) select id_region, 'Baia Mare' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Blidari' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Firiza' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Valea Neagra' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Grosi' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Ocolis' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Satu Nou de Jos' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Recea' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Bozanta Mica' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Lapusel' from region where region.name = 'Maramures';
insert into city (id_region, name) select id_region, 'Proaspeti' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Raitiu' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Cungrea' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Cepesti' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Ibanesti' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Miesti' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Otestii de Jos' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Otestii de Sus' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Spataru' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Daneasa' from region where region.name = 'Olt';
insert into city (id_region, name) select id_region, 'Zamostea' from region where region.name = 'Suceava';
insert into city (id_region, name) select id_region, 'Badragi' from region where region.name = 'Suceava';
insert into city (id_region, name) select id_region, 'Ciomartan' from region where region.name = 'Suceava';
insert into city (id_region, name) select id_region, 'Cojocareni' from region where region.name = 'Suceava';
insert into city (id_region, name) select id_region, 'Corpaci' from region where region.name = 'Suceava';
insert into city (id_region, name) select id_region, 'Lunca' from region where region.name = 'Suceava';
insert into city (id_region, name) select id_region, 'Nicani' from region where region.name = 'Suceava';
insert into city (id_region, name) select id_region, 'Rauteni' from region where region.name = 'Suceava';
insert into city (id_region, name) select id_region, 'Turnu Magurele' from region where region.name = 'Teleorman';
insert into city (id_region, name) select id_region, 'Ciuperceni' from region where region.name = 'Teleorman';
insert into city (id_region, name) select id_region, 'Poiana' from region where region.name = 'Teleorman';
insert into city (id_region, name) select id_region, 'Islaz' from region where region.name = 'Teleorman';
insert into city (id_region, name) select id_region, 'Moldoveni' from region where region.name = 'Teleorman';
insert into city (id_region, name) select id_region, 'Lita' from region where region.name = 'Teleorman';

commit;
