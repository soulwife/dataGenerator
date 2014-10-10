<?php
require_once 'Autoloader.php';
use Model\Database, Model\Table, Model\Column, Model\TableFormatter, Model\TypeMapper;
require_once 'templates/header.html';
try {
    $db = new Database("127.0.0.1", "splendit", "root", "");
    //$db = new Database("127.0.0.1", "splendit", "root", "root");
    function getTables($db) {
        $tablesInfo = $db->getTablesInformation();
        foreach ($tablesInfo as $tableInfo) {
            $tables[] = new Table($tableInfo['name'], array_slice($tableInfo, 1));
        } 
        return $tables;
    }
    
    function  displayTablesWithColumns($db, $tables) {
        $tableFormatter = new TableFormatter(Database::$columns);
        foreach ($tables as $table) {
           echo $table->getFormattedName();
           echo $table->getFormattedOtherFields();
           echo $table->getFormattedForm();
           $tableColumns = $db->getColumnsInformation($table->getName());
           $table->setColumns($tableColumns);
           array_map(function($column) use (&$tableFormatter) {
               $tableFormatter->addRowsItems($column->getOtherFields());
           }, $tableColumns);
           echo $tableFormatter->createTable();
           $columns[] = $tableColumns;
        }
    }
    
    $tables = getTables($db);
    displayTablesWithColumns($db, $tables);


} catch (Exception $e) {
   echo $e->getMessage(); 
}
require_once 'templates/footer.html';