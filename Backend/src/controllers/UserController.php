<?php

namespace App\Controllers;

use App\Model\Users;
use Exception;

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
    http_response_code(200);
    echo json_encode($response);
    return;
  }
}
?>
