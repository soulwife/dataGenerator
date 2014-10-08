<?php
require_once 'Autoloader.php';
use Model\Database, Model\Table, Model\Column, Model\TableFormatter;
require_once 'templates/header.html';
try {
    //$db = new Database("127.0.0.1", "splendit", "root", "root");
    $db = new Database("127.0.0.1", "splendit", "root", "");
    $tablesInfo = $db->getTablesInformation();
    foreach ($tablesInfo as $tableInfo) {
        $tables[] = new Table($tableInfo['name'], array_slice($tableInfo, 1));
    }

    $tableFormatter = new TableFormatter(Database::$columns);
    
    foreach ($tables as $table) {
       echo $table->getFormattedName();
       echo $table->getFormattedOtherFields();
       $tableColumns = $db->getColumnsInformation($table->getName());
       array_map(function($column) use (&$tableFormatter) {
           $tableFormatter->addRowsItems($column->getOtherFields());
       }, $tableColumns);
       echo $tableFormatter->createTable();
       $columns[] = $tableColumns;
    }
} catch (Exception $e) {
   echo $e; 
}
require_once 'templates/footer.html';