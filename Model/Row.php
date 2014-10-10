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
    private $_tableName;
    private $_fieldsForChooseFrom = [];
    public function __construct($tableName, $columns, $repository) {
        $this->_repository = $repository;
        $this->_tableName = $tableName;
        $generatorsClassNames = [];
        foreach ($columns as $column) {
            if ( ! $column->isAutoIncremented()) {
                // generate unique key if no length presented
                $typesLengthOrTypeKey = $column->getMaxLength() ? : $column->_name; 
                if ($column->isEnumType()) {
                    $this->_fieldsForChooseFrom[$column->_name] = $column->getEnumFields();
                    $typesLengthOrTypeKey = $column->_name;
                }
                $type = $column->getConvertedType();
                $this->_types[$typesLengthOrTypeKey] = $type;
                $this->_names[] = $column->_name;
                $generatorClassName = __NAMESPACE__ . "\\" . ucfirst($type) . "Generator";
                if ( ! in_array($generatorClassName, $generatorsClassNames)) {
                    $generatorsClassNames[] = $generatorClassName;
                    $this->_generators[$column->getConvertedType()] = new $generatorClassName();
                }
 
            }
        }
    }
       
    public function createRows($amount) {
        $rowCount = 0;
        while ($rowCount < $amount) {
            $rows[] = $this->createRow();
            $rowCount++;
        }
        
        $this->_repository->insert($this->_tableName, "`" . implode("`,`", $this->_names) . "`", $rows);
    }
    
    private function createRow() {
        foreach ($this->_types as $key => $type) {          
            $values[] = 
                    "'" . (
                    $type == TypeMapper::ENUM 
                    ? $this->_generators[$type]->generateFromPossibleValues($this->_fieldsForChooseFrom[$key]) 
                    : $this->_generators[$type]->generate($key)
                    ) . "'";  
        }               
                
        return implode(",", $values);
    }
}

?>
