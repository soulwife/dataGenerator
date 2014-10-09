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
    /* Array of Column*/
    private $_columns;
    
    public function __construct($name, $otherFields) {
       $this->_name = $name; 
       $this->_otherFields = $otherFields;
    }
    
    public function getName() {
        return $this->_name;
    }
    
    public function getFormattedName() {
        return "<h4>Table: " . $this->_name . "</h4>";
    }
    
    public function getFormattedOtherFields() {
        $assocArrayToString = function ($v, $k) { 
            return $k . '=' . $v;             
        };
        return "<h5>Information: " . implode(';', array_map($assocArrayToString, $this->_otherFields, array_keys($this->_otherFields))) . "</h5>";
    }
    
    public function setColumns($columns) {
        $this->_columns = $columns;
    }
    
    public function getColumns() {
        return $this->_columns;
    }
}
