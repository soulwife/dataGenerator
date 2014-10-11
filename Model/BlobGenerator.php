<?php
namespace Model;

/**
 * Description of BlobGenerator
 *
 * @author anastasia
 */
class BlobGenerator extends Generator {
    public function generate($maxLength = 0) {
        return decbin(rand(1, $maxLength));
    }
}

?>
