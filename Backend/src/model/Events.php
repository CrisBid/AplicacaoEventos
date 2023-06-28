<?php 

namespace App\Model;
use PDO;

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
            throw new \Exception("There no users in database!");
        }
    }

    public static function createEvent($data) {
        $dbConn = Conn::getConnection();
    
        $imageName = $_FILES['img']['name']; // Nome do arquivo enviado
        $imageTmpName = $_FILES['img']['tmp_name']; // Caminho temporário do arquivo enviado
        $imageData = file_get_contents($imageTmpName); // Lê os dados binários do arquivo
    
        $sql = 'INSERT INTO tb_events (name, description, date, time, local, category, price, img) VALUES (:nm, :desc, :date, :time, :loc, :cat, :price, :img)';
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':nm', $data['name']);
        $stmt->bindValue(':desc', $data['description']);
        $stmt->bindValue(':date', $data['date']);
        $stmt->bindValue(':time', $data['time']);
        $stmt->bindValue(':loc', $data['local']);
        $stmt->bindValue(':cat', $data['category']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':img', $imageData, PDO::PARAM_LOB); // Bind dos dados binários da imagem como LONGBLOB
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
                'img' => $imageName 
            ];
    
            return $event;
        } else {
            throw new \Exception("Failed to save event. Rollback.");
        }
    }
}

?>