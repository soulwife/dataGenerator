<?php
session_start();
require_once 'Autoloader.php';
use Model\KeyReference, Model\TableRepository, Model\SessionService;
require_once 'templates/header.html';
try {
    //$db = new Database("127.0.0.1", "splendit", "root", "");
    $repository = new TableRepository;
    $keyReference = new KeyReference;
    $sessionService = new SessionService();
    if ($sessionService->checkSession()) {
        $tables = $repository->getTables();
        $repository->displayTablesWithColumns($tables, $keyReference);
    }
} catch (Exception $e) {
   echo $e->getMessage(); 
}
require_once 'templates/footer.html';