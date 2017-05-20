<?php

class Book Implements JsonSerializable {
    
    private $id;
    private $title;
    private $author;
    private $description;
    
    public function __construct() {
        $this->id = -1;
        $this->title = "";
        $this->author = "";
        $this->description = "";
    }
    
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'author' => $this->getAuthor(),
            'description' => $this->getDescription()
        ];
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setAuthor($author) {
        $this->author = $author;
    }
    
    function setDescription($description) {
        $this->description = $description;
    }
    
    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getAuthor() {
        return $this->author;
    }
    
    function getDescription() {
        return $this->description;
    }

        
    static public function create($connection, $title, $author, $description) {
        
        if (empty($title) || empty($author) || empty($description)) {
            
            return FALSE;
            
        }
        
        $query = "INSERT INTO Books (title, author, description) VALUES ('" . $title . "', '" . $author . "', '" . $description . "')";
        $result = $connection->query($query);
        
        if ($result) {
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    static public function update($connection, $id, $title = "", $author = "", $description = "") {
        
        if (!empty($title)) {
            
            $query = "UPDATE Books SET title='" . $title . "' WHERE id=" . (int)$id;
            $result = $connection->query($query);
            
        }
        
        if (!empty($author)) {
            
            $query = "UPDATE Books SET author='" . $author . "' WHERE id=" . (int)$id;
            $result = $connection->query($query);
            
        }
        
        if (!empty($description)) {
            
            $query = "UPDATE Books SET description='" . $description . "' WHERE id=" . (int)$id;
            $result = $connection->query($query);
            
        }
        
        if ($result) {
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    static public function loadFromDB($connection,$id = null) {
        
        $query;
        
        if ($id == null) {
            
            $query = "SELECT * FROM Books ORDER BY title ASC";
            
        } else {
            
            $query = "SELECT * FROM Books WHERE id=$id";
            
        }
        
        $result = $connection->query($query);
        
        $books = [];
        
        if ($result->num_rows != 0) {
            
            foreach ($result as $row) {
                
                $book = new Book();
                $book->id = (int)$row['id'];
                $book->title = utf8_encode($row['title']);
                $book->author = utf8_encode($row['author']);
                $book->description = utf8_encode($row['description']);
                
                $books[] = $book;
            
            }
            
            return $books;
            
        }
            
        return FALSE;
        
    }
    
    static public function deleteFromDB($connection, $id) {
        
        $Id = (int)$id;
        
        $query = "DELETE FROM Books WHERE id=$Id";
        $result = $connection->query($query);
        
        if ($result) {
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
}

