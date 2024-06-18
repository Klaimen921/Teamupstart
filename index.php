<?php
use System\Router;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'System/autoload.php';
include 'System/Router.php';
$routes = include('data/routes.php');
$router = new Router($routes);
$router->run();