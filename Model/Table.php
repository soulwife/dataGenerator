<?php
namespace Model;

/**
 * Operate with db table information
 *
 * @author Anastasiia
 */
class Table {
    private $_name;
    private $_otherFields;
    /* Array of Column*/
    private $_columns;
    
    /**
     * 
     * @param string $name
     * @param array $otherFields
     */
    public function __construct($name, $otherFields) {
       $this->_name = $name; 
       $this->_otherFields = $otherFields;
    }
    
    /**
     * 
     * @return string
     */
    public function getName() {
        return $this->_name;
    }
    
    /**
     * 
     * @return string
     */
    public function getFormattedName() {
        return "<h3>Table: " . $this->_name . "</h3>";
    }
    
    /**
     * 
     * @return string
     */
    public function getFormattedOtherFields() {
        $assocArrayToString = function ($v, $k) { 
            return $k . '=' . $v;             
        };
        return "<h5>Information: " . implode(';', array_map($assocArrayToString, $this->_otherFields, array_keys($this->_otherFields))) . "</h5>";
    }

    /**
     * 
     * @param array $columns
     */
    public function setColumns($columns) {
        $this->_columns = $columns;
    }
    
    /**
     * 
     * @return array
     */
    public function getColumns() {
        return $this->_columns;
    }
}
