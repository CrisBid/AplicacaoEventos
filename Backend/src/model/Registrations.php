<?php 

namespace App\Model;
use Exception;
use PDO;

class Registrations {
    private static $table = 'user_event';

    public static function getAllEventRegistrations() {
        $dbConn = Conn::getConnection();
    
        $sql = 'SELECT e.id, e.name, COUNT(ue.user_id) AS registrations_count
                FROM tb_events e
                LEFT JOIN user_event ue ON e.id = ue.event_id
                GROUP BY e.id, e.name';
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public static function getAllUserRegistrations() {
        $dbConn = Conn::getConnection();
    
        $sql = 'SELECT u.id, u.name, COUNT(ue.event_id) AS events_count
                FROM tb_users u
                LEFT JOIN user_event ue ON u.id = ue.user_id
                GROUP BY u.id, u.name';
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
           return null;
        }
    }

    public static function isUserRegisteredForEvent($data) {
        $dbConn = Conn::getConnection();
    
        $sql = 'SELECT COUNT(*) FROM tb_users u
                INNER JOIN user_event ue ON u.id = ue.user_id
                WHERE ue.event_id = :eid
                AND u.id = :userId';
    
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':eid', $data['eventId'], PDO::PARAM_INT);
        $stmt->bindParam(':userId', $data['userId'], PDO::PARAM_INT);
        $stmt->execute();
    
        $rowCount = $stmt->fetchColumn();

        if($rowCount > 0) {
          return true;  
        }
        else {
            return false;
        }
    }
    

    public static function registrate($data){
        $dbConn = Conn::getConnection();

        $sql = "SELECT * FROM user_event WHERE user_id = :userId AND event_id = :eventId";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':userId', $data['userId'], PDO::PARAM_INT);
        $stmt->bindParam(':eventId', $data['eventId'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return -1;
        }

        $sql = "INSERT INTO user_event (user_id, event_id) VALUES (:userId, :eventId)";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':userId', $data['userId'], PDO::PARAM_INT);
        $stmt->bindParam(':eventId', $data['eventId'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 1;
        } else {
           
            return false;
        }
    }

    public static function deleteRegistration($data) {
        $dbConn = Conn::getConnection();
    
        $sql = 'DELETE FROM ' . self::$table . ' WHERE user_id = :uid AND event_id = :eid';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':uid', $data['userId']);
        $stmt->bindValue(':eid', $data['eventId']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
            
        } else {
            return false;
        }
    }

    

}

?>