<?php
namespace Model;

/**
 * Description of Column
 *
 * @author anastasia
 */
class Column {
    private $_tableName;
    private $_otherFields = [];
    private $_convertedType;
    private $_maxLength;
    
    public function __construct() {
        var_dump("test");
        $this->setConvertedType();
        $this->setMaxLength();
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
        $this->_tableName = $tableName;
    }
    
    public function getTableName() {
        return $this->_tableName;
    }
    
    public function setConvertedType() {
        $this->_convertedType = TypeMapper::convertType($this->_type);
    }
    
    public function setMaxLength() {
        $this->_maxLength = TypeMapper::isNumeric($this->_convertedType) ? $this->_numLength : $this->_charLength;
    }
    
    public function getMaxLength() {
        return $this->_maxLength;
    }
}

?>
