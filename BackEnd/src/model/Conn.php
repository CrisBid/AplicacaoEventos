<?php

    namespace src\model;

    class Conn {
        
        private static $conn = null;

        public static function getConnection() {
            if (self::$conn === null) {
                try {
                    self::$conn = new \PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS);
                    self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                } catch (\PDOException $e) {
                    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
                }
            }
            return self::$conn;
        }
    }
?>
