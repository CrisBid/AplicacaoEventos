<?php

namespace App\Controllers;

use App\Model\Events;

//header('Content-Type: application/json');

class EventsController {
  public function handle($method, $data, $route) {
    $events = new Events();

    switch ($route) {
        case 'events':
            if ($method == 'GET') {
                $this->handleGetAllEvents($events);
            }
            break;
        case 'events/create':
            if ($method == 'POST') {
                $this->handleCreateEvent($events, $data);
            }
            break;
        case 'events/update':
            if ($method == 'PUT') {
                //$this->handleUpdateEvent($user, $data);
            }
            break;

        case 'events/delete':
            if($method == 'DELETE') {
                $this->handleDeleteEvent($events, $data);
            }
            break;
        case 'events/search/category':
            if($method == 'POST') {
                $this->handleSearchEvent($events, $data);
            }
            break;
        case 'events/search/name':
            if($method == 'DELETE') {
                $this->handleSearchEvent($events, $data);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode('Endpoint not found! or not handle that kind of http request');
            break;
    }
  }

  private function handleGetAllEvents($events) {

    $response = $events->getAllevents();
    if($response) {
        http_response_code(200);
        echo json_encode($response);
    }
    else {
        http_response_code(404);
        echo json_encode('Not Found!');
        return;
    }
  }

  private function handleCreateEvent($events, $data) {
    if (!$data) {
        http_response_code(400);
        echo json_encode('INVALID PARAMETERS!');
        return;
    }

    $response = $events->createEvent($data);
    if($response) {
        http_response_code(201);
        echo json_encode($response);
    }
    else{
        http_response_code(500);
        echo json_encode('Event Not created, error');
        return;
    }
  }

  private function handleDeleteEvent($events, $data) {
    if (!$data) {
        http_response_code(400);
        echo json_encode('INVALID PARAMETERS!');
        return;
    }
    
    $response = $events->deleteEvent($data);
    if($response) {
 
        http_response_code(200);
    }
    else {
        http_response_code(500);
        return;
    }
  }

  private function handleSearchEvent(){
    //fazer ainda pae
  }
  
}

?>
