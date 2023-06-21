<?php

    namespace src\controller;
    use src\model\Users;

    class UsersController {
        
        public function get($id = null){
            if($id){
                return Users::getUserById($id);
            }
            
            return Users::getAllUsers();
        }

        public function post()
        {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
        
            return Users::insertUser($data);
        }
        

        public function update(){
            
        }

        public function delete(){
            
        }

        public function login(){
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            return Users::verify($data);
        }

    }
