<?php
session_start();
require_once 'Autoloader.php';
use Model\Database, Model\Table, Model\Column, Model\TableFormatter, Model\TypeMapper, Model\Row, Model\RowRepository, Model\KeyReference, Model\TableRepository;
try {
    function generate() {
        $tableName = $_POST['table'];
        $amount = $_POST['amount'];
        if (empty($tableName) || ! is_numeric($amount) || $amount < 1) {
            return;
        }
        $tableRepository = new TableRepository;
        $table = $tableRepository->createTable($tableRepository->getTable($tableName));
        
        if ($table) {
            $tableColumns = $tableRepository->getColumnsInformation($table->getName());
 var_dump($tableColumns);
            $repository = new RowRepository();
            $keyReference = new KeyReference();
            $referencedValues = $keyReference->getReferencingColumnsValuesForTable($table->getName());
            if (is_array($referencedValues)) {
                $rowGenerator = new Row($tableName, $tableColumns, $repository, $referencedValues);
                $rowGenerator->createRows($amount);
            } else {
                throw new \Exception("Sorry, but the table " . $table . "have the referenced columns in other table(s), but it(their) is empty now, please generate row(s) for it(them) firstly.");
            }
        }
    }

    generate();
}
catch (Exception $e) {
   echo $e; 
}
require_once 'templates/backToList.html';
require_once 'templates/footer.html';