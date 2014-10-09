<?php
require_once 'Autoloader.php';
use Model\Database, Model\Table, Model\Column, Model\TableFormatter, Model\TypeMapper;
try {
    $db = new Database("127.0.0.1", "splendit", "root", "");
    function generate($db) {
        $tableName = $_POST['table'];
        $amount = $_POST['amount'];
        if (empty($tableName) || ! is_numeric($amount)) {
            return;
        }

        $table = $db->createTable($db->getTable($tableName));
        if ($table) {
            $tableColumns = $db->getColumnsInformation($table->getName());
        }
        var_dump($tableColumns);
    }

    generate($db);
}
catch (Exception $e) {
   echo $e; 
}
require_once 'templates/footer.html';