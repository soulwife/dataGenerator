<?php
namespace Model\Repository;
use PDO, Model\Database;
/**
 * Database repository for operating on rows level 
 *
 * @author anastasia
 */
class RowRepository {
    const TRANSACTION_LIMIT = 100;
    
    /**
     * Insert rows to table in transaction
     * @param string $table
     * @param string $names
     * @param array $rowsValues
     * @return boolean
     */
    public function insert($table, $names, $rowsValues) {      
        try {
            Database::getConnection()->beginTransaction();
            foreach ($rowsValues as $oneRowValues) {
                $sql = "INSERT INTO `" . $table . "` (" . $names . ") VALUES (" . $oneRowValues . ")";
                Database::getConnection()->query($sql);
            }

            return Database::getConnection()->commit(); 
        } catch (PDOExecption $e) {
            Database::getConnection()->rollback(); 
            echo "Insertion error: " . $e->getMessage();
        }        
    }
    
    /**
     * Get specific column elements from table
     * @param string $tableName
     * @param string $columnName
     * @return type
     */
    public function getAlreadyUsedValues($tableName, $columnName) {
        $result = Database::getConnection()->query("SELECT `" . $columnName . "` FROM $tableName ");
        $values = $result->fetchAll() ? : [];
        return call_user_func_array('array_merge', $values);
    } 
}

?>
