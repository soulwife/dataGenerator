<?php
namespace Model\Generator;

/**
 * Generates random integer values
 *
 * @author anastasia
 */
class IntegerGenerator extends Generator {
    
    /**
     * {@inheritdoc}
     */
    public function generate($maxLength = 0) {
        return mt_rand(0, $maxLength > 1 ? pow(10, $maxLength) : 1);
    }    
}

?>
