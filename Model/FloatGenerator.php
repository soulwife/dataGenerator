<?php
namespace Model;

/**
 * Description of NumberGenerator
 *
 * @author anastasia
 */
class FloatGenerator {
    public function generate($maxLength) {
        return round(lcg_value()*(rand(0, $maxLength)), $maxLength);
    }
}

?>
