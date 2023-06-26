<?php

require_once "vendor/autoload.php";

use App\Router;
use App\Controllers\UserController;
use App\Model\Conn;

$router = new Router();


$router->addRoute('GET', 'users', UserController::class, null); // url: /users
$router->addRoute('POST', 'users/register', UserController::class, null); // url: /users
$router->addRoute('POST', 'users/login', UserController::class, null); // url: /users



$router->handleRequest();

