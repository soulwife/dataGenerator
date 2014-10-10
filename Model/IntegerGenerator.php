<?php
namespace Model;

/**
 * Description of NumberGenerator
 *
 * @author anastasia
 */
class IntegerGenerator {
    public function generate($maxLength) {
        return rand(0, $maxLength > 1 ? pow(10, $maxLength) : 1);
    }
}

?>
