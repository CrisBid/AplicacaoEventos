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

    public static function getEventById($eventId) {
        $dbConn = Conn::getConnection();
    
        $queryParams = array();
        $whereClauses = array();

        if (isset($eventId)) {
            $whereClauses[] = 'id = :id';
            $queryParams[':id'] = $eventId;
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
    
    public static function eventFilter($data) {
        $dbConn = Conn::getConnection();
    
        $queryParams = array();
        $whereClauses = array();

        if (isset($data['id'])) {
            $whereClauses[] = 'id = :id';
            $queryParams[':id'] = $data['id'];
        }        
    
        if (isset($data['name'])) {
            $whereClauses[] = 'name LIKE :name';
            $queryParams[':name'] = '%' . $data['name'] . '%';
        }
    
        if (isset($data['description'])) {
            $whereClauses[] = 'description LIKE :description';
            $queryParams[':description'] = '%' . $data['description'] . '%';
        }
    
        if (isset($data['category'])) {
            $whereClauses[] = 'category LIKE :category';
            $queryParams[':category'] = '%' . $data['category'] . '%';
        }
    
        if (isset($data['local'])) {
            $whereClauses[] = 'local LIKE :local';
            $queryParams[':local'] = '%' . $data['local'] . '%';
        }
    
        if (isset($data['date'])) {
            $whereClauses[] = 'date LIKE :date';
            $queryParams[':date'] = '%' . $data['date'] . '%';
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
    
    public static function deleteEvent($eventId) {
        $dbConn = Conn::getConnection();
    
        // Exclui os registros relacionados na tabela user_event
        $sqlUserEvent = 'DELETE FROM user_event WHERE event_id = :id';
        $stmtUserEvent = $dbConn->prepare($sqlUserEvent);
        $stmtUserEvent->bindValue(':id', $eventId);
        $stmtUserEvent->execute();
    
        // Exclui o evento na tabela tb_events
        $sqlEvent = 'DELETE FROM tb_events WHERE id = :id';
        $stmtEvent = $dbConn->prepare($sqlEvent);
        $stmtEvent->bindValue(':id', $eventId);
        $stmtEvent->execute();
    
        if ($stmtEvent->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function UpdateEvent($data) {
        $dbConn = Conn::getConnection();
        $sql = 'UPDATE ' . self::$table . ' SET name = :nm, description = :d, date = :dt, time = :tm, local = :lc, category = :ct, price = :pc, img = :img WHERE id = :id';
    
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':nm', $data['name']);
        $stmt->bindValue(':d', $data['description']);
        $stmt->bindValue(':dt', $data['date']);
        $stmt->bindValue(':tm', $data['time']);
        $stmt->bindValue(':lc', $data['local']);
        $stmt->bindValue(':ct', $data['category']);
        $stmt->bindValue(':pc', $data['price']);
        $stmt->bindValue(':img', $data['img']);
        $stmt->bindValue(':id', $data['id']);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}

?>