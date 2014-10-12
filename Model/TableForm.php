<?php
namespace Model;

/**
 * Description of TableForm
 *
 * @author Anastasiia
 */
class TableForm {

    public function getFormattedForm($tableName) {
        return '<form method="POST" class="form form-inline" action="/generate.php">'
                . '<input class="form-control" type="text" size="6" name="amount" value="0" placeholder="1-100000" />'
                . '<input type="hidden" name="table" value="' . $tableName . '" />'
                . '<button class="btn btn-success" type="submit">Generate rows</button>'
                . '</form>';
    }
    
    public function getShowDetailsForm($tableName) {
        return '<form method="POST" action="/detail.php">'
        . '<input type="hidden" name="table" value="' . $tableName . '" />'
        . '<button type="submit" class="btn btn-success">Show content</button>'
        . '</form>';
    }
}
