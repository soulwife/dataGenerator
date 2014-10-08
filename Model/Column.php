<?php
namespace Model;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Column
 *
 * @author anastasia
 */
class Column {
    private $_name;
    private $_otherFields = [];   
    
    public function __construct($name, $otherFields = []) {
       $this->_name = $otherFields['COLUMN_NAME']; 
       $this->_otherFields = $otherFields;
    }
    
    public function __get($field) { 
        return $this->_otherFields[$field]; 
        
    } 
    
    public function __set($field, $val) { 
        $this->_otherFields[$field] = $val;         
    } 
    
    public function getName() {
        return $this->_name;
    }
}

?>
