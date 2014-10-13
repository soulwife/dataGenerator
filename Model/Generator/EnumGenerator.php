<?php
namespace Model\Generator;

/**
 * Selects random element from data 
 *
 * @author anastasia
 */
class EnumGenerator extends Generator {
    
    /**
     * {@inheritdoc}
     */
    public function generate($maxLength = 0) {}
    
    /**
     * 
     * @param array $possibleValues
     * @return string
     */
    public function generateFromPossibleValues($possibleValues) {
        return trim($possibleValues[array_rand($possibleValues)], "''");
    }
}

?>
