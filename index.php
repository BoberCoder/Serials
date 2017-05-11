<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include 'vendor/autoload.php';

use Serials\Components\Router;

$credentials = include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
$connection = new \Serials\Components\DBConnection($credentials['username'], $credentials['password']);

$router = new Router($connection->getConnection());
$router->run();