<?php
namespace Model\Generator;

/**
 * Generate random float values
 *
 * @author anastasia
 */
class FloatGenerator extends Generator {
    
    /**
     * {@inheritdoc}
     */
    public function generate($maxLength = 0) {
        return round(lcg_value()*(rand(0, $maxLength)), $maxLength);
    }
}

?>
