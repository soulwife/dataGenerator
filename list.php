<?php
require_once 'Autoloader.php';
use Model\KeyReference, Model\Repository\TableRepository, Model\SessionService, Model\View;

$sessionService = new SessionService();
require_once 'templates/header.html';
try {
    $repository = new TableRepository;
    $keyReference = new KeyReference;
    $view = new View;
    if ($sessionService->checkSession()) {
        $tables = $repository->getTables();
        $view->displayTablesWithColumns($tables, $keyReference);
    }
} catch (Exception $e) {
   echo $e->getMessage(); 
}
require_once 'templates/footer.html';