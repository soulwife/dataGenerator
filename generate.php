<?php
require_once 'Autoloader.php';
use Model\View, Model\SessionService;

$sessionService = new SessionService();
require_once 'templates/header.html';
try {    
    $view = new View;
    $result = $view->generate();
    echo $result 
            ? "Congratulations! All rows have been generated and inserted succesfully!" 
            : "Unfortunately, the records have not been generated. Please correct all issues from message above. "
            . "If you don't see any other messages above, please check the amount of rows, maybe it's 0?";
}
catch (Exception $e) {
   echo $e; 
}
require_once 'templates/backToList.html';
require_once 'templates/footer.html';