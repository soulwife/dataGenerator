<?php
namespace Model;
use PDO;
/**
 * Description of DatabaseConnection
 *
 * @author Anastasiia
 */
 
class Database {

    private $connection = null;
    
    public function __construct($dbHost, $dbName, $dbUser, $dbPass) {
        try { 
            $this->connection = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass); 
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                  
        } catch (PDOException $e) {                 
            throw new Exception("Couldn't connect to database. PDO details: " . $e->getMessage());                 
        }
        //increase speed for INFORMATION_SCHEMA
        $this->connection->query("set global innodb_stats_on_metadata=0");
        return $this->connection;
    }
    
    public function getTablesInformation() {        
        $sql = "select TABLE_NAME as name, ENGINE, TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE()";
        $result = $this->connection->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getColumnsInformation($table) {
        $sql = "select * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :table AND TABLE_SCHEMA = DATABASE()";
        $preparedResult = $this->connection->prepare($sql);
        $preparedResult->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Column');
        $preparedResult->execute(array(':table' => $table));
        $columns = $preparedResult->fetchAll();
        return $columns;
    }
}

