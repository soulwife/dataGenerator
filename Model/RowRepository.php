<?php
namespace Model;

/**
 * Description of RowRepository
 *
 * @author anastasia
 */
class RowRepository {
    private $_connection;
    
    public function __construct($connection) {
        $this->_connection = $connection;
    }
    public function insert($table, $names, $rowsValues) {
        var_dump($names, $rowsValues);
        $preparedResult = $this->_connection->prepare($sql);
        try {
            $this->_connection->beginTransaction();
            foreach ($rowsValues as $oneRowValues) {
                $sql = "INSERT INTO `" . $table . "` (" . $names . ") VALUES (" . $oneRowValues . ")";
                var_dump($sql);
                $this->_connection->query($sql);
            }
            $this->_connection->commit(); 
        } catch (PDOExecption $e) {
            $this->_connection->rollback(); 
            echo "Insertion error: " . $e->getMessage();
        }
        
    }
}

?>
