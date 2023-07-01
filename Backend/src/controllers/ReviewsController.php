<?php

namespace App\Controllers;

use App\Model\Reviews;

header('Content-Type: application/json');

class ReviewsController {
    public function handle($method, $data, $route) {
    $reviews = new Reviews();

    switch ($route) {
        case 'events/reviews':
            if ($method == 'GET') { //pega tudo de tudo
                $this->handleGetAllReviews($reviews);
            }
            break;
        case 'event/reviews': //event no singular pega todos os reviews de um unico evento
            if ($method == 'POST') {
                $this->handleGetEventReviews($reviews, $data);
            }
            break;
        case 'user/reviews': //user no singular pega todos os reviews de um unico usuario(exibir na tela de perfil dele)
            if ($method == 'POST') {
                $this->handleGetUserReviews($reviews, $data);
            }
            break;
        case 'reviews/create':
            if ($method == 'POST') {
                $this->handleCreateReview($reviews, $data);
            }
            break;

        case 'reviews/delete':
            if($method == 'DELETE') {
                $this->handleDeleteReview($reviews, $data);
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

    private function handleGetAllReviews($reviews) {
        $response = $reviews->getAllReviews();
        if($response) {
            http_response_code(200);
            echo json_encode($response);
            return;
        }

        http_response_code(404);
        echo json_encode('NOT FOUND!');
    }

    private function handleGetEventReviews($reviews, $data) {
        $this->verifyData($data);

        $response = $reviews->getEventReviews($data);
        
        if($response) {
            http_response_code(200);
            echo json_encode($response);
            return;
        }

        http_response_code(404);
        echo json_encode('NOT FOUND!');
    }

    private function handleGetUserReviews($reviews, $data) {
        $this->verifyData($data);

        $response = $reviews->getUserReviews($data);
        
        if($response) {
            http_response_code(200);
            echo json_encode($response);
            return;
        }

        http_response_code(404);
        echo json_encode('NOT FOUND!');
    }

    private function handleCreateReview($reviews, $data){
        $this->verifyData($data);
                
        $response = $reviews->CreateReview($data);

        if($response) {
            http_response_code(201);
        }
        else{
            http_response_code(500);
            echo json_encode('NOT REGISTED FOR THE EVENT ERROR!');
            return;
        }
    }

    private function handleDeleteReview($reviews, $data) {
        $this->verifyData($data);

        $response = $reviews->deleteReview($data);
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
}  

?>
