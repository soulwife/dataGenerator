<?php
namespace Model;
/**
 * Description of KeyReference
 *
 * @author anastasia
 */
class KeyReference {
    
    const MAIN_PART_OF_SQL = "SELECT `TABLE_NAME` as table, `COLUMN_NAME` as column 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_SCHEMA = DATABASE() "; 
    
    private $_connection;
    private $_referencedColumns = [];
    private $_referencedTables = [];
    
    function __construct(PDO $connection) {
        $this->_connection = $connection;
    }
    
    function getReferencingTablesAndColumns($table, $column) {
        $result = $this->_referencedColumns[$table][$column];     
        
        if (!isset($result)) {
            $sql = self::MAIN_PART_OF_SQL . "AND REFERENCED_TABLE_NAME = :table AND REFERENCED_COLUMN_NAME = :column";
            $preparedResult = $this->_connection->prepare($sql);
            $preparedResult->execute(array(':table' => $this->_connection->quote($table), ':column' => $this->_connection->quote($column)));
            $result = $preparedResult->fetch(PDO::FETCH_ASSOC);
            $this->_referencedColumns[$table][$column] = $result;           
        }
        
        return $result; 
    }
    
    function getReferencedTables($table) {
        $result = $this->_referencedTables[$table];     
        
        if (!isset($result)) {
            $sql = self::MAIN_PART_OF_SQL . "AND TABLE_NAME = :table";
            $preparedResult = $this->_connection->prepare($sql);
            $preparedResult->execute(array(':table' => $this->_connection->quote($table)));
            $result = $preparedResult->fetch(PDO::FETCH_ASSOC);
            $this->_referencedColumns[$table][$column] = $result;           
        }
        
        return $result; 
    }
}

?>
