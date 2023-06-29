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

    public static function createEvent($data) {
        $dbConn = Conn::getConnection();
    
        $uploadedFilePath = 'uploads/event/';
        $imageFilePath = null; // Initialize with a default value
    
        // Check if the image file exists in the data
        if (isset($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
            $imageFile = $data['image'];
            $imageFileName = $imageFile['name'];
            $imageFilePath = $uploadedFilePath . $imageFileName;
    
            if (!move_uploaded_file($imageFile['tmp_name'], $imageFilePath)) {
                throw new Exception("Failed to move the uploaded file.");
            }
        } else {
            // throw new Exception("No valid image file provided.");
            echo "deu ruim";
        }
    
        // Rest of the code remains the same
        $sql = 'INSERT INTO tb_events (name, description, date, time, local, category, price, img) VALUES (:nm, :desc, :date, :time, :loc, :cat, :price, :img)';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':nm', $data['name']);
        $stmt->bindValue(':desc', $data['description']);
        $stmt->bindValue(':date', $data['date']);
        $stmt->bindValue(':time', $data['time']);
        $stmt->bindValue(':loc', $data['local']);
        $stmt->bindValue(':cat', $data['category']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':img', $imageFilePath);
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
                'img' => $imageFilePath
            ];
    
            return $event;
        } else {
            throw new Exception("Failed to save the event. Rollback.");
        }
    }
    
    
    

}

?>