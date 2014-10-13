<?php
require_once 'Autoloader.php';
use Model\View, Model\SessionService;

$sessionService = new SessionService();
require_once 'templates/header.html';
require 'templates/backToList.html';

$view = new View;
$result = $view->getDetail();

require 'templates/backToList.html';
require_once 'templates/footer.html';