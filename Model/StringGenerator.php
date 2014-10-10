<?php
namespace Model;

/**
 * Description of StringGenerator
 *
 * @author anastasia
 */
class StringGenerator {
    const CHARSET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    public function generate($maxLength) {
        $str = '';
        $count = strlen(self::CHARSET) - 1;
        while ($maxLength--) {
            $str .= $charset[rand(0, $count)];
        }
        return $str;
    }
}

?>
