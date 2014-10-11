<?php
require_once 'Autoloader.php';
use Model\Database, Model\Table, Model\Column, Model\TableFormatter, Model\TypeMapper, Model\Row, Model\RowRepository, Model\KeyReference;
try {
    $db = new Database("127.0.0.1", "splendit", "root", "");
    function generate($db) {
        $tableName = $_POST['table'];
        $amount = $_POST['amount'];
        if (empty($tableName) || ! is_numeric($amount) || $amount < 1) {
            return;
        }

        $table = $db->createTable($db->getTable($tableName));
        
        if ($table) {
            $tableColumns = $db->getColumnsInformation($table->getName());
 var_dump($tableColumns);
            $repository = new RowRepository($db->getConnection());
            $keyReference = new KeyReference($db->getConnection());
            $referencedValues = $keyReference->getReferencingColumnsValuesForTable($table->getName());
            if (is_array($referencedValues)) {
                $rowGenerator = new Row($tableName, $tableColumns, $repository, $referencedValues);
                $rowGenerator->createRows($amount);
            } else {
                throw new \Exception("Sorry, but the table " . $table . "have the referenced columns in other table(s), but it(their) is empty now, please generate row(s) for it(them) firstly.");
            }
        }
    }

    generate($db);
}
catch (Exception $e) {
   echo $e; 
}
require_once 'templates/footer.html';