<?php

namespace App\Controllers;

use App\Model\Users;
use Firebase\JWT\JWT;

header('Content-Type: application/json');

class UserController {
  public function handle($method, $data, $route) {
    $user = new Users();

    switch ($route) {
        case 'users':
            if ($method == 'GET') {
                $this->handleGetAllUsers($user);
            }
            break;
        case 'users/register':
            if ($method == 'POST') {
                $this->handleRegisterUser($user, $data);
            }
            break;
        case 'users/login':
            if ($method == 'POST') {
                $this->handleUserLogin($user, $data);
            }
            break;
         case 'users/delete':
         if ($method == 'DELETE') {
             $this->handleDeleteUser($user, $data);
           }
           break;
        default:
            http_response_code(404);
            echo json_encode('Endpoint not found! or not handle that kind of http request');
            break;
    }
  }

  private function handleGetAllUsers($user) {
    $response = $user->getAllUsers();
    http_response_code(200);
    echo json_encode($response);
    return;
  }

  private function handleRegisterUser($user, $data) {
    if (!$data) {
        http_response_code(400);
        echo json_encode('INVALID PARAMETERS!');
        return;
    }

    $response = $user->insertUser($data);
    http_response_code(201);
    echo json_encode($response);
    return;
  }
  
  private function handleUserLogin($user, $data) {
    if (!$data) {
        http_response_code(400);
        echo json_encode('INVALID PARAMETERS!');
        return;
    }

    $response = $user->verify($data);

    if ($response === null) {
        http_response_code(401);
        echo json_encode('Invalid credentials');
        return;
    }

    // Gerar o token JWT
    $tokenPayload = [
        'role' => $response['role']
    ];

    $jwtSecretKey =  random_bytes(32); //chave secreta randomica para assinar o token
    $jwtAlgorithm = 'HS256'; // Algoritmo de assinatura do JWT

    $token = JWT::encode($tokenPayload, $jwtSecretKey, $jwtAlgorithm);

    // Retornar o usuário e o token JWT
    $responseData = [
        'userId' => $response['id'],
        'user' => $response['username'],
        'email' => $response['email'],
        'Authtoken' => $token
    ];

    http_response_code(200);
    echo json_encode($responseData);
    return;
  }

  private function handleDeleteUser($user, $data) {
    if (!$data) {
        http_response_code(400);
        echo json_encode('INVALID PARAMETERS!');
        return;
    }

    $response = $user->deleteUser($data);
    if($response) {
        http_response_code(200);
        echo 'deu bao';
    }

    return;
  }
}

?>
