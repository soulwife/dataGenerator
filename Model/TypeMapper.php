<?php
namespace Model;


/**
 * Description of TypeMapper
 *
 * @author anastasia
 */
class TypeMapper {
    public static $typeList = [
        'integer' => ['TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'INTEGER', 'BIGINT', 'YEAR', 'BIT', 'BOOLEAN'],
        'float' => ['FLOAT', 'DOUBLE', 'REAL', 'DECIMAL', 'DEC'],
        'string' => ['CHAR', 'TEXT', 'VARCHAR', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT'],
        'enum' => ['ENUM', 'SET'],
        'datetime' => ['DATE', 'DATETIME', 'TIME'],
        'timestamp' => ['TIMESTAMP'],
        'blob' => ['TINYLOB', 'MEDIUMLOB', 'LONGLOB', 'BLOB', 'BINARY', 'VARBINARY']        
    ];
    
    public static function convertType($type) {
        $typeDefined = array_reduce(array_values(static::typeList), function($value) { 
            if (array_search($type, array_values($value))) {
                return $value;
            }
        });
        if ( ! $typeDefined ) {
            throw new \InvalidArgumentException($type . " is not a valid type. Please add it to the TypeMapper typeList array.");
        }
var_dump($typeDefined);
        return; //$this->typeList[$type];
    }
    
    public static function isNumeric($type) {
        
    }
    
    public static function isString($type) {
        
    }
    
    public static function isDate($type) {
        
    }
    
    public static function isBinary($type) {
        
    }
}

?>
