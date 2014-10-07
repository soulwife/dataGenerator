<?php


/**
 * Description of Autoloader
 *
 * @author Anastasiia
 */
class Autoloader {
    public static function autoload($className) {
       $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className) . ".php";
       $filePath = __DIR__ . DIRECTORY_SEPARATOR . $fileName;
       if (file_exists($filePath)) {
           require_once($filePath);
       } else {
           return false;
       }
    }
}
spl_autoload_register('Autoloader::autoload');