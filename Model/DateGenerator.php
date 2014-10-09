<?php

/**
 * Description of DateGenerator
 *
 * @author anastasia
 */
class DateGenerator {
    public function generate() {
        $time = rand(0, microtime());
        return date('Y-m-d', $time);
    }
}

?>
