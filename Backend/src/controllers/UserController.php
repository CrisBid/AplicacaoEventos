<?php


namespace App\Controllers;
use App\Model\Users;
use Exception;

header('Content-Type: application/json');

class UserController {

    public function handle($method, $data, $route) {
      $user = new Users();

      if($method == 'GET' && $route == 'users') {
        $response = $user->getAllUsers();
        http_response_code(200);
        echo json_encode($response);  
      }
      else {
        http_response_code(404);
        echo json_encode('NOT FOUND!');
      } 
      
      
      if($method == 'POST' && $route == 'users/register') {
        
        if(!$data) {
          http_response_code(400);
          echo json_encode('INVALID PARAMETERS!');
        }

        $response = $user->insertUser($data);
        http_response_code(201);
        echo json_encode($response);
      }

      if($method == 'POST' && $route == 'users/login') {
        
        if(!$data) {
          http_response_code(400);
          echo json_encode('INVALID PARAMETERS!');
        }

        $response = $user->verify($data);
        echo json_encode($response);
      }
      
    }
}

?>