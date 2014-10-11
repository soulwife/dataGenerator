<?php
namespace Model;

/**
 * Description of Column
 *
 * @author anastasia
 */
class Column {
    const AUTO_INCREMENT = "auto_increment";
    const UNIQUE = "UNI";
    const PRIMARY = "PRI";
    
    private $_tableName;
    private $_otherFields = [];
    private $_convertedType;
    private $_maxLength;
   
    static $indexTypes = array(self::UNIQUE, self::PRIMARY);
    
    public function __construct() {
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
    
    public function getConvertedType() {
        return $this->_convertedType;
    }
    
    public function setMaxLength() {
        $this->_maxLength = TypeMapper::isNumeric($this->_convertedType) ? $this->_numLength : $this->_charLength;
    }
    
    public function getMaxLength() {
        return $this->_maxLength;
    }
    
    public function isAutoIncremented() {
        return strpos($this->_extra, self::AUTO_INCREMENT) !== false; 
    }
    
    public function isEnumType() {
        return TypeMapper::isEnum($this->_convertedType);
    }
    
    public function getEnumFields() {
        return explode(",", trim(strstr($this->_type, "("), "()"));
    }
    
    public function isUnique() {
        return $this->_key == self::UNIQUE;
    }
    
    public function isPrimary() {
        return $this->_key == self::PRIMARY;
    }
}

?>
