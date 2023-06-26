<?php

namespace App\Controllers;

use App\Model\Users;
use Exception;

header('Content-Type: application/json');

class UserController {

  public function handle($method, $data, $route) {
    $user = new Users();

    // Get all users route
    if ($method == 'GET' && $route == 'users') {
      $this->handleGetAllUsers($user);
    }
      
    // Register route
    if ($method == 'POST' && $route == 'users/register') {
        $this->handleRegisterUser($user, $data);
    }
      
    // Login route
    if ($method == 'POST' && $route == 'users/login') {
      $this->handleUserLogin($user, $data);
    }
  
    http_response_code(404);
    echo json_encode('Enpoint not found!');
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
