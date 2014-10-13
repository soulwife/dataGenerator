<?php
namespace Model;
use Model\Formatter\HtmlTableFormatter, Model\Repository\RowRepository, Model\Repository\TableRepository;
/**
 * Display necessary views
 *
 * @author Anastasiia
 */
class View {
    
    /**
     * Display tables general info with table columns general info and 'generate' and 'show detail' forms.
     * @param string $tables
     * @param Model\KeyReference $keyReference
     */
    function displayTablesWithColumns($tables, $keyReference) {
        $tableFormatter = new HtmlTableFormatter(TableRepository::$columns);
        $tableRepository = new TableRepository;
        $tableForm = new TableForm;
        foreach ($tables as $table) {
           echo $table->getFormattedName();
           echo $table->getFormattedOtherFields();
           echo $this->displayTableRowsCount($table->getName(), $tableRepository);
           echo $keyReference->getFormattedReferencedForTables($table->getName());
           echo $tableForm->getFormattedGeneratorForm($table->getName());
           $tableColumns = $tableRepository->getColumnsInformation($table->getName());
           $table->setColumns($tableColumns);
           array_map(function($column) use (&$tableFormatter) {
               $tableFormatter->addRowsItems($column->getOtherFields());
           }, $tableColumns);
           echo $tableFormatter->createTable();
           echo $tableForm->getShowDetailsForm($table->getName());
           $columns[] = $tableColumns;
        }
    }
    
    /**
     * Generate rows view
     * @return boolean
     * @throws \Exception
     */
    public function generate() {
        $tableName = $_POST['table'];
        $amount = $_POST['amount'];
        if (empty($tableName) || ! is_numeric($amount) || $amount < 1) {
            return;
        }
        $tableRepository = new TableRepository;
        $table = $tableRepository->createTable($tableRepository->getTable($tableName));
        
        if ( ! $table) {
            return;
        }    
        $tableColumns = $tableRepository->getColumnsInformation($table->getName());
        $repository = new RowRepository();
        $keyReference = new KeyReference();
        $referencedValues = $keyReference->getReferencingColumnsValuesForTable($table->getName());
        if (is_array($referencedValues)) {
            $rowGenerator = new Row($tableName, $tableColumns, $repository, $referencedValues);
            return $rowGenerator->createRows($amount);
        } else {
            throw new \Exception("Sorry, but the table " . $table . "have the referenced columns in other table(s), but it(their) is empty now, please generate row(s) for it(them) firstly.");
        }
    }
    
    /**
     * Specific table details view
     * @return type
     */
    public function getDetail() {
        $tableRepository = new TableRepository();
        $tableName = $_POST['table'];
        if ( ! $tableName || empty($tableName)) {
            echo "Please choose the table.";
            return;
        }
        $data = $tableRepository->getTableData($tableName);
        if (empty($data)) {
            echo "The table " . $tableName ." is empty. You can generate random data for this table on the main page.";
        } else {    
            $tableFormatter = new HtmlTableFormatter($tableRepository->getTableColumnHeaders($tableName));
            array_map(function($row) use (&$tableFormatter) {
               $tableFormatter->addRowsItems($row);
            }, $data);
            echo $tableFormatter->createTable();
        }
    }
    
    /**
     * 
     * @param string $tableName
     * @param Model\Repository\TableRepository $tableRepository
     * @return string
     */
    public function displayTableRowsCount($tableName, $tableRepository) {
        $count = $tableRepository->getTableTotalRowsCount($tableName);
        return "Total rows count: " . $count[0];
    }
}
