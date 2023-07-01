<?php 

namespace App\Model;
use Exception;

class Events {
    private static $table = 'tb_events';

    public static function getAllevents(){
        $dbConn = Conn::getConnection();

        $sql = 'SELECT * FROM '.self::$table;
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();


        if($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
        }
        else{
            throw new Exception("There no events in database!");
        }
    }

    public static function EventFilter($data, $route) {
        $dbConn = Conn::getConnection();
    
        $queryParams = array();
        $whereClauses = array();
    
        if (isset($data['name'])) {
            $whereClauses[] = 'name = :name';
            $queryParams[':name'] = $data['name'];
        }
    
        if (isset($data['description'])) {
            $whereClauses[] = 'description = :description';
            $queryParams[':description'] = $data['description'];
        }
    
        if (isset($data['category'])) {
            $whereClauses[] = 'category = :category';
            $queryParams[':category'] = $data['category'];
        }
    
        $whereClause = '';
        if (!empty($whereClauses)) {
            $whereClause = 'WHERE ' . implode(' OR ', $whereClauses);
        }
    
        $sql = 'SELECT * FROM ' . self::$table . ' ' . $whereClause;
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($queryParams);
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false; 
        }
    }
    


    public static function createEvent($data) {
        $dbConn = Conn::getConnection();
    
        $sql = 'INSERT INTO tb_events (name, description, date, time, local, category, price, img) VALUES (:nm, :desc, :date, :time, :loc, :cat, :price, :img)';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':nm', $data['name']);
        $stmt->bindValue(':desc', $data['description']);
        $stmt->bindValue(':date', $data['date']);
        $stmt->bindValue(':time', $data['time']);
        $stmt->bindValue(':loc', $data['local']);
        $stmt->bindValue(':cat', $data['category']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':img', $data['img']);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $eventId = $dbConn->lastInsertId();
            $event = [
                'id' => $eventId,
                'name' => $data['name'],
                'description' => $data['description'],
                'date' => $data['date'],
                'time' => $data['time'],
                'local' => $data['local'],
                'category' => $data['category'],
                'price' => $data['price'],
                'img' => $data['img']
            ];
    
            return $event;
        } else {
            throw new Exception("Failed to save the event. Rollback.");
        }
    }
    
    public static function deleteEvent($data) {
        $dbConn = Conn::getConnection();

        $sql = 'DELETE FROM '.self::$table.' WHERE id = :id';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':id', $data['id']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
            
        } else {
            return false;
        }
    }

}

?>