-- populare dim_cities - SE RULEAZA O SINGURA DATA! - pe user-ul dwbi1
    --select * from DWBI2.dim_cities;

    insert into dwbi2.dim_cities
    select a.id_city as cityid, a.name as cityname, b.name as regionname
    from city a, region b
    where a.id_region = b.id_region and 
        not exists (select 1 from dwbi2.dim_cities c where c.cityid = a.id_city); 
        
commit;