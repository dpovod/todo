<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'View.php';
require_once 'Controller.php';
require_once 'Route.php';
require_once 'start.php';
$route = new Route();
$route->start();
