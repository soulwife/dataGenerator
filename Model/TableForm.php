<?php
namespace Model;

/**
 * Description of TableForm
 *
 * @author Anastasiia
 */
class TableForm {

    public function getFormattedForm($tableName) {
        return '<form method="POST" action="/generate.php"><input type="text" name="amount" value="0" placeholder="1-100000" /><input type="hidden" name="table" value="' . $tableName . '" /><button type="submit">Generate rows</button></form>';
    }
    
    public function getShowDetailsForm($tableName) {
        return '<form method="POST" action="/detail.php"><input type="hidden" name="table" value="' . $tableName . '" /><button type="submit">Show content</button></form>';
    }
}
