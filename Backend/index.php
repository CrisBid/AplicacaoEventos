<?php

require_once "vendor/autoload.php";

use App\Router;
use App\Controllers\UserController;
use App\Controllers\EventsController;


$router = new Router();

//users
$router->addRoute('GET', 'users', UserController::class); // url: /users pega todos os usuarios -- OK
$router->addRoute('POST', 'users/search', UserController::class); // url: /users/search mandar o email do user no body do request usando POST -- OK
$router->addRoute('POST', 'users/register', UserController::class); // url: /users -- OK
$router->addRoute('POST', 'users/login', UserController::class); // url: /users -- OK
$router->addRoute('DELETE', 'users/delete', UserController::class); //Mandar o email do user no body do request com verbo DELETE -- OK 
$router->addRoute('PUT', 'users/update', UserController::class); //Mandar o todos os dados, até os que não mudaram no body do request com verbo PUT -- OK 


$router->addRoute('GET', 'events', EventsController::class); // url: /events -- OK
$router->addRoute('POST', 'events/create', EventsController::class); // url: /events, mandar a url da imagem no json -- OK
$router->addRoute('DELETE', 'events/delete', EventsController::class); // url: /events, mandar o email no body do request com verbo DELETE -- OK
$router->addRoute('POST', 'events/search', EventsController::class); // url: /events/search -- mandar o name OU description OU local OU date ou category do evento no body
$router->addRoute('PUT', 'events/update', EventsController::class); // url: /events/update -- //Mandar o todos os dados, até os que não mudaram no body do request com verbo PUT -- OK 


//$router->addRoute('POST', 'events/subscription', EventsController::class); // url: /events
//$router->addRoute('POST', 'events/subscription', EventsController::class); // url: /events



$router->handleRequest();

