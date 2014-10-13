<?php
namespace Model\Generator;

/**
 * Generates random elements for Date type
 *
 * @author anastasia
 */
class DatetimeGenerator extends Generator{
    
    /**
     * {@inheritdoc}
     */
    public function generate($maxLength = 0) {
        return date('Y-m-d', rand(0, microtime(true)));
    }
}

?>
