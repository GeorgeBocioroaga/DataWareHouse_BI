

BEGIN
  SYS.DBMS_SCHEDULER.CREATE_JOB
    (
       job_name        => 'POPULATE_DW_SCHEMA_JOB'
      ,start_date      => TO_TIMESTAMP_TZ('2021/01/01 14:00:00.000000 +03:00','yyyy/mm/dd hh24:mi:ss.ff tzr')
      ,repeat_interval => 'FREQ=MINUTELY; INTERVAL=5;'
      ,end_date        => NULL
      ,job_class       => 'DEFAULT_JOB_CLASS'
      ,job_type        => 'STORED_PROCEDURE'
      ,job_action      => 'DWBI1.POPULATE_DW_SCHEMA'
      ,comments        => 'Transfera datele din baza de date OLTP in baza de date DW'
    );
  SYS.DBMS_SCHEDULER.SET_ATTRIBUTE
    ( name      => 'POPULATE_DW_SCHEMA_JOB'
     ,attribute => 'RESTARTABLE'
     ,value     => FALSE);
  SYS.DBMS_SCHEDULER.SET_ATTRIBUTE
    ( name      => 'POPULATE_DW_SCHEMA_JOB'
     ,attribute => 'LOGGING_LEVEL'
     ,value     => SYS.DBMS_SCHEDULER.LOGGING_OFF);
  SYS.DBMS_SCHEDULER.SET_ATTRIBUTE_NULL
    ( name      => 'POPULATE_DW_SCHEMA_JOB'
     ,attribute => 'MAX_FAILURES');
  SYS.DBMS_SCHEDULER.SET_ATTRIBUTE_NULL
    ( name      => 'POPULATE_DW_SCHEMA_JOB'
     ,attribute => 'MAX_RUNS');
  BEGIN
    SYS.DBMS_SCHEDULER.SET_ATTRIBUTE
      ( name      => 'POPULATE_DW_SCHEMA_JOB'
       ,attribute => 'STOP_ON_WINDOW_CLOSE'
       ,value     => FALSE);
  EXCEPTION
    -- could fail if program is of type EXECUTABLE...
    WHEN OTHERS THEN
      NULL;
  END;
  SYS.DBMS_SCHEDULER.SET_ATTRIBUTE
    ( name      => 'POPULATE_DW_SCHEMA_JOB'
     ,attribute => 'JOB_PRIORITY'
     ,value     => 3);
  SYS.DBMS_SCHEDULER.SET_ATTRIBUTE_NULL
    ( name      => 'POPULATE_DW_SCHEMA_JOB'
     ,attribute => 'SCHEDULE_LIMIT');
  SYS.DBMS_SCHEDULER.SET_ATTRIBUTE
    ( name      => 'POPULATE_DW_SCHEMA_JOB'
     ,attribute => 'AUTO_DROP'
     ,value     => FALSE);

  SYS.DBMS_SCHEDULER.ENABLE
    (name                  => 'POPULATE_DW_SCHEMA_JOB');
END;
/