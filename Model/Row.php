<?php
namespace Model;
use Model\Repository\RowRepository; 

/**
 * Operate with table row
 *
 * @author anastasia
 */
class Row {
    const REFERENCED_TYPE = 'referenced';
    const TYPE = 'type';
    const MAX_LENGTH = 'maxlength';
    const UNIQUE_OR_PRIMARY = "uniqueOrPrimary";
    
    private $_columnsInfo = [];
    private $_names = [];
    private $_generators = [];
    private $_repository;
    private $_tableName;
    private $_fieldsForChooseFrom = [];
    private $_referencedValues = [];
    
    /**
     * Create $this->_columnsInfo with data: type, maxLength and key type, initialize necessary type generators, 
     * remember necessary (for enum or primary) values in $this->_fieldsForChooseFrom
     * 
     * @param string $tableName
     * @param array $columns
     * @param RowRepository $repository
     * @param array $referencedValues
     * @throws \Exception
     */
    public function __construct($tableName, $columns, $repository, $referencedValues) {
        $this->_repository = $repository;
        $this->_tableName = $tableName;
        $this->_referencedValues = $referencedValues;
        $generatorsClassNames = [];

        foreach ($columns as $column) {
            if ($column->isAutoIncremented()) {
                continue;
            }
            
            $this->_names[] = $column->_name;
            if (key_exists($column->_name, $referencedValues)) {
                if ($column->isUnique() || $column->isPrimary()) {
                    throw new \Exception("Sorry, but the column `" . $column->_name . "` 
                        have referenced unique column, so the system can't create row for this table without a new row in referenced tables.");
                }
                $this->_columnsInfo[$column->_name][self::TYPE] = self::REFERENCED_TYPE;
            } else {    
                if ($column->isEnumType()) {
                    $this->_fieldsForChooseFrom[$column->_name] = $column->getEnumFields();
                } elseif ($column->isUnique() || $column->isPrimary()) {
                    $this->_fieldsForChooseFrom[$column->_name] = $repository->getAlreadyUsedValues($tableName, $column->_name);
                }
                $type = $column->getConvertedType();
                $this->_columnsInfo[$column->_name][self::TYPE] = $type;
                $this->_columnsInfo[$column->_name][self::MAX_LENGTH] = $column->getMaxLength();
                $this->_columnsInfo[$column->_name][self::UNIQUE_OR_PRIMARY] = $column->isUnique() || $column->isPrimary();
                
                //initialize necessary types generators
                $generatorClassName = __NAMESPACE__ . "\\Generator\\" . ucfirst($type) . "Generator";
                if ( ! in_array($generatorClassName, $generatorsClassNames)) {
                    $generatorsClassNames[] = $generatorClassName;
                    $this->_generators[$column->getConvertedType()] = new $generatorClassName();
                }
            }
        }
    }
     
    /**
     * Generate and insert rows to table
     * 
     * @param integer $amount
     * @return boolean
     */
    public function createRows($amount) {
        $rowCount = $result = 1;
        while ($rowCount <= $amount && $result) {
            $rows[] = $this->createRow();
            $rowCount++;
            if ($rowCount >= RowRepository::TRANSACTION_LIMIT || $rowCount > $amount) {
                $result = $this->_repository->insert($this->_tableName, "`" . implode("`,`", $this->_names) . "`", $rows);
                $amount = $amount - $rowCount;
                $rowCount = 1;
                $rows = [];
            }
        }
        
        return $result;
    }
    
    /**
     * Generate values for one row
     * @return string
     */
    private function createRow() {
        foreach ($this->_columnsInfo as $key => $typeAndLengths) {
            switch ($typeAndLengths[self::TYPE]) {
                case TypeMapper::ENUM :
                    $value =  $this->_generators[$typeAndLengths[self::TYPE]]->generateFromPossibleValues($this->_fieldsForChooseFrom[$key]);
                    break;
                case self::REFERENCED_TYPE :
                    $value = $this->_referencedValues[$key];
                    break;
                default : 
                    if ($typeAndLengths[self::UNIQUE_OR_PRIMARY]) {
                        $value = $this->_generators[$typeAndLengths[self::TYPE]]->generateWithoutValues($this->_fieldsForChooseFrom[$key], $typeAndLengths[self::MAX_LENGTH]);
                    } else {
                        $value = $this->_generators[$typeAndLengths[self::TYPE]]->generate($typeAndLengths[self::MAX_LENGTH]);  
                    }
            }
            $values[] = "'" . $value . "'"; 
        }               
                
        return implode(",", $values);
    }    
}

?>
