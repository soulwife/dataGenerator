<?php
namespace Model;


/**
 * Description of TypeMapper
 *
 * @author anastasia
 */
class TypeMapper {
    const ENUM = 'enum';
    public static $typeList = [
        'integer' => ['TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'INTEGER', 'BIGINT', 'YEAR', 'BIT', 'BOOLEAN'],
        'float' => ['FLOAT', 'DOUBLE', 'REAL', 'DECIMAL', 'DEC'],
        'string' => ['CHAR', 'TEXT', 'VARCHAR', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT', 'TINYBLOB', 'MEDIUMBLOB', 'LONGBLOB', 'BLOB', 'BINARY', 'VARBINARY'],
        'enum' => ['ENUM', 'SET'],
        'datetime' => ['DATE', 'DATETIME', 'TIME', 'TIMESTAMP'],
        /* TODO: 'blob' => ['TINYBLOB', 'MEDIUMBLOB', 'LONGBLOB', 'BLOB', 'BINARY', 'VARBINARY'] */
    ];
    static $mappedType = null;
    public static function convertType($type) {
        $convertedType = self::defineSpecificType(static::$typeList, $type);
        self::$mappedType = null;
        if ( ! $convertedType ) {
            throw new \InvalidArgumentException($type . " is not a valid type. Please add it to the TypeMapper typeList array.");
        }

        return $convertedType;
    }
    
    public static function defineSpecificType($definedTypes, $type, $typeName = null) {
        if ( ! self::$mappedType) {
            foreach ($definedTypes as $currentKeyType => $definedType) {
                if (is_array($definedType)) {
                    static::defineSpecificType($definedType, $type, $currentKeyType);
                } else {
                    if (strpos(strtoupper($type), $definedType) !== FALSE) {
                        self::$mappedType = $typeName;
                        break;
                    }
                }
            }
        }
        
        return self::$mappedType;
    }
    
    public static function isNumeric($type) {
        return $type == 'integer';
    }
    
    public static function isEnum($type) {
       return $type == 'enum'; 
    }
    
    public static function isDate($type) {
        
    }
    
    public static function isBinary($type) {
        
    }
}

?>
