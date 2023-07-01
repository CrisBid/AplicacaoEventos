<?php 

namespace App\Model;
use Exception;
use PDO;

class Reviews {
    private static $table = 'tb_reviews';

    public static function getAllReviews() { //pega todos os comentários do site
        $dbConn = Conn::getConnection();
    
        $sql = 'SELECT r.id, r.score, r.comment, e.name AS event_name, u.name AS user_name
                FROM tb_reviews r
                INNER JOIN tb_events e ON r.event_id = e.id
                INNER JOIN tb_users u ON r.user_id = u.id';
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public static function getUserReviews($data) { //pega todos os reviews do user passado a $data
        $dbConn = Conn::getConnection();
    
        $sql = 'SELECT r.id, r.score, r.comment, e.name AS event_name, u.name AS user_name
                FROM tb_reviews r
                INNER JOIN tb_events e ON r.event_id = e.id
                INNER JOIN tb_users u ON r.user_id = u.id
                WHERE r.user_id = :uid';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':uid', $data['userId'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public static function getEventReviews($data) { //pega todos os comentários de um
        $dbConn = Conn::getConnection();
    
        $sql = 'SELECT r.id, r.score, r.comment, e.name AS event_name, u.name AS user_name
                FROM tb_reviews r
                INNER JOIN tb_events e ON r.event_id = e.id
                INNER JOIN tb_users u ON r.user_id = u.id
                WHERE r.event_id = :eid';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':eid', $data['eventId'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "to aqui";
        } else {
            return null;
        }
    }

    public static function createReview($data) {
        $dbConn = Conn::getConnection();
    
        $sql = "INSERT INTO tb_reviews (user_id, event_id, score, comment) VALUES (:userId, :eventId, :score, :comment)";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':userId', $data['userId'], PDO::PARAM_INT);
        $stmt->bindParam(':eventId', $data['eventId'], PDO::PARAM_INT);
        $stmt->bindParam(':score', $data['score'], PDO::PARAM_INT);
        $stmt->bindParam(':comment', $data['comment'], PDO::PARAM_STR);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false; 
        }
    }
    

    public static function deleteReview($data) {
        $dbConn = Conn::getConnection();
    
        $sql = "DELETE FROM tb_reviews WHERE id = :rid";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':rid', $data['reviewId']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
            
        } else {
            return false;
        }
    }

    

    

}

?>