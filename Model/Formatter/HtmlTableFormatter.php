<?php
namespace Model\Formatter;

/**
 * Formats data as html tables
 *
 * @author anastasia
 */
class HtmlTableFormatter extends HtmlFormatter {
    protected $headerItems = [];
    protected $rowItems = [];
    protected $table;

    /**
     * 
     * @param array $headers
     */
    public function __construct($headers) {
        $this->addHeaderItems($headers);
    }
    
    /**
     * Create html table from already initialized headers and rows
     * @return string
     */
    public function createTable() {
	$table = "<table class='table table-bordered table-hover table-striped'>";
        $table .= $this->wrapElementToHtml("thead", $this->createHeader());   
        $table .= $this->wrapElementToHtml("tbody", $this->createRows());
        $table .= "</table>";
        $this->clearRows();
        return $table;
    }
    
    /**
     * 
     * @param array $elements
     */
    public function addHeaderItems($elements) {
        $this->headerItems = $elements;      
    } 
    
    /**
     * 
     * @return array
     */
    public function getHeaderItems() {
	return $this->headerItems;
    }
    
    /**
     * 
     * @param array $elements
     */
    public function addRowsItems($elements) {      
        $this->rowItems[] = $elements; 
    }
    
    /**
     * 
     * @return array
     */
    public function getRowsItems() {
	return $this->rowItems;
    }
    
    /**
     * Create table header from header items
     * @return string
     */
    private function createHeader() {
        $tableHead = function($item) {
            return $this->wrapElementToHtml("th", $item);            
        };

        return implode("", array_map($tableHead, $this->headerItems));
    }
    
    /**
     * Create table rows
     * @return string
     */
    private function createRows() {
        $tableRow = "";
         foreach ($this->rowItems as $row) {
            $tableRow .= $this->createRow($row);
        }
        return $tableRow;
    }
    
    /**
     * 
     * @param array $rowElements
     * @return string
     */
    private function createRow($rowElements) {
        $row = "<tr>";
        array_walk_recursive($rowElements, function(&$element) {
            $element = $this->wrapElementToHtml("td", $element);                             
        });
        $row .= implode("", $rowElements);

        return $row . "</tr>";
    }   
    
    /**
     * Remove all table rows items
     */
    public function clearRows() {
        $this->rowItems = [];
    }
}

?>
