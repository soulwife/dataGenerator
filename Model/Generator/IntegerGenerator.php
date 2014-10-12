<?php
namespace Model;namespace Model\Generator;
/**
 * Description of NumberGenerator
 *
 * @author anastasia
 */
class IntegerGenerator extends Generator {
    public function generate($maxLength = 0) {
        return mt_rand(0, $maxLength > 1 ? pow(10, $maxLength) : 1);
    }    
}

?>
