<?php
namespace Model\Formatter;

/**
 * Description of TableFormatter
 *
 * @author anastasia
 */
class HtmlTableFormatter extends HtmlFormatter {
    protected $headerItems = array();
    protected $rowItems = array();
    protected $table;

    public function __construct($headers) {
        $this->addHeaderItems($headers);
    }
    
    public function createTable() {
	$table = "<table class='table table-bordered table-hover table-striped'>";
        $table .= $this->wrapElementToHtml("thead", $this->createHeader());   
        $table .= $this->wrapElementToHtml("tbody", $this->createRows());
        $table .= "</table>";
        $this->clearRows();
        return $table;
    }
    
    public function addHeaderItems($elements) {
        $this->headerItems = $elements;      
    } 
    
    public function getHeaderItems() {
	return $this->headerItems;
    }
    
    public function addRowsItems($elements) {      
        $this->rowItems[] = $elements; 
    }
    
    public function getRowsItems() {
	return $this->rowItems;
    }
    
    private function createHeader() {
        $tableHead = function($item) {
            return $this->wrapElementToHtml("th", $item);            
        };

        return implode("", array_map($tableHead, $this->headerItems));
    }
    
    private function createRows() {
        $tableRow = "";
         foreach ($this->rowItems as $row) {
            $tableRow .= $this->createRow($row);
        }
        return $tableRow;
    }
    
    private function createRow($rowElements) {
        $row = "<tr>";
        array_walk_recursive($rowElements, function(&$element) {
            $element = $this->wrapElementToHtml("td", $element);                             
        });
        $row .= implode("", $rowElements);

        return $row . "</tr>";
    }   
    
    public function clearRows() {
        $this->rowItems = [];
    }
}

?>
