<?php

    require_once "vendor/autoload.php";
    header('Content-Type: application/json');

    /* 
        GET: endpoint: api/users/{id} | retorna um usuário
        GET/POST: endpoint: api/users | retorna todos
    */
    if (isset($_GET['url'])) {
        $url = explode('/', $_GET['url']);
        
        if ($url[0] === 'api') {
            array_shift($url);
            
            $controller = 'src\controller\\' . ucfirst($url[0]) . 'Controller';
            array_shift($url);

            $method = strtolower($_SERVER['REQUEST_METHOD']);

            try {

                $response = call_user_func_array(array(new $controller, $method), $url);
                http_response_code(200);
                echo json_encode(array($response));
                exit;
                
            } catch (\Exception $e) {
                http_response_code(404);
                echo json_encode($e->getMessage());
            }
        } else {
            http_response_code(404);
            echo json_encode(array('message' => 'Endpoint not found'));
        }
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'Invalid request'));
    }


   // api/users/login
    if (isset($_GET['url'])) {
        $url = explode('/', $_GET['url']);

        if ($url[0] === 'api') {
            array_shift($url);

            $controller = 'src\controller\\' . ucfirst($url[0]) . 'Controller';
            array_shift($url);

            $method = strtolower($_SERVER['REQUEST_METHOD']);

            if ($method === 'post' && $url[0] === 'login') {
                $method = 'login';
                array_shift($url);
            }

            try {
                $response = call_user_func_array(array(new $controller, $method), $url);
                http_response_code(200);
                echo json_encode($response);
                exit;
            } catch (\Exception $e) {
                http_response_code(404);
                echo json_encode($e->getMessage());
            }
        } else {
            http_response_code(404);
            echo json_encode(array('message' => 'Endpoint not found'));
        }
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'Invalid request'));
    }
    
?>
