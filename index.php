<?php
require_once 'Autoloader.php';
use Model\SessionService;

if ($_POST['action']) {
    $sessionService = new SessionService();
    $sessionService->saveDbParametersToSession(); 
    header("Location: /list.php");
    exit();
}
require_once 'templates/header.html';
require_once 'templates/connectToDbForm.html';
require_once 'templates/footer.html';