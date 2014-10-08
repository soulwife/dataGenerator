<?php
namespace Model;

/**
 * Description of TableFormatter
 *
 * @author anastasia
 */
class TableFormatter {
    protected $headerItems = array();
    protected $rowItems = array();
    protected $table;

    public function __construct($headers) {
        $this->addHeaderItems($headers);
    }
    
    public function createTable() {
	$table = "<table>";
        $table .= $this->wrapElementToHtml("thead", $this->createHeader());   
        $table .= $this->wrapElementToHtml("tbody", $this->createRows());
        $table .= "/<table>";
           var_dump($table);
        return $table;
    }
    
    public function addHeaderItems($elements) {
        $this->headerItems = $elements;      
    } 
    
    public function getHeaderItems() {
	return implode('', $this->headerItems );
    }
    
    public function addRowsItems($elements) {
        $this->rowItems[] = $elements;      
    }
    
    public function createHeader() {
        //get rid of this in 5.4
        $self=$this;
        $tableHead = function($item) use ($self) {
            //return $self->wrapElementToHtml("th", $item);            
        };

        return implode("", array_map($tableHead, $this->headerItems));
    }
    
    public function createRows() {
        foreach ($this->rowItems as $row) {
            //var_dump($row);
            $this->createRow($row);
        }
    }
    
    public function createRow($rowElements) {
        $row = "<tr>";
        //get rid of this in 5.4
        $self=$this;
        $traverseRow = function(&$element) use ($self, &$traverseRow) {
            //foreach ($rowElements as $element) {
            //var_dump($element);
                if (is_array($element)) {
                    $element = $traverseRow($element);
                } else {
                    //var_dump($element);
                   $element = $self->wrapElementToHtml("td", $element); 
                   var_dump($element);
                }                    
            //}            
        };

        //$row .= $traverseRow($rowElements);
        //die();
//        $tableRow = function($item) use ($self) {
//            var_dump($item);
//            return $self->wrapElementToHtml("td", $item);
//        };
//        
        array_walk_recursive($rowElements, $traverseRow);
        $row .= implode("", $rowElements);
       // var_dump($rowElements);
       // var_dump($row);
        return $row . "</tr>";
    }
    
    public function wrapElementToHtml($element, $item) {
        return "<" . $element . ">" . $item . "</" . $element . ">";
    }
    
}

?>
