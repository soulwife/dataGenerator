<?php
namespace Model\Generator;

/**
 * Description of NumberGenerator
 *
 * @author anastasia
 */
class FloatGenerator extends Generator {
    public function generate($maxLength = 0) {
        return round(lcg_value()*(rand(0, $maxLength)), $maxLength);
    }
}

?>
