<?php

require_once "vendor/autoload.php";

use App\Router;
use App\Controllers\UserController;
use App\Controllers\EventsController;


$router = new Router();

//users
$router->addRoute('GET', 'users', UserController::class, null); // url: /users OK
$router->addRoute('POST', 'users/register', UserController::class, null); // url: /users OK
$router->addRoute('POST', 'users/login', UserController::class, null); // url: /users OK
$router->addRoute('DELETE', 'users/delete', UserController::class, null); //Mandar o id do evento no body do request com verbo DELETE OK 


$router->addRoute('GET', 'events', EventsController::class, null); // url: /events
$router->addRoute('POST', 'events/create', EventsController::class, null); // url: /events
//$router->addRoute('GET', 'events/?={name}', EventsController::class, null); // url: /events
//$router->addRoute('POST', 'events/subscription', EventsController::class, null); // url: /events
//$router->addRoute('POST', 'events/subscription', EventsController::class, null); // url: /events



$router->handleRequest();

