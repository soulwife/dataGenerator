<?php
namespace Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Table
 *
 * @author Anastasiia
 */
class Table {
    private $_name;
    private $_otherFields;
    
    public function __construct($name, $otherFields) {
       $this->_name = $name; 
       $this->_otherFields = $otherFields;
    }
    
    public function getName() {
        return $this->_name;
    }
    
    public function getFormattedName() {
        return "<p>Table: " . $this->_name . "</p>";
    }
    
    public function getFormattedOtherFields() {
        $assocArrayToString = function ($v, $k) { 
            return $k . '=' . $v;             
        };
        return "<p>Information: " . implode(';', array_map($assocArrayToString, $this->_otherFields, array_keys($this->_otherFields))) . "</p>";
    }
}
