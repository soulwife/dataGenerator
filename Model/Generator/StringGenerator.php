<?php
namespace Model\Generator;

/**
 * Description of StringGenerator
 *
 * @author anastasia
 */
class StringGenerator extends Generator {
    const MAX_POSSIBLE_LENGTH = 10000;
    public function generate($maxLength = 0) {
        $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz 0123456789';
        $str = '';
        $count = strlen($charset) - 1;
        $maxPossibleLength = $maxLength < self::MAX_POSSIBLE_LENGTH ? $maxLength : self::MAX_POSSIBLE_LENGTH;
        $strLength = mt_rand($maxPossibleLength % mt_rand($maxPossibleLength, $maxPossibleLength*1000), $maxPossibleLength);
        while ($strLength--) {
            $str .= $charset[mt_rand(0, $count)];
        }
        
        return $str;
    }
}

?>
