<?php
namespace Model\Generator;

/**
 * Description of DateGenerator
 *
 * @author anastasia
 */
class DatetimeGenerator extends Generator{
    public function generate($maxLength = 0) {
        return date('Y-m-d', rand(0, microtime(true)));
    }
}

?>
