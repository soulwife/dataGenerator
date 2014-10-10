<?php
namespace Model;

/**
 * Description of EnumGenerator
 *
 * @author anastasia
 */
class EnumGenerator {
    public function generate() {
        //no needed
    }
    
    public function generateFromPossibleValues($possibleValues) {
        return trim($possibleValues[array_rand($possibleValues)], "''");
    }
}

?>
