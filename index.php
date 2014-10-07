<?php
require_once 'Autoloader.php';
use Model\Database, Model\Table;
try {
$db = new Database("127.0.0.1", "mysql", "root", "");
$tablesInfo = $db->getTablesInformation();
foreach ($tablesInfo as $tableInfo) {
    $tables[] = new Table($tableInfo['name'], array_slice($tableInfo, 1));
}
foreach ($tables as $table) {
   echo $table->getFormattedName() . "<br />";
   echo $table->getFormattedOtherFields() . "<br />";
}
//$db->getColumnsInformation();
} catch (Exception $e) {
   echo $e; 
}


