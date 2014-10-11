<?php
namespace Model;
/**
 * Description of KeyReference
 *
 * @author anastasia
 */
class KeyReference {
    
    const FROM_PART_OF_SQL = " FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_SCHEMA = DATABASE() "; 
    
    private $_referencedColumns = [];
    private $_referencedTables = [];
    
    public function getReferencingForColumns($table, $column) {
        $result = $this->_referencedColumns[$table][$column];     
        
        if ( ! isset($result)) {
            $sql =  "SELECT TABLE_NAME as tableName, COLUMN_NAME as columnName"
                    . self::FROM_PART_OF_SQL 
                    . "AND REFERENCED_TABLE_NAME = :table AND REFERENCED_COLUMN_NAME = :column";
            $preparedResult = Database::getConnection()->prepare($sql);
            $preparedResult->execute(array(':table' => Database::getConnection()->quote($table), ':column' => Database::getConnection()->quote($column)));
            $result = $preparedResult->fetch(PDO::FETCH_ASSOC);
            $this->_referencedColumns[$table][$column] = $result;           
        }
        
        return $result; 
    }
    
    private function getReferencedForTables($table) {
        $result = $this->_referencedTables[$table];     
        
        if (!isset($result)) {
            $sql =  "SELECT REFERENCED_TABLE_NAME as rTableName, COLUMN_NAME as columnName, REFERENCED_COLUMN_NAME as rColumnName"
                    . self::FROM_PART_OF_SQL 
                    . "AND TABLE_NAME = :table";
            $preparedResult = Database::getConnection()->prepare($sql);
            $preparedResult->execute(array(':table' => $table));
            $result = $preparedResult->fetchAll(\PDO::FETCH_ASSOC);
            $this->_referencedTables[$table] = $result;           
        }
        
        return $result; 
    }
    
    public function getFormattedReferencedForTables($table) {
        $this->getReferencedForTables($table);
        if ( ! $this->_referencedTables[$table]) {
            return "";
        }
        $informationString = "<h5>Referenced tables for this table: ";
        foreach ($this->_referencedTables[$table] as $tableRefInfo) {
           $informationString .= "'". $tableRefInfo['rTableName'] . "' with column '" . $tableRefInfo['rColumnName'] . "' for column '" . $tableRefInfo['columnName'] ."';";
        }
        return rtrim($informationString , ";") . "</h5>";
    }
    
    public function getReferencingColumnsValuesForTable($table) {
        $this->getReferencedForTables($table);
        if ( ! $this->_referencedTables[$table]) {
            return [];
        }
        $randomRowSqlPart = " ORDER BY RAND() LIMIT 1";
        $preparedResult = Database::getConnection()->prepare($sql);
        foreach ($this->_referencedTables[$table] as $tableRefInfo) {
            $sql =  "SELECT " . $tableRefInfo['rColumnName'] . " FROM " . $tableRefInfo['rTableName'] . $randomRowSqlPart;
            $result = Database::getConnection()->query($sql);
            $columnValue = $result->fetchColumn();
            if ($columnValue) {
                $referencedValues[$tableRefInfo['columnName']] = $columnValue;
            } else {
                $referencedValues = 0;
                break;
            }
        }
        
        return $referencedValues;
    }
}

?>
