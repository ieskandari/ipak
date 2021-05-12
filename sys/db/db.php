<?php
namespace sys;
if (file_exists(stream_resolve_include_path("config_db_mysql.php")))
{
    include "config_db_mysql.php";
    define("databaseHost",$databaseHost);
    define("databaseName",$databaseName);
    define("databaseUsername",$databaseUsername);
    define("databasePassword",$databasePassword);
}
include "db_mysql.php";
class db
{
  function test()
  {
      echo 'test db';
  }
}