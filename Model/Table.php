<?php
namespace Model;
use Model\Database;
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
    private $name;
    private $otherFields = [];
    
    public function __construct($name, $otherFields = []) {
       $this->name = $name; 
       $this->otherFields = $otherFields;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getFormattedName() {
        return "Table " . $this->name;
    }
    
    public function getFormattedOtherFields() {
        $assocArrayToString = function ($v, $k) { 
            return $k . '=' . $v;             
        };
        return "Information: " . implode(';', array_map($assocArrayToString, $this->otherFields, array_keys($this->otherFields)));
    }
}
