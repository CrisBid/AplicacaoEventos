<?php

namespace App\Controllers;

use App\Model\Users;
use Firebase\JWT\JWT;
use Exception;

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

class UserController {

  private  $jwtSecretKey = '435klfdlfjldf394lkjflskjdl'; //chave secreta randomica para assinar o token
  private $jwtAlgorithm = 'HS256'; //algoritimo de assinatura

  public function handle($method, $data, $route) {
    $user = new Users();

    switch ($route) {
        case 'users':
            if ($method == 'GET') {
                $this->handleGetAllUsers($user);
            }
            break;
        case 'users/search':
            if ($method == 'POST') {
                $this->handleGetUser($user, $data);
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

        case 'users/update':
        if ($method == 'PUT') {
            $this->handleUpdateUser($user, $data);

            }
            break;
        default:
            http_response_code(404);
            echo json_encode('Endpoint not found! or not handle that kind of http request');
            break;
    }
  }

  private function decodeToken($token) {
    try {
        $decodedToken = JWT::decode($token, $this->jwtSecretKey);
        return $decodedToken;
    } catch (Exception $e) {
        return null; 
    }
}

    public function getDecodedToken($token) {
        return $this->decodeToken($token);
    }


  private function encodeToken($payload) {    
      $token = JWT::encode($payload, $this->jwtSecretKey, $this->jwtAlgorithm);
      return $token;
  }

  private function verifyData($data){
    if (!$data) {
        http_response_code(400);
        echo json_encode('INVALID PARAMETERS!');
        return;
    }
  }

  private function handleGetAllUsers($user) {
    $response = $user->getAllUsers();
    http_response_code(200);
    echo json_encode($response);
    return;
  }

  private function handleGetUser($user, $data) {
    $this->verifyData($data);
    
    $response = $user->getUserByEmail($data);
    http_response_code(200);
    echo json_encode($response);
    return;
  }

  private function handleRegisterUser($user, $data) {
    $this->verifyData($data);

    $response = $user->insertUser($data);
    http_response_code(201);
    echo json_encode($response);
    return;
  }
  
 
private function handleUserLogin($user, $data) {
    $this->verifyData($data);

    $response = $user->verify($data);

    if ($response === null) {
        http_response_code(401);
        echo json_encode('Invalid credentials');
        return;
    }

    // Gerar o token JWT
    $tokenPayload = [
        'role' => $response['role'],
    ];

    $token = $this->encodeToken($tokenPayload);

    // Retornar o usuário e o token JWT
    $responseData = [
        'id' => $response['id'],
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
    }
    return;
  }

  private function handleUpdateUser($user, $data) {
    
    $this->verifyData($data);

    $response = $user->UpdateUser($data);
    if($response) {
        http_response_code(200);
    }
    return;
  }

}

?>
