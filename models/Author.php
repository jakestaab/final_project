<?php

    class Author {
        private $conn;
        private $table = 'authors';

        public $id;
        public $author;

        //constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get authors
        public function read() {
            $query = 'SELECT
                        id,
                        author
                        FROM ' . $this->table . '';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $query = 'INSERT INTO ' . $this->table . '
                        SET
                        author = :author';
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            $stmt->bindParam(':author', $this->author);

            if($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf('Error: %s.\n', $stmt->error);
            return false;
        }
    }