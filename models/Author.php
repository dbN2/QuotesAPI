<?php
    class Author {
        private $conn;
        private $table = 'authors';

        public $id;
        public $author;

        public function __construct($db){
            $this->conn = $db;
        }

    //GET
        public function read() {
            $query = 'SELECT a.id, a.author
            FROM ' .$this->table. ' a';
            
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
        }

    //GET
        public function read_single() {
            $query = 'SELECT a.id, a.author
            FROM ' .$this->table. ' a
            WHERE a.id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id',$this->id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
             
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              $this->author= $row['author'];
              return $stmt;
          
            }else {
              return null;
            }
        }
        

    //POST
        public function create() {
            $query = 'INSERT INTO ' . 
            $this->table . ' (author) 
            VALUES (:author)';


            //Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':author', $this->author);


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
                author= :author
            WHERE
                id = :id';

            //Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));


            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id',$this->id);

            
            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);
            return false;


        
    }

        public function exists($author_id) {
        $query = "SELECT id FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $author_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }


    }