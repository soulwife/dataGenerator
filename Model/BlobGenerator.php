<?php
namespace Model;

/**
 * Description of BlobGenerator
 *
 * @author anastasia
 */
class BlobGenerator {
    public function generate($maxLength) {
        return decbin(rand(1, $maxLength));
    }
}

?>
