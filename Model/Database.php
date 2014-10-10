<?php
namespace Model;
use PDO, Model\Column;
/**
 * Description of DatabaseConnection
 *
 * @author Anastasiia
 */
 
class Database {

    private $_connection = null;
    public static $columns = [
        'NAME',
        'TYPE', 
        'KEY', 
        'EXTRA', 
        'IS NULLABLE', 
        'DATA TYPE', 
        'CHARACTER MAXIMUM LENGTH', 
        'NUMERIC PRECISION', 
        'NUMERIC SCALE', 
        'CHARACTER SET NAME', 
        'COLLATION NAME', 
        'COLUMN COMMENT'
        ];
    const TABLES_SQL = "select `TABLE_NAME` as name, `ENGINE`, `TABLE_ROWS` FROM INFORMATION_SCHEMA.TABLES WHERE `TABLE_SCHEMA` = DATABASE()";
    const TABLE_SQL = "select `TABLE_NAME` as name FROM INFORMATION_SCHEMA.TABLES WHERE `TABLE_SCHEMA` = DATABASE() AND `TABLE_NAME` = :table LIMIT 1";
    public function __construct($dbHost, $dbName, $dbUser, $dbPass) {
        try { 
            $this->_connection = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass); 
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                  
        } catch (PDOException $e) {                 
            throw new Exception("Couldn't connect to database. PDO details: " . $e->getMessage());                 
        }

        $this->_connection->query("set global innodb_stats_on_metadata=0");
        return $this->_connection;
    }
    
    public function getConnection() {
        return $this->_connection;
    }
    
    public function getTablesInformation() {        
        $result = $this->_connection->query(self::TABLES_SQL);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getColumnsInformation($table) {
        $sql = "select `COLUMN_NAME` as _name, `TABLE_NAME` as _tableName, `COLUMN_TYPE` as _type, `COLUMN_KEY` as _key, `EXTRA` as _extra, `IS_NULLABLE`, `DATA_TYPE`, `CHARACTER_MAXIMUM_LENGTH` as _charLength, `NUMERIC_PRECISION` as _numLength, `NUMERIC_SCALE`, `CHARACTER_SET_NAME`, `COLLATION_NAME`, `COLUMN_COMMENT` "
                . "FROM INFORMATION_SCHEMA.COLUMNS "
                . "WHERE `TABLE_NAME` = :table AND `TABLE_SCHEMA` = DATABASE()";
        $preparedResult = $this->_connection->prepare($sql);
        $preparedResult->setFetchMode(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Column');
        $preparedResult->execute(array(':table' => $table));
        $columns = $preparedResult->fetchAll();
        return $columns;
    }
    
    public function getTable($table) {
        $preparedResult = $this->_connection->prepare(self::TABLE_SQL);
        $preparedResult->execute(array(':table' => $table));
        var_dump($preparedResult);
        return $preparedResult->fetch(PDO::FETCH_ASSOC);       
    }
    
    public function createTable($tableInfo) {
        $table = null;
        if (is_array($tableInfo)) {
            $table = new Table($tableInfo['name'], array_slice($tableInfo, 1));
        }
        return $table;       
    }
    
    public function __destruct() {
        $this->_connection = null;
    }
}

