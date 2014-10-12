<?php
namespace Model\Generator;

/**
 * Description of EnumGenerator
 *
 * @author anastasia
 */
class EnumGenerator extends Generator {
    public function generate($maxLength = 0) {
        //no needed
    }
    
    public function generateFromPossibleValues($possibleValues) {
        return trim($possibleValues[array_rand($possibleValues)], "''");
    }
}

?>
