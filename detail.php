<?php
session_start();
require_once 'Autoloader.php';
use Model\Database, Model\Table, Model\TableFormatter, Model\TableRepository;
require_once 'templates/header.html';
require_once 'templates/backToList.html';
function getDetail() {
    $tableRepository = new TableRepository();
    $tableName = $_POST['table'];
    if ( ! $tableName || empty($tableName)) {
        echo "Please choose the table.";
        return;
    }
    $data = $tableRepository->getTableData($tableName);
    if (empty($data)) {
        echo "The table " . $tableName ." is empty. You can generate random data for this table on the main page";
    } else {    
        $tableFormatter = new TableFormatter($tableRepository->getTableColumnHeaders($tableName));
        array_map(function($row) use (&$tableFormatter) {
           $tableFormatter->addRowsItems($row);
        }, $data);
        echo $tableFormatter->createTable();
    }
}
getDetail();
require_once 'templates/backToList.html';
require_once 'templates/footer.html';