<?php
namespace Model;

/**
 * Description of DateGenerator
 *
 * @author anastasia
 */
class DatetimeGenerator {
    public function generate() {
        return date('Y-m-d', rand(0, microtime(true)));
    }
}

?>
