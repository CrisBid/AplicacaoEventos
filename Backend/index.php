<?php

require_once "vendor/autoload.php";

use App\Router;
use App\Controllers\UserController;
use App\Controllers\EventsController;


$router = new Router();

//users
$router->addRoute('GET', 'users', UserController::class); // url: /users -- OK
$router->addRoute('POST', 'users/register', UserController::class); // url: /users -- OK
$router->addRoute('POST', 'users/login', UserController::class); // url: /users -- OK
$router->addRoute('DELETE', 'users/delete', UserController::class); //Mandar o email do user no body do request com verbo DELETE -- OK 
$router->addRoute('PUT', 'users/update', UserController::class); //Mandar o todos os dados, até os que não mudaram no body do request com verbo PUT -- OK 


$router->addRoute('GET', 'events', EventsController::class); // url: /events -- OK
$router->addRoute('POST', 'events/create', EventsController::class); // url: /events, mandar a url da imagem no json -- OK
$router->addRoute('DELETE', 'events/delete', EventsController::class); // url: /events, mandar o email no body do request com verbo DELETE -- OK
$router->addRoute('POST', 'events/events', EventsController::class); // url: /events -- mandar o id do evento no body
//$router->addRoute('POST', 'events/subscription', EventsController::class); // url: /events
//$router->addRoute('POST', 'events/subscription', EventsController::class); // url: /events



$router->handleRequest();

