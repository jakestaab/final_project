<?php

    class Author {
        private $conn;
        private $table = 'authors';

        public $id;
        public $author;
        public $authorId;

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

        //read single author
        public function read_single($id) {

            $query = 'SELECT a.author as author_name,
            a.id,
            q.authorId
            FROM quotes q
            LEFT JOIN
            authors a on q.authorId = a.id
            WHERE q.authorId = :id
            LIMIT 1';

            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->author_name = $row['author_name'];
        }

        public function get_authors() {
            $query = 'SELECT * FROM authors
                        ORDER BY id';
    
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }