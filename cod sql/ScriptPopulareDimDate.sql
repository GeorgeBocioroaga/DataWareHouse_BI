--se ruleaza o singura data pe user-ul dwbi2

ALTER TABLE DIM_DATE 
    ADD (QUARTER NUMBER(1) );

create table t ( st_dt date, en_dt date );

    insert into t values (to_date('2015-01-01','yyyy-mm-dd'), to_date('2025-12-31','yyyy-mm-dd'));

    insert into dwbi2.dim_date    
     select trunc(data) as dateid, to_char(data,'yyyymmdd') as datenumber, to_char(data,'dd') as day
     , to_char(data,'MM') as month, to_char(data,'YYYY') as year, to_char(data,'Q') as quarter
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
    
    commit;