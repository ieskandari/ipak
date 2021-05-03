<?php
namespace sys;
use PDO as PDO;
use PDOException as PDOException;
class DatabaseMysql
{
    var $databaseHost;
    var $databaseName;
    var $databaseUsername;
    var $databasePassword;
    var $mysqli;
    var $sql;
    var $pdo_config;
    var $connection;
    var $begin=false;
    function __construct() {
        try{
          $this->databaseHost= databaseHost;
          $this->databaseUsername=databaseUsername;
          $this->databasePassword=databasePassword;
          $this->databaseName=databaseName;
         //    $this->mysqli = mysqli_connect($this->databaseHost, $this->databaseUsername, $this->databasePassword, $this->databaseName);  
         //    $this->sql=mysqli_query($this->mysqli,"SET NAMES 'utf8'");
         //    $this->sql=mysqli_query($this->mysqli,"SET CHARACTER SET utf8");
         //    mysqli_set_charset($this->mysqli,"utf8");   
         $this->connection = new PDO("mysql:host=".$this->databaseHost.";dbname=".$this->databaseName,$this->databaseUsername,$this->databasePassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",   PDO::ATTR_PERSISTENT    => true));
        // $this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
         $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $this->connection->exec("SET NAMES 'utf8'");
         $this->connection->exec("SET CHARACTER SET utf8");   
        }
        catch(PDOException $ex)
        {
         $this->connection->rollBack();
           // echo "error database";
        }
      }
      function pdo_json($query,$param=array())
      {
       try{
          if(isset($this->connection))
          {
             $prepared=$this->connection->prepare($query);
             $prepared->execute($param);
             $data=$prepared->fetchAll();
             $res=array();
             $index_row=0;
             foreach($data as $row)
             {
                $row_data=array();
                   foreach($row as $key=>$col)
                   {
                      if(!is_numeric($key))
                      {
                         $row_data[$key]=$col;
                      }
                   }
                   $res[$index_row]=$row_data;
                   $index_row=$index_row+1;
             }
             return $res;
          }
          else
          {
             return array();
          }
          }catch(PDOException $e){
          
          //error text info
          return $e->getMessage();
          //error array
       //   print_r($this->connection->errorInfo());
          }
      }
      function pdo($query,$param=array())
      {
       try{
          if(isset($this->connection))
          {
             $prepared=$this->connection->prepare($query);
             $prepared->execute($param);
             $data=$prepared->fetchAll();
             return $data;
          }
          else
          {
             return array();
          }
          }catch(PDOException $e){
          //error text info
          return $e->getMessage();
          //error array
       //   print_r($this->connection->errorInfo());
          }
      }
      function pdo_single($query,$param=array())
      {
       try{
          if(isset($this->connection)){
             $prepared=$this->connection->prepare($query);
             $prepared->execute($param);
             $data=$prepared->fetchAll();
             if(isset($data[0]))
             {
                return $data[0];
             }
            else
            {
               return array();
            }
          }
          else
          {
             return array();
          }
 
          }catch(PDOException $e){
          //error text info
          return $e->getMessage();
          //error array
       //   print_r($this->connection->errorInfo());
          }
      }
      function pdo_exc($query,$param=array(),$option=array())
      {
       try{
          if(isset($this->connection))
          {
             $prepared=$this->connection->prepare($query);
             if(isset($option["begin"])&&$option["begin"]==1)
             {
               $this->connection->beginTransaction();
             }
             $data= $prepared->execute($param);
             if( $this->connection->lastInsertId()>0)
             {
               $data= $this->connection->lastInsertId();
             }
             else
             {
               $data = $prepared->rowCount();
             }

            
             
             if(isset($option["commit"])&&$option["commit"]==1)
             {
                $this->connection->commit();
             }
             if(isset($option["rollback"])&&$option["rollback"]==1)
             {
               $this->connection->rollBack();
             }
             return $data;
          }
          else
          {
             return "0";
          }
          }catch(PDOException $e){
 
          //error text info
          return $e->getMessage();
          //error array
       //   print_r($this->connection->errorInfo());
          }
      }
      function begin()
      {
         if(!$this->begin)
         {
            $this->connection->beginTransaction();
            $this->begin=true;
         }
      }
      function commit()
      {
         if($this->begin)
         {
            $this->connection->commit();
            $this->begin=false;
         }
      }
      function rollBack()
      {
         if($this->begin)
         {
            $this->connection->rollBack();
         }
      }
}