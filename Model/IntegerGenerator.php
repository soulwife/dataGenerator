<?php
namespace Model;

/**
 * Description of NumberGenerator
 *
 * @author anastasia
 */
class NumberGenerator {
    public function generate($maxLength) {
        return rand(0, $maxLength);
    }
}

?>
