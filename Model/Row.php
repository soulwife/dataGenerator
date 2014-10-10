<?php
namespace Model;

/**
 * Description of Row
 *
 * @author anastasia
 */
class Row {
    private $_types = [];
    private $_names = [];
    private $_generators = [];
    private $_repository;
    
    public function __construct($columns, $repository) {
        $this->_repository = $repository;
        foreach ($columns as $column) {
            if ( ! $column->isAutoIncremented()) {
                $this->_types[] = $column->getConvertedType();
                $this->_names[] = $column->getName();
                $generatorClassName = ucfirst($column->getConvertedType()) . "Generator";
                if ( ! in_array($generatorClassName, $this->_generators)) {
                    $this->_generators[$column->getConvertedType()] = new $generatorClassName;
                }
            }
        }
    }
       
    public function createRows($amount) {
        $rowCount = 0;
        while ($rowCount < $amount) {
            $this->createRow();
            $rowCount++;
        }
    }
    
    private function createRow() {
        foreach ($this->_types as $type) {
            $values[] = $this->_generators[$type]->generate();
        }               
                
        $this->_repository->insertRow(implode(",", $this->_names), implode(",", $values));
    }
}

?>
