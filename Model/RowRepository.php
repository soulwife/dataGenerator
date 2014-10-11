<?php
namespace Model;
use PDO;
/**
 * Description of RowRepository
 *
 * @author anastasia
 */
class RowRepository {
    public function insert($table, $names, $rowsValues) {      
        try {
            $connection = Database::getConnection();
            $connection->beginTransaction();
            foreach ($rowsValues as $oneRowValues) {
                $sql = "INSERT INTO `" . $table . "` (" . $names . ") VALUES (" . $oneRowValues . ")";
                var_dump($sql);
                $connection->query($sql);
            }

            $connection->commit(); 
        } catch (PDOExecption $e) {
            $connection->rollback(); 
            echo "Insertion error: " . $e->getMessage();
        }        
    }
    
    public function getAlreadyUsedValues($tableName, $columnName) {
        $result = Database::getConnection()->query("SELECT `" . $columnName . "` FROM $tableName ");
        $values = $result->fetchAll() ? : [];
        return call_user_func_array('array_merge', $values);
    } 
}

?>
