<?php
require_once 'Autoloader.php';
use Model\Database, Model\Table, Model\Column, Model\TableFormatter;
try {
    $db = new Database("127.0.0.1", "splendit", "root", "root");
    $tablesInfo = $db->getTablesInformation();
    foreach ($tablesInfo as $tableInfo) {
        $tables[] = new Table($tableInfo['name'], array_slice($tableInfo, 1));
    }

    foreach ($tables as $table) {
       //echo $table->getFormattedName() . "<br />";
       //echo $table->getFormattedOtherFields() . "<br />";
       $columns[] = $db->getColumnsInformation($table->getName());
    }
//var_dump($columns[0]);
    $tableFormatter = new TableFormatter(array_keys($columns[0][0]));
    foreach ($columns as $columnInfo) {
        $tableFormatter->addRowsItems($columnInfo);
    }

    echo $tableFormatter->createTable();


} catch (Exception $e) {
   echo $e; 
}


