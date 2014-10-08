<?php
namespace Model;

/**
 * Description of Column
 *
 * @author anastasia
 */
class Column {
    private $tableName;
    private $_otherFields = [];   
    
    public function __construct() {

    }
    
    public function __get($field) { 
        return $this->_otherFields[$field]; 
        
    } 
    
    public function __set($field, $val) {
        $this->_otherFields[$field] = $val; 
    } 
    
    public function getOtherFields() {
        return $this->_otherFields;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
    }
    
    public function getTableName() {
        return $this->tableName;
    }
}

?>
