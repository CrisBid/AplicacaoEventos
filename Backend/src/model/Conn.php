<?php

namespace App\Model;

class Conn {
    
    private static $conn = null;
    private static $DBDRIVE = 'mysql';
    private static $DBHOST = 'localhost';
    private static $DBNAME = 'db_rio_eventos';
    private static $DBUSER = 'root';
    private static $DBPASS = '';

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                self::$conn = new \PDO(
                    self::$DBDRIVE . ':host=' . self::$DBHOST . ';dbname=' . self::$DBNAME,
                    self::$DBUSER,
                    self::$DBPASS
                );
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                echo "Erro na conexão com o banco de dados: " . $e->getMessage();
            }
        }
        return self::$conn;
    }
}
?>
