<?php
namespace Model\Generator;

/**
 * General Generator class
 *
 * @author anastasia
 */
abstract class Generator {
    /**
     * Generate elements 
     * @param mixed $maxLength
     */
    abstract public function generate($maxLength = 0);
    
    /**
     * Generate random value and check if it's not in $values 
     * @param array $values
     * @param mixed $maxLength
     * @return mixed
     */
    public function generateWithoutValues($values, $maxLength = 0) {
        do {
            $genValue = $this->generate($maxLength);
        } while(in_array($genValue, $values));
        
        return $genValue;
    }
}

?>
