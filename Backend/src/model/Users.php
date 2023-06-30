<?php

namespace App\Model;

class Users {
    private static $table = 'tb_users';
    
    public static function getUserById($id){

        $dbConn = Conn::getConnection();
        $sql = 'SELECT * FROM '.self::$table.' WHERE id = :id';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        else{
            throw new \Exception("User not found in database!");
        }
    }

    public static function getAllUsers(){
        $dbConn = Conn::getConnection();

        $sql = 'SELECT * FROM '.self::$table;
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
        }
        else{
            throw new \Exception("There no users in database!");
        }
    }

    public static function insertUser($data) {
        $dbConn = Conn::getConnection();

        $sql = 'INSERT INTO ' . self::$table . ' (name, email, password, role) VALUES (:nm, :em, :ps, :rl)';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':nm', $data['name']);
        $stmt->bindValue(':em', $data['email']);

        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bindValue(':ps', $hash);
        $stmt->bindValue(':rl', $data['role']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $userId = $dbConn->lastInsertId();
            $user = [
                'id' => $userId,
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role']
            ];

            return $user;

        } else {
            throw new \Exception("FAILED! NOT SAVED, ROLLBACK");
        }
    }
    
    public static function verify($data){
        $dbConn = Conn::getConnection();

        $sql = 'SELECT * FROM '.self::$table.' WHERE email = :em';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':em', $data['email']);
        $stmt->execute();
        
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user && password_verify($data['password'], $user['password'])) {
            $userDTO = [
                'username' => $user['name'],
                'email' => $user['email'],
                'role' => $data['role']
            ];
            
            return $userDTO;

        } else {
            $user = null; //nenhum user encontrado com as credencias passadas
        }
    }

    public static function deleteUser($data) {
        $dbConn = Conn::getConnection();

        $sql = 'DELETE FROM '.self::$table.' WHERE email = :em';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':em', $data['email']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
            
        } else {
            return false;
        }
    }

    public static function UpdateUser($data) {
        $dbConn = Conn::getConnection();
    
        $sql = 'UPDATE ' . self::$table . ' SET name = :name, email = :email, password = :password, role = :role WHERE email = :email';
    
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
    
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bindValue(':password', $hash);
    
        $stmt->bindValue(':role', $data['role']);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>