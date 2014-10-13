<?php
namespace Model\Repository;
use PDO, Model\Table, Model\Database;

/**
 * Database repository for operating on tables level
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

    /**
     * Select info from INFORMATION_SCHEMA.TABLES
     * 
     * @return array
     */
    public function getTablesInformation() { 
        $sql = "SELECT `TABLE_NAME` as name, `ENGINE`, `AUTO_INCREMENT`, `TABLE_COLLATION` FROM INFORMATION_SCHEMA.TABLES WHERE `TABLE_SCHEMA` = DATABASE()";
        $result = Database::getConnection()->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Select info from INFORMATION_SCHEMA.COLUMNS and gathered it in \Model\Column class
     * 
     * @param string $table
     * @return array
     */
    public function getColumnsInformation($table) {
        $sql = "SELECT `COLUMN_NAME` as _name, `TABLE_NAME` as _tableName, `COLUMN_TYPE` as _type, `COLUMN_KEY` as _key, `EXTRA` as _extra, `IS_NULLABLE`, `DATA_TYPE`, `CHARACTER_MAXIMUM_LENGTH` as _charLength, `NUMERIC_PRECISION` as _numLength, `NUMERIC_SCALE`, `CHARACTER_SET_NAME`, `COLLATION_NAME` "
                . "FROM INFORMATION_SCHEMA.COLUMNS "
                . "WHERE `TABLE_NAME` = :table AND `TABLE_SCHEMA` = DATABASE()";
        $preparedResult = Database::getConnection()->prepare($sql);
        $preparedResult->setFetchMode(PDO::FETCH_CLASS, 'Model\\Column');
        $preparedResult->execute(array(':table' => $table));
        return $preparedResult->fetchAll();
    }
    
    /**
     * Get table from INFORMATION_SCHEMA.TABLES if it's exists there
     * 
     * @param string $table
     * @return array
     */
    public function getTable($table) {
        $sql = "SELECT `TABLE_NAME` as name FROM INFORMATION_SCHEMA.TABLES WHERE `TABLE_SCHEMA` = DATABASE() AND `TABLE_NAME` = :table LIMIT 1";
        $preparedResult = Database::getConnection()->prepare($sql);
        $preparedResult->execute(array(':table' => $table));
        return $preparedResult->fetch(PDO::FETCH_ASSOC);       
    }
    
    /**
     * 
     * @param string $tableInfo
     * @return \Model\Table
     */
    public function createTable($tableInfo) {
        $table = null;
        if (is_array($tableInfo)) {
            $table = new Table($tableInfo['name'], array_slice($tableInfo, 1));
        }
        return $table;       
    }
    
    /**
     * Get all rows from table
     * 
     * @param string $table
     * @return array
     */
    public function getTableData($table) {
        $sql = "SELECT * FROM " . $table;
        $prepResult = Database::getConnection()->prepare($sql);
        $prepResult->execute();
        return $prepResult->fetchAll(PDO::FETCH_ASSOC);      
    }
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function getTableColumnHeaders($table) {
        $sql = "DESCRIBE " . $table;
        $prepResult = Database::getConnection()->prepare($sql);
        $prepResult->execute();
        return $prepResult->fetchAll(PDO::FETCH_COLUMN); 
    }
    
    /**
     * 
     * @return array of \Model\Table
     */
    function getTables() {
        $tablesInfo = $this->getTablesInformation();
        foreach ($tablesInfo as $tableInfo) {
            $tables[] = new Table($tableInfo['name'], array_slice($tableInfo, 1));
        } 
        return $tables;
    }   
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function getTableTotalRowsCount($table) {
        $sql = "SELECT COUNT(*) FROM " . $table;
        $result = Database::getConnection()->query($sql);
        return $result->fetch(PDO::FETCH_NUM);      
    }
}
