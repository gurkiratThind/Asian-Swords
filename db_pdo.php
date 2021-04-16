<?php
/**
 * class for database using PDO to connect to any type
 * of SQl servers, including MySQL.
 */
 class db_pdo
 {
     public $db_host = '127.0.0.1';
     public $db_user_name = 'electric_scooter_web_site';
     public $db_user_pw = 'qwerty3793';
     public $db_name = 'electric_scooter'; // name of database

     public function __construct()
     {
         // connection options
         //https://www.php.net/manual/en/pdo.setattribute.php
         $options = [
        // throw exception on SQL errors
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // return records with associative keys only, no numeric index
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        //Enables or disables emulation of prepared statements. Some drivers do not support native prepared statements or have .
        //(if FALSE) to try to use native prepared statements
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];

         try {
             $this->connection = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name.';charset=utf8mb4', $this->db_user_name, $this->db_user_pw, $options);
         } catch (PDOException $e) {
             http_response_code(500);
             throw new \PDOException($e->getMessage(), (int) $e->getCode());
             //echo 'Error!: '.$e->getMessage().'<br/>';
             die();
         }
         //echo 'connected to DB ;)';
     }

     /**
      * query() return exception cause in SQL.
      */
     public function query($sql_str)
     {
         try {
             $result = $this->connection->query($sql_str);
         } catch (\PDOException $e) {
             throw new \PDOException($e->getMessage(), (int) $e->getCode());
             die();
         }
         //var_dumb($sql_str);

         return $result;
     }

     /**
      * querySelect() for SELECT queries returning records converted in PHP array.
      */
     public function querySelect($sql_str)
     {
         $records = $this->query($sql_str)->fetchAll();

         return $records;
     }

     /**
      * query() for INSERT, UPDATE, DELETE that return no records.
      */
     public function queryParam($sql_str, $params)
     {
         $stmt = $this->connection->prepare($sql_str);
         $stmt->execute($params);

         return true;
     }

     public function querySelectParam($sql_str, $params)
     {
         $stmt = $this->connection->prepare($sql_str);
         $stmt->execute($params);
         $records = $stmt->fetchAll();

         return $records;
     }

     /**
      * returns the whole table from DB.
      */
     public function table($table_name)
     {
         return $this->querySelect('SELECT * from '.$table_name);
     }

     public function disconnect()
     {
         $this->connection = null;
     }
 }
