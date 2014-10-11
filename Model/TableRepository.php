<?php
namespace Model;
use PDO;

/**
 * Description of TableRepository
 *
 * @author Anastasiia
 */
class TableRepository {
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
        'COLLATION NAME'
    ];

    public function getTablesInformation() { 
        $sql = "SELECT `TABLE_NAME` as name, `ENGINE`, `TABLE_ROWS` FROM INFORMATION_SCHEMA.TABLES WHERE `TABLE_SCHEMA` = DATABASE()";
        $result = Database::getConnection()->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getColumnsInformation($table) {
        $sql = "SELECT `COLUMN_NAME` as _name, `TABLE_NAME` as _tableName, `COLUMN_TYPE` as _type, `COLUMN_KEY` as _key, `EXTRA` as _extra, `IS_NULLABLE`, `DATA_TYPE`, `CHARACTER_MAXIMUM_LENGTH` as _charLength, `NUMERIC_PRECISION` as _numLength, `NUMERIC_SCALE`, `CHARACTER_SET_NAME`, `COLLATION_NAME` "
                . "FROM INFORMATION_SCHEMA.COLUMNS "
                . "WHERE `TABLE_NAME` = :table AND `TABLE_SCHEMA` = DATABASE()";
        $preparedResult = Database::getConnection()->prepare($sql);
        $preparedResult->setFetchMode(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Column');
        $preparedResult->execute(array(':table' => $table));
        $columns = $preparedResult->fetchAll();
        return $columns;
    }
    
    public function getTable($table) {
        $sql = "SELECT `TABLE_NAME` as name FROM INFORMATION_SCHEMA.TABLES WHERE `TABLE_SCHEMA` = DATABASE() AND `TABLE_NAME` = :table LIMIT 1";
        $preparedResult = Database::getConnection()->prepare($sql);
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
    
    public function getTableData($table) {
        $sql = "SELECT * FROM " . $table;
        $result = Database::getConnection()->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);      
    }
    
    public function getTableColumnHeaders($table) {
        $sql = "DESCRIBE " . $table;
        $result = Database::getConnection()->query($sql);
        return $result->fetchAll(PDO::FETCH_COLUMN); 
    }
    
    function getTables() {
        $tablesInfo = $this->getTablesInformation();
        foreach ($tablesInfo as $tableInfo) {
            $tables[] = new Table($tableInfo['name'], array_slice($tableInfo, 1));
        } 
        return $tables;
    }
    
    function displayTablesWithColumns($tables, $keyReference) {
        $tableFormatter = new TableFormatter(TableRepository::$columns);
        foreach ($tables as $table) {
           echo $table->getFormattedName();
           echo $table->getFormattedOtherFields();
           echo $keyReference->getFormattedReferencedForTables($table->getName());
           echo $table->getFormattedForm();
           $tableColumns = $this->getColumnsInformation($table->getName());
           $table->setColumns($tableColumns);
           array_map(function($column) use (&$tableFormatter) {
               $tableFormatter->addRowsItems($column->getOtherFields());
           }, $tableColumns);
           echo $tableFormatter->createTable();
           echo $table->getShowDetailsForm();
           $columns[] = $tableColumns;
        }
    }
}
