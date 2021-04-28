<?php

    class Database {
        
        /*
        private $host = 'localhost';
        private $db_name = 'quotesdb';
        private $username = 'root';
        private $password = 'sesame';
        private $conn;
        private static $dsn = 'mysql:host=localhost;dbname=quotesdb';
        private static $username1 = 'root';
        private static $password1 = 'sesame';
        private static $db;
        */
        
        
        private $host = 'g84t6zfpijzwx08q.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
        private $db_name = 'pofqsjx4clotr29u';
        private $username = 'rdycj9qyn2kew2op';
        private $password = 'syo1y3gsrn3jlcm9';
        private $conn;
        private static $dsn = 'mysql:host=g84t6zfpijzwx08q.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=pofqsjx4clotr29u';
        private static $username1 = 'rdycj9qyn2kew2op';
        private static $password1 = 'syo1y3gsrn3jlcm9';
        private static $db;
        


        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->conn;
        }

        public static function getDB() {
            if (!isset(self::$db)) {
                try {
                    self::$db = new PDO(self::$dsn,
                                        self::$username1,
                                        self::$password1);
                } catch (PDOException $e) {
                    $error_message .= $e->getMessage();
                    exit();
                }
            }
            return self::$db;
        }
    }