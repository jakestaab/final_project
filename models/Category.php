<?php

    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;

        //constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get categories
        public function read() {
            $query = 'SELECT
                        id,
                        category
                        FROM ' . $this->table . '';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $query = 'INSERT INTO ' . $this->table . '
                        SET
                        category = :category';
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            $stmt->bindParam(':category', $this->category);

            if($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf('Error: %s.\n', $stmt->error);
            return false;
        }

        public function update() {
            $query = 'UPDATE ' . $this->table . '
                        SET
                        category = :category
                        WHERE
                        id = :id';
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':category', $this->category);
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