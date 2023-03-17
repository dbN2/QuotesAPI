<?php
    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;

        public function __construct($db){
            $this->conn = $db;
        }
    //GET
        public function read() {
            $query = 'SELECT  c.id, c.category
            FROM ' .$this->table. ' c';
            
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
        }
    //GET
        public function read_single() {
            $query = 'SELECT  c.id, c.category AS category
            FROM ' .$this->table. ' c
            WHERE c.id = :id';
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id',$this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->category = $row['category'];
        }
    //POST
        public function create() {
            $query = 'INSERT INTO ' . 
            $this->table . ' (category) 
            VALUES (:category)';


            //Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':category', $this->category);


            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);
            return false;


        }
    //DELETE
        public function delete() {
            $query = 'DELETE FROM '.$this->table .' WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

    //PUT
        public function update() {
            
            $query = 'UPDATE ' . 
            $this->table . ' 
            SET
                category= :category
            WHERE
                id = :id';

            //Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id',$this->id);

            
            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);
            return false;
        
    }

    }