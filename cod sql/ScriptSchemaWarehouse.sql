-- TABLE DIM_VEHICLES

CREATE TABLE "DWBI2"."DIM_VEHICLES" 
   (	"VEHICLEID" NUMBER NOT NULL ENABLE, 
	"BRAND" VARCHAR2(100 BYTE), 
	"MODEL" VARCHAR2(100 BYTE), 
	"PLATE" VARCHAR2(30 BYTE), 
	"VIN" VARCHAR2(20 BYTE), 
	"COLUMN1" VARCHAR2(20 BYTE), 
	 CONSTRAINT "DIM_VEHICLES_PK" PRIMARY KEY ("VEHICLEID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  TABLESPACE "USERS"  ENABLE
   ) SEGMENT CREATION DEFERRED 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  TABLESPACE "USERS" ;
  
-- TABLE DIM_DRIVERS

CREATE TABLE DIM_DRIVERS 
(
  DRIVERID NUMBER NOT NULL 
, NAME VARCHAR2(50) 
, CNP VARCHAR2(20) 
, PHONE VARCHAR2(20) 
, CONSTRAINT DIM_DRIVERS_PK PRIMARY KEY 
  (
    DRIVERID 
  )
  ENABLE 
);


-- TABLE DIM_DATE

CREATE TABLE DIM_DATE 
(
  DATEID DATE NOT NULL 
, DATANUMBER NUMBER(8) 
, DAY NUMBER(2) 
, MONTH NUMBER(2) 
, YEAR NUMBER(4) 
, CONSTRAINT DIM_DATE_PK PRIMARY KEY 
  (
    DATEID 
  )
  ENABLE 
);


-- TABLE DIM_CITIES

CREATE TABLE DIM_CITIES 
(
  CITYID NUMBER NOT NULL  
, CITYNAME VARCHAR(20)
, REGIONNAME VARCHAR(20)
, CONSTRAINT DIM_CITIES_PK PRIMARY KEY 
  (
    CITYID 
  )
  ENABLE 
);


-- TABLE DIM_CLIENTS

CREATE TABLE DIM_CLIENTS 
(
  CLIENTID NUMBER NOT NULL 
, NAME VARCHAR2(60) 
, PHONE VARCHAR2(20) 
, ADDRESS VARCHAR2(250) 
, PC VARCHAR2(10) 
, EMAIL VARCHAR2(50) 
, CONSTRAINT DIM_CLIENTS_PK PRIMARY KEY 
  (
    CLIENTID 
  )
  ENABLE 
);

-- TABLE FACTS_ORDERS

CREATE TABLE FACTS_ORDERS 
(
  ORDERID NUMBER NOT NULL 
, DIMCLIENTID NUMBER NOT NULL 
, DIMVEHICLEID NUMBER NOT NULL 
, DIMDRIVERID NUMBER NOT NULL 
, DIMORDERDATEID DATE NOT NULL 
, DIMDELIVERYDATEID DATE NOT NULL 
, DIMLIFTINGDATEID DATE NOT NULL 
, DIMDELIVERYCITYID NUMBER NOT NULL 
, DIMLIFTINGCITYID NUMBER NOT NULL 
, TRANSPORTVALUE NUMBER DEFAULT 0 
, INVOICEVALUE NUMBER DEFAULT 0 
, DELIVERYSTREET VARCHAR2(50) 
, DELIVERYPOSTALCODE VARCHAR2(10) 
, DELIVERYPERSONNAME VARCHAR2(50) 
, DELIVERYPERSONPHONE VARCHAR2(20) 
, LIFTINGSTREET VARCHAR2(50) 
, LIFTINGPOSTALCODE VARCHAR2(10) 
, LIFTINGPERSONNAME VARCHAR2(50) 
, LIFTINGPERSONPHONE VARCHAR2(20) 
, CONSTRAINT FACTS_ORDERS_PK PRIMARY KEY 
  (
    ORDERID 
  )
  ENABLE 
);

-- FK FACTS_ORDERS

ALTER TABLE FACTS_ORDERS
ADD CONSTRAINT FACTS_ORDERS_FK1 FOREIGN KEY
(
  DIMCLIENTID 
)
REFERENCES DIM_CLIENTS
(
  CLIENTID 
)
ENABLE;

ALTER TABLE FACTS_ORDERS
ADD CONSTRAINT FACTS_ORDERS_FK2 FOREIGN KEY
(
  DINVEHICLEID 
)
REFERENCES DIM_VEHICLES
(
  VEHICLEID 
)
ENABLE;

ALTER TABLE FACTS_ORDERS
ADD CONSTRAINT FACTS_ORDERS_FK3 FOREIGN KEY
(
  DIMDRIVERID 
)
REFERENCES DIM_DRIVERS
(
   DRIVERID 
)
ENABLE;

ALTER TABLE FACTS_ORDERS
ADD CONSTRAINT FACTS_ORDERS_FK4 FOREIGN KEY
(
  DIMORDERDATEID 
)
REFERENCES DIM_DATE
(
  DATEID 
)
ENABLE;

ALTER TABLE FACTS_ORDERS
ADD CONSTRAINT FACTS_ORDERS_FK5 FOREIGN KEY
(
  DIMDELIVERYDATEID 
)
REFERENCES DIM_DATE
(
  DATEID 
)
ENABLE;

ALTER TABLE FACTS_ORDERS
ADD CONSTRAINT FACTS_ORDERS_FK6 FOREIGN KEY
(
  DIMLIFTINGDATEID 
)
REFERENCES DIM_DATE
(
  DATEID 
)
ENABLE;

ALTER TABLE FACTS_ORDERS
ADD CONSTRAINT FACTS_ORDERS_FK7 FOREIGN KEY
(
  DIMDELIVERYCITYID 
)
REFERENCES DIM_CLIENTS
(
  CLIENTID 
)
ENABLE;

ALTER TABLE FACTS_ORDERS
ADD CONSTRAINT FACTS_ORDERS_FK8 FOREIGN KEY
(
  DIMLIFTINGCITYID 
)
REFERENCES DIM_CITIES
(
  CITYID 
)
ENABLE;

-- GRANTS

grant select, insert on DIM_CITIES to dwbi1;
grant select, insert on DIM_CLIENTS to dwbi1;
grant select, insert on DIM_DATE to dwbi1;
grant select, insert on DIM_DRIVERS to dwbi1;
grant select, insert on DIM_VEHICLES to dwbi1;
grant select, insert on FACTS_ORDERS to dwbi1;
