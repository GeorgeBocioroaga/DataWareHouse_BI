create or replace procedure populate_dw_schema
is 
begin

--dim_vehicles
    --select * from DWBI2.dim_vehicles

    insert into dwbi2.dim_vehicles
    select 
        a.id_vehicle, c.name as brand, b.name as model, a.plate, a.vin, a.color
    from
        vehicle a, 
        vehicle_brand b,
        vehicle_model c
    where
        a.id_vehicle_model = c.id_vehicle_model and
        c.id_vehicle_brand = b.id_vehicle_brand and
        a.id_vehicle not in ( select vehicleid from dwbi2.dim_vehicles );

--dim_drivers
    --select * from dwbi2.dim_drivers;

    insert into dwbi2.dim_drivers
    select 
        d.id_driver, d.first_name || ' ' || d.last_name as name, d.cnp, d.phone
    from 
        driver d
    where
        not exists (select 1 from dwbi2.dim_drivers d2 where d2.driverid = d.id_driver);

--dim_date
    --select * from dwbi2.dim_date;

    --START se ruleaza o singura data
    /*
    create table t ( st_dt date, en_dt date );

    insert into t values (date'2015-01-01', sysdate);

    insert into dwbi2.dim_date    
     select trunc(data) as dateid, to_char(data,'yyyymmdd') as datenumber, to_char(data,'dd') as day
     , to_char(data,'MM') as month, to_char(data,'YYYY') as year
     from(
           select 
              A.st_dt+delta data
            from 
              t A, 
              (
                 select level-1 as delta 
                 from dual 
                 connect by level-1 <= (
                   select max(en_dt - st_dt) from t
                 )
              )
            where A.st_dt+delta <= A.en_dt
       );

    drop table t;
    */
    --END se ruleaza o singura data   

    /*insert into dwbi2.dim_date (dateid, datenumber, day, month, year)
    --values (sysdate, to_char(sysdate,'YYYYMMDD'), to_char(sysdate,'DD'), to_char(sysdate,'MM'), to_char(sysdate,'YYYY'));
        select trunc(sysdate), to_char(sysdate,'YYYYMMDD'), to_char(sysdate,'DD'), to_char(sysdate,'MM'), to_char(sysdate,'YYYY')
        from dual
        where not exists (select 1 from dwbi2.dim_date a where a.DATEID = trunc(sysdate));*/

-- dim_cities
    --select * from DWBI2.dim_cities;

    /*insert into dwbi2.dim_cities
    select a.id_city as cityid, a.name as cityname, b.name as regionname
    from city a, region b
    where a.id_region = b.id_region and 
        not exists (select 1 from dwbi2.dim_cities c where c.cityid = a.id_city); */

-- dim_clients
    --select * from dwbi2.dim_clients;

    insert into dwbi2.dim_clients
    select a.id_client as clientid,  a.first_name || ' ' || a.last_name as name
        , a.phone, a.address, a.postal_code as pc, a.email
    from    client a    
    where not exists (select 1 from dwbi2.dim_clients b where b.clientid = a.id_client);      

-- facts_orders
    --select * from dwbi2.facts_orders;

    insert into dwbi2.facts_orders
    select 
        a.id_order as orderid, a.id_client dimclientid, b.id_vehicle as dimvehicleid,
        b.id_driver as dimdriverid, 
        trunc(a.order_date) as dimorderdateid, 
        trunc(c.delivery_date) as dimdeliverydateid,
        trunc(d.lift_date) as dimliftingdateid,
        c.id_city as dimDeliveryCityId,
        d.id_city as dimLiftingCityId,
        nvl(e.TRANSPORT_VALUE,0) as transportvalue,
        nvl(e.invoice_value,0) as invoicevalue,
        c.street_name as deliverystreet,
        c.postal_code as deliverypostalcode,
        f.first_name || ' ' || f.last_name as deliverypersonname,
        f.phone as deliveryPersonPhone,
        d.street_name as liftingStreet,
        d.postal_code as liftingPostalCode,
        g.first_name || ' ' || g.last_name as liftingPersonName,
        g.phone as liftingPersonPhone
    from
        request_order a,
        driver_vehicle b,
        delivery_point c,
        lift_point d,
        invoice e,
        delivery_person f,
        lift_person g
    where
        a.id_driver_vehicle = b.id_driver_vehicle and
        a.id_delivery_point = c.id_delivery_point and 
        a.id_lift_point = d.id_lift_point and
        a.id_invoice = e.id_invoice(+) and
        c.id_delivery_person = f.id_delivery_person and
        d.id_lift_person = g.id_lift_person and
        a.id_status = 6 and -- doar comenzile finalizate
        not exists (select 1 from dwbi2.facts_orders h where h.orderid = a.id_order)
        --and c.id_city not in (select cityid from DWBI2.dim_cities)
        ;

    commit;

end;