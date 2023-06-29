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

    public function handleRequest()
{
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUrl = $_GET['url'];

    foreach ($this->routes as $route) {
        if ($route['method'] == $requestMethod && $requestUrl == $route['path']) {
            if (class_exists($route['controller'])) {
                $controller = new $route['controller']();

                $data = null;
                $imageFile = null;

                switch (true) {
                    case $this->isJsonRequest():
                        if ($requestMethod == 'POST' || $requestMethod == 'PUT' || $requestMethod == 'DELETE') {
                            $data = $this->getJsonData();
                      
                        }
                        break;

                    case $this->isMultipartRequest():
                        if ($requestMethod == 'POST' || $requestMethod == 'PUT') {
                            $data = $this->getFormData();
                            $imageFile = $this->getFileData('image');
                        }
                        break;
                }

                $controller->handle($requestMethod, $data, $requestUrl, $imageFile);
                return;
            } else {
                http_response_code(500);
                echo json_encode('Controller class not found');
                return;
            }
        }
    }

    http_response_code(404);
    echo json_encode('Endpoint not found or does not handle that kind of request');
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
    
    private function getFileData($fieldName) {
        return $_FILES[$fieldName] ?? null;
    }
}