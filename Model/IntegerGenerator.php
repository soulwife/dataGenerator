<?php
namespace Model;

/**
 * Description of NumberGenerator
 *
 * @author anastasia
 */
class IntegerGenerator extends Generator {
    public function generate($maxLength = 0) {
        return rand(0, $maxLength > 1 ? pow(10, $maxLength) : 1);
    }    
}

?>
