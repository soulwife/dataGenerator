<?php
namespace Model;
use PDO;
/**
 * Specific singleton class for database connection
 *
 * @author Anastasiia
 */
 
class Database {

    private static $_connection;
    
    private function __construct() {}
    
    /**
     * 
     * @param string $dbHost
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPass
     * @return PDO
     * @throws Exception
     */
    private function setConnection($dbHost, $dbName, $dbUser, $dbPass) {
        try { 
            static::$_connection = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass); 
            static::$_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                  
        } catch (PDOException $e) {                 
            throw new Exception("Couldn't connect to database. PDO details: " . $e->getMessage());                 
        }

        static::$_connection->query("SET GLOBAL innodb_stats_on_metadata=0");
        return static::$_connection;
    }
    
    /**
     * 
     * @return PDO
     */
    final public static function getConnection() {
        if (empty(static::$_connection)) {
            $class = get_called_class();
            $db = new $class();
            static::$_connection = $db->setConnection($_SESSION['dbHost'], $_SESSION['dbName'], $_SESSION['dbUser'], $_SESSION['dbPass']);
        }

        return static::$_connection;
    }
    
    private function __clone() {}

    private function __wakeup() {}
    
    private function __sleep() {}
}

