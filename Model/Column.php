<?php
namespace Model;

/**
 * Collect one table's column information 
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
    
    /**
     * 
     * @param string $field
     * @return mixed
     */
    public function __get($field) { 
        
        return $this->_otherFields[$field];        
    } 
    
    /**
     * 
     * @param string $field
     * @param mixed $val
     */
    public function __set($field, $val) {
        $this->_otherFields[$field] = $val; 
    } 
    
    /**
     * 
     * @return array
     */
    public function getOtherFields() {
        return $this->_otherFields;
    }

    /**
     * 
     * @param string $tableName
     */
    public function setTableName($tableName) {
        $this->_tableName = $tableName;
    }
    
    /**
     * 
     * @return string
     */
    public function getTableName() {
        return $this->_tableName;
    }
    
    /**
     * Set TypeMapper type according with SQL type
     */
    public function setConvertedType() {
        $this->_convertedType = TypeMapper::convertType($this->_type);
    }
    
    /**
     * 
     * @return string
     */
    public function getConvertedType() {
        return $this->_convertedType;
    }
    
    /**
     * Set column max length
     */
    public function setMaxLength() {
        $this->_maxLength = TypeMapper::isNumeric($this->_convertedType) ? $this->_numLength : $this->_charLength;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getMaxLength() {
        return $this->_maxLength;
    }
   
    /**
     * 
     * @return boolean
     */
    public function isAutoIncremented() {
        return strpos($this->_extra, self::AUTO_INCREMENT) !== false; 
    }
    
    /**
     * 
     * @return boolean
     */
    public function isEnumType() {
        return TypeMapper::isEnum($this->_convertedType);
    }
    
    /**
     * Get all column enum
     * @return array
     */
    public function getEnumFields() {
        return explode(",", trim(strstr($this->_type, "("), "()"));
    }
    
    /**
     * 
     * @return boolean
     */
    public function isUnique() {
        return $this->_key == self::UNIQUE;
    }
    
    /**
     * 
     * @return boolean
     */
    public function isPrimary() {
        return $this->_key == self::PRIMARY;
    }
}

?>
