<?php

namespace App\Controllers;

use App\Model\Events;

header('Content-Type: application/json');

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
                $this->handleUpdateEvent($events, $data);
            }
            break;

        case 'events/delete':
            if($method == 'DELETE') {
                $this->handleDeleteEvent($events, $data);
            }
            break;
        case 'events/search':
            if($method == 'POST') {
                $this->handleSearchEvent($data, $events);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode('Endpoint not found! or not handle that kind of http request');
            break;
    }
  }

  private function verifyData($data){
    if (!$data) {
        http_response_code(400);
        echo json_encode('INVALID PARAMETERS!');
        return;
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
    $this->verifyData($data);

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
    $this->verifyData($data);
    
    $response = $events->deleteEvent($data);
    if($response) {
 
        http_response_code(200);
    }
    else {
        http_response_code(500);
        return;
    }
  }

  private function handleSearchEvent($data, $events){
    $this->verifyData($data);

    $response = $events->eventFilter($data);
    if($response) {
        http_response_code(200);
        echo json_encode($response);
    }
    else {
        http_response_code(404);
        echo json_encode('NOT FOUND');
        return;
    }
  }

  private function handleUpdateEvent($events, $data) {
    $this->verifyData($data);

    $response = $events->UpdateEvent($data);
    if($response) {
        http_response_code(200);
    }
    return;
  }

}
  

?>
