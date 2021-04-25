<?php
    class Quotes {
        private $conn;
        private $table = 'quotes';

        //post properties
        public $id;
        public $quote;
        public $authorId;
        public $categoryId;
        public $author_name;
        public $category_name;

        //constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        //get posts
        public function read() {
            $query = 'SELECT c.category as category_name, a.author as author_name,
            q.id,
            q.categoryId,
            q.quote,
            q.authorId
            FROM quotes q
            LEFT JOIN
            categories c on q.categoryId = c.id
            LEFT JOIN
            authors a on q.authorId = a.id';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        //get single post
        public function read_single() {

            $query = 'SELECT c.category as category_name, a.author as author_name,
            q.id,
            q.categoryId,
            q.quote,
            q.authorId
            FROM quotes q
            LEFT JOIN
            categories c on q.categoryId = c.id
            LEFT JOIN
            authors a on q.authorId = a.id
            WHERE q.id = ?';

            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->author_name = $row['author_name'];
            $this->quote = $row['quote'];
            $this->category_name = $row['category_name'];
        }

        //create post
        public function create() {
            $query = 'INSERT INTO ' . $this->table . '
                        SET
                        categoryId = :categoryId,
                        quote = :quote,
                        authorId = :authorId';
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));

            $stmt->bindParam(':categoryId', $this->categoryId);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);

            if($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf('Error: %s.\n', $stmt->error);
            return false;
        }

        //update post
        public function update() {
            $query = 'UPDATE ' . $this->table . '
                        SET
                        categoryId = :categoryId,
                        quote = :quote,
                        authorId = :authorId
                        WHERE
                        id = :id';
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':categoryId', $this->categoryId);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf('Error: %s.\n', $stmt->error);
            return false;
        }

        //delete post
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