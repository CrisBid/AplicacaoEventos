<?php

require_once "vendor/autoload.php";

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept");
header("Access-Control-Allow-Credentials: true");

use App\Router;
use App\Controllers\UserController;
use App\Controllers\EventsController;
use App\Controllers\RegistrationsController;
use App\Controllers\ReviewsController;


$router = new Router();

//admin (Deleta, cria, atualiza eventos, , pode procurar um usuario, ver uma lista de todos eles, pode procurar um evento, ver todos os eventos, ver quantos quais pessoas estão em um evento etc)
$router->addRoute('GET', 'users', UserController::class); // url: /users pega todos os usuarios -- OK
$router->addRoute('GET', 'events', EventsController::class); // pega todos os eventos e lista
$router->addRoute('GET', 'events/registrations', RegistrationsController::class); // retorna  todos os eventos com id e nome e o numero de inscrições
$router->addRoute('GET', 'users/registrations', RegistrationsController::class); // retorna  todos os usuarios com id e nome e o numero de eventos que se inscreveram
$router->addRoute('POST', 'events/registered', RegistrationsController::class); //Retorna os usuários inscritos em um evento específico. especificar o eventId no body ao dar POST, retorna json com os usuários que estão inscritos no do id passado
$router->addRoute('POST', 'users/search', UserController::class); // url: /users/search mandar o email do user no body do request usando POST -- OK
$router->addRoute('GET', 'events/reviews', ReviewsController::class); // retorna todos os reviews -- ok
$router->addRoute('POST', 'event/reviews', ReviewsController::class);// mandar o id do evento [userId] no body do request     
$router->addRoute('POST', 'user/reviews', ReviewsController::class); // mandar o id do evento [eventId] no body do request    


//users (Participante pode cadastrar, logar, deletar sua conta, editar sua info)
$router->addRoute('POST', 'users/register', UserController::class); // url: /users -- OK
$router->addRoute('POST', 'users/login', UserController::class); // url: /users -- OK
$router->addRoute('DELETE', 'users/delete/{id}', UserController::class); //Mandar o email do user no body do request com verbo DELETE -- OK 
$router->addRoute('PUT', 'users/update', UserController::class); //Mandar o todos os dados, até os que não mudaram no body do request com verbo PUT -- OK 


//events (Organizador pode criar, deletar, editar. Participante pode procurar por um evento)
$router->addRoute('GET', 'events', EventsController::class); // url: /events -- OK
$router->addRoute('POST', 'events/create', EventsController::class); // url: /events, mandar a url da imagem no json -- OK
$router->addRoute('DELETE', 'events/delete/{id}', EventsController::class); // url: /events, mandar o email no body do request com verbo DELETE -- OK
$router->addRoute('POST', 'events/search', EventsController::class); // url: /events/search -- mandar o name OU description OU local OU date ou category do evento no body
$router->addRoute('PUT', 'events/update', EventsController::class); // url: /events/update -- //Mandar o todos os dados, até os que não mudaram no body do request com verbo PUT -- OK 
$router->addRoute('POST', 'events/validation', EventsController::class); // url: /events/validation -- /mandar o id do user e o do event;
$router->addRoute('GET', 'events/details/{id}', EventsController::class); //Mandar o todos os dados, até os que não mudaram no body do request com verbo PUT -- OK 


//subscriptions (Organizador e participante podem inscrever e desinscrever de um evento)
$router->addRoute('POST', 'events/registrate', RegistrationsController::class); // passar o userId(escrito desse jeito)) e o eventId(desse jeito) para inscrever em um evento
$router->addRoute('POST', 'events/unregister', RegistrationsController::class); // passar o userId(escrito desse jeito)) e o eventId(desse jeito) para inscrever em um evento
$router->addRoute('GET', 'events/registrations/user/{id}', RegistrationsController::class); //Mandar o todos os dados, até os que não mudaram no body do request com verbo PUT -- OK 


//reviews
$router->addRoute('POST', 'reviews/create', ReviewsController::class); // mandar todos os dados por json num post e retorna 200OK
$router->addRoute('DELETE', 'reviews/delete/{id}', ReviewsController::class); // mandar o (escrito desse jeito: reviewId no json) do review no body e retorna 200OK






$router->handleRequest();

