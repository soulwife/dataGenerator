<?php
namespace Model\Generator;

/**
 * Description of Generator
 *
 * @author anastasia
 */
abstract class Generator {
    abstract public function generate($maxLength = 0);
    public function generateWithoutValues($values, $maxLength = 0) {
        do {
            $genValue = $this->generate($maxLength);
        } while(in_array($genValue, $values));
        return $genValue;
    }
    /*some more?*/
}

?>