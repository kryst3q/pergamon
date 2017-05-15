<?php

class Book {
    
    private $id;
    private $title;
    private $author;
    
    public function __construct() {
        $this->id = -1;
        $this->title = "";
        $this->author = "";
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setAuthor($author) {
        $this->author = $author;
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
    
    public function create($connection, $title, $author) {
        
        $query = "INSERT INTO Books (title, author) VALUES ('" . $title . "', '" . $author . "')";
        $result = $connection->query($query);
        
        if ($result) {
            
            $this->id = $result->insert_id;
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    public function update($connection, $title, $author) {
        
        $query = "UPDATE Books SET title='" . $title . "' author='" . $author . "' WHERE id=" . getId();
        $result = $connection->query($query);
        
        if ($result) {
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    public function loadFromDB($connection) {
        
        $query = "SELECT * FROM Books";
        $result = $connection->query($query);
        
        $books = [];
        
        if (($result == TRUE) && ($result->num_rows != 0)) {
            
            for ($i = 0; $i < $result->num_rows; $i++) {
                
                $book = new Book();
                $book->getId();
                $book->getAuthor();
                $book->getTitle();

                $books[] = $book;
            
            }
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    public function deleteFromDB($connection, $id) {
        
        $query = "DELETE FROM Books WHERE id=$id";
        $result = $connection->query($query);
        
        if ($result) {
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
}

