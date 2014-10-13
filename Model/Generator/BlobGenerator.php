<?php
namespace Model\Generator;

/**
 * Generates random elements for BLOB MySql types
 *
 * @author anastasia
 */
class BlobGenerator extends Generator {
    const MAX_POSSIBLE_LENGTH = 1000;
    
    /**
     * {@inheritdoc}
     */
    public function generate($maxLength = 0) {
        /* TODO: implement random images generating, now using StringGenerator for Blobs*/
    }
}

?>
