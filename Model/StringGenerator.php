<?php
namespace Model;

/**
 * Description of StringGenerator
 *
 * @author anastasia
 */
class StringGenerator extends Generator {
    const MAX_POSSIBLE_LENGTH = 10;
    public function generate($maxLength = 0) {
        $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $str = '';
        $count = strlen($charset) - 1;
        $strLength = rand(1, $maxLength < self::MAX_POSSIBLE_LENGTH ? $maxLength : self::MAX_POSSIBLE_LENGTH);
        while ($strLength--) {
            $str .= $charset[rand(0, $count)];
        }
        
        return $str;
    }
}

?>
