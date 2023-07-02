<?php

namespace App\Controllers;

use App\Model\Registrations;

header('Content-Type: application/json');

class RegistrationsController {
    public function handle($method, $data, $route) {
    $registrations = new Registrations();

    switch ($route) {
        case 'events/registrations':
            if ($method == 'GET') {
                $this->handleGetAllEventRegistrations($registrations);
            }
            break;
        case 'users/registrations':
            if ($method == 'GET') {
                $this->handleGetAllUserRegistrations($registrations);
            }
            break;
        case 'events/registrate':
            if ($method == 'POST') {
                $this->handleEventRegistrate($registrations, $data);
            }
            break;

        case 'events/unregister':
            if($method == 'DELETE') {
                $this->handleDeleteRegistration($registrations, $data);
            }
            break;
        case 'events/registered':
            if($method == 'POST') {
                $this->handlegetUsersByEvent($registrations, $data);
            }
            break;

        case 'events/validation':
            if($method == 'POST') {
                $this->handleEventsValidation($registrations, $data,);
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

    private function handleGetAllEventRegistrations($registrations){
        $response = $registrations->getAllEventRegistrations();
        if($response) {
            http_response_code(200);
            echo json_encode($response);
            return;
        }

        http_response_code(404);
        echo json_encode('NOT FOUND!');
    }

    private function handleGetAllUserRegistrations($registrations){
        $response = $registrations->getAllUserRegistrations();
        if($response) {
            http_response_code(200);
            echo json_encode($response);
            return;
        }

        http_response_code(404);
        echo json_encode('NOT FOUND!');
    }

    private function handleEventRegistrate($registrations, $data){
        $this->verifyData($data);
                
        $response = $registrations->Registrate($data);

        if($response === -1) {
            http_response_code(401);
            echo json_encode('FORBIDDEN! User already registed for this event');
        }

        if($response === 1) {
            http_response_code(201);
        }
        else{
            http_response_code(500);
            echo json_encode('NOT REGISTED FOR THE EVENT ERROR!');
            return;
        }
    }

    private function handleDeleteRegistration($registrations, $data) {
        $this->verifyData($data);

        $response = $registrations->deleteRegistration($data);
        if($response) {
            http_response_code(200);
        }
        else {
            http_response_code(500);
            echo json_encode('NOT DELETED');
        }        
    }

    private function handlegetUsersByEvent($registrations, $data) {
        $this->verifyData($data);
        
        $response = $registrations->getUsersByEvent($data);
        if($response) {
            http_response_code(200);
            echo json_encode($response);
        }
        else {
            http_response_code(404);
            echo json_encode('NOT FOUND');
        }        
    }

    private function handleEventsValidation($data, $registrations){
        $this->verifyData($data);
    
        $response = $registrations->isUserRegisteredForEvent($data);
        if($response) {
            http_response_code(200);
            echo json_encode($response);
        }
        else {
            http_response_code(404);
            echo json_encode('NOT REGISTERED');
            return;
        }
    }
}  

?>
