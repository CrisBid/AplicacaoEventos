<?php

namespace App;


class Router {
    protected $routes = [];

    public function addRoute($method, $path, $controller, $params) {
        $this->routes[] = [
            'method' => $method, 
            'path' => $path, 
            'controller' => $controller,

        ];
    }

    public function handleRequest() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUrl = $_GET['url'];
        
        foreach ($this->routes as $route) {
            if ($route['method'] == $requestMethod && $requestUrl == $route['path']) {
                $controller = new $route['controller']; // instancia o controlador
    
                // Verifica se é uma requisição POST e recupera os dados JSON
                if ($requestMethod === 'POST' || $requestMethod === 'PUT' ) {
                    $jsonData = file_get_contents('php://input');
                    $data = json_decode($jsonData, true); // Decodifica o JSON em um array associativo
                    
                } else {
                    $data = null; // Se não for POST, define $data como um array vazio
                }
    
                $controller->handle($route['method'], $data, $requestUrl); // chama o método padrão de todo controlador
                return;
            }
        }
    
        http_response_code(404);
        echo json_encode('Endpoint not found or does not handle that kind of request');
    }
    
}