<?php
namespace Model;

/**
 * Description of TimeStampGenerator
 *
 * @author anastasia
 */
class TimeStampGenerator {
    public function generate() {
        return microtime();
    }
}

?>
