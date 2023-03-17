<?php
    class Quote {
        private $conn;
        private $table = 'quotes';

        public $id;
        public $quote;
        public $author_id;
        public $category_id;


        public function __construct($db){
            $this->conn = $db;
        }
    //GET
        public function read() {
            $query = 'SELECT q.id, q.quote, q.author_id AS author_id, q.category_id AS category_id
            FROM ' .$this->table.' q
            JOIN authors a ON q.author_id = a.id
            JOIN categories c ON q.category_id = c.id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
        }

    //get all quotes by an author
        public function read_author(){
            $query = 'SELECT
            q.id, 
            q.quote,
            q.author_id AS author_id,
            q.category_id AS category_id
            
            FROM ' .$this->table. ' q
            JOIN authors a ON q.author_id = a.id
            JOIN categories c ON q.category_id = c.id
            WHERE q.author_id = :author_id';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':author_id',$this->author_id);
            $stmt->execute();

            return $stmt;
        }

    //get all quotes in a category
        public function read_category(){
            $query = 'SELECT
            q.id, 
            q.quote,
            q.author_id AS author_id,
            q.category_id AS category_id
            
            FROM ' .$this->table. ' q
            JOIN authors a ON q.author_id = a.id
            JOIN categories c ON q.category_id = c.id
            WHERE q.category_id = :category_id';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':category_id',$this->category_id);
            $stmt->execute();

            return $stmt;
        }

    //get all quotes in a category by an author
        public function read_author_category(){
            $query = 'SELECT
            q.id, 
            q.quote,
            q.author_id AS author_id,
            q.category_id AS category_id
            
            FROM ' .$this->table. ' q
            JOIN authors a ON q.author_id = a.id
            JOIN categories c ON q.category_id = c.id
            WHERE q.author_id = :author_id
            AND q.category_id = :category_id';
 
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':author_id',$this->author_id);
            $stmt->bindParam(':category_id',$this->category_id);
            $stmt->execute();

            return $stmt;
        }
    //get quote by id
        public function read_single() {
            $query = 'SELECT 
            q.id, 
            q.quote, 
            q.author_id AS author_id, 
            q.category_id AS category_id
            
            FROM ' .$this->table. ' q
            JOIN authors a ON q.author_id = a.id
            JOIN categories c ON q.category_id = c.id
            WHERE q.id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->quote = $row['quote'];
        $this->author_id = $row['author_id'];
        $this->category_id= $row['category_id'];

        }
    //POST
        public function create() {
            $query = 'INSERT INTO ' . 
            $this->table . ' (quote,author_id,category_id) VALUES
            (
            :quote,
            :author_id,
           :category_id)';


            //Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id',$this->category_id);

            
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
                    quote= :quote,
                    author_id= :author_id,
                    category_id = :category_id
                WHERE
                    id = :id';
    
    
                //Clean data
                $this->quote = htmlspecialchars(strip_tags($this->quote));
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $this->id = htmlspecialchars(strip_tags($this->id));

    
                $stmt = $this->conn->prepare($query);
    
                $stmt->bindParam(':quote', $this->quote);
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':category_id',$this->category_id);
                $stmt->bindParam(':id',$this->id);

                
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




    }