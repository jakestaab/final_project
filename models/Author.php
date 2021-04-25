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

        //update author
        public function update() {
            $query = 'UPDATE ' . $this->table . '
                        SET
                        author = :author
                        WHERE
                        id = :id';
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf('Error: %s.\n', $stmt->error);
            return false;
        }

        public function delete() {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }