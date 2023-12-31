<?php

namespace App;

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Access-Control-Allow-Origin");
header("Access-Control-Allow-Credentials: true");

use App\Controllers\UserController;
use Firebase\JWT\JWT;
use Exception;

class Router {
    protected $routes = [];
    private $jwtSecretKey = '435klfdlfjldf394lkjflskjdl'; //chave secreta randomica para assinar o token

    public function addRoute($method, $path, $controller) {
        $this->routes[] = [
            'method' => $method, 
            'path' => $path, 
            'controller' => $controller,
        ];
    }

    public function handleRequest() {
        
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
          
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']}");
            }
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
          
            exit(0);
        }

        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUrl = $_GET['url'];
        //$token = $this->extractBearerToken();
        //var_dump($token);
        //$this->Auth($token);

        foreach ($this->routes as $route) {

            if ($route['method'] == $requestMethod) {
                $pattern = $this->getPatternWithParameters($route['path']);
                if (preg_match($pattern, $requestUrl, $matches)) {
                    if (class_exists($route['controller'])) {
                        $controller = new $route['controller']();

                        $data = null;

                        switch (true) {
                            case $this->isJsonRequest():
                                if ($requestMethod == 'POST' || $requestMethod == 'PUT' || $requestMethod == 'DELETE') {
                                    $data = $this->getJsonData();
                                }
                                break;

                            case $this->isMultipartRequest():
                                if ($requestMethod == 'POST' || $requestMethod == 'PUT') {
                                    $data = $this->getFormData();
                                }
                                break;
                        }

                        $urlParameters = $this->getUrlParameters($route['path'], $requestUrl);
                        if ($urlParameters && $data !== null) {
                            $data = array_merge($data, $urlParameters);
                        } elseif ($urlParameters) {
                            $data = $urlParameters;
                        }
                
                        $controller->handle($requestMethod, $data, $requestUrl);
                        return;
                    } else {
                        http_response_code(500);
                        echo json_encode('Controller class not found');
                        return;
                    }
                }
            }
        }

        http_response_code(404);
        echo json_encode('Endpoint not found or does not handle that kind of request');
    }

    private function getPatternWithParameters($path) {
        $pattern = str_replace('/', '\/', $path);
        $pattern = preg_replace('/{(\w+)}/', '(\w+|\d+)', $pattern); 
        return '/^' . $pattern . '$/';
    }

    private function getUrlParameters($routePath, $requestUrl) {
        $routeParts = explode('/', $routePath);
        $requestParts = explode('/', $requestUrl);

        $urlParameters = [];

        foreach ($routeParts as $index => $routePart) {
            if (preg_match('/^{(\w+)}$/', $routePart, $matches)) {
                $parameterName = $matches[1];
                $parameterValue = isset($requestParts[$index]) ? $requestParts[$index] : null;
                $urlParameters[$parameterName] = $parameterValue;
            }
        }

        return $urlParameters;
    }

    private function extractBearerToken() {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        
        if (preg_match('/Bearer\s+(.*)$/i', $authorizationHeader, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    private function decodeToken($token) {
        try {
            $decodedToken = JWT::decode($token, $this->jwtSecretKey);
            return $decodedToken;
        } catch (Exception $e) {
            return null; 
        }
    }
    
    private function isJsonRequest() {
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
        return strpos($contentType, 'application/json') !== false;
    }
    
    private function getJsonData() {
        $jsonData = file_get_contents('php://input');
        return json_decode($jsonData, true);
    }
    
    private function isMultipartRequest() {
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
        return strpos($contentType, 'multipart/form-data') !== false;
    }

    private function getFormData() {
        return $_POST; 
    }

    public function Auth($token) {

        $decodedToken = $this->decodeToken($token);

        if ($decodedToken !== null) {
            switch ($decodedToken->role) {
                case 'org':
                    // Acesso para a role 'org'
                    // Defina as rotas permitidas para a role 'org'
                    break;
                case 'part':
                    // Acesso para a role 'part'
                    // Defina as rotas permitidas para a role 'part'
                    break;
                case 'admin':
                    // Acesso para a role 'admin'
                    // Defina as rotas permitidas para a role 'admin'
                    break;
                default:
                    // Acesso negado para outras roles não especificadas
                    http_response_code(403);
                    echo json_encode('Access denied');
                    return;
            }
        } else {
            // Acesso negado quando o token não é válido ou a chave de acesso está incorreta
            http_response_code(401);
            echo json_encode('Invalid token or access key');
            return;
        }

        // O token é válido e a chave de acesso está correta
        // Prossiga para lidar com a solicitação normalmente
        $this->handleRequest();
    }
}
