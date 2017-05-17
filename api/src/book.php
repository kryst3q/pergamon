<?php

class Book Implements JsonSerializable {
    
    private $id;
    private $title;
    private $author;
    
    public function __construct() {
        $this->id = -1;
        $this->title = "";
        $this->author = "";
    }
    
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author
        ];
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
    
    public function loadFromDB($connection,$id = null) {
        
        $query;
        
        if (empty($id)) {
            
            $query = "SELECT * FROM Books";
            
        } else {
            
            $query = "SELECT * FROM Books WHERE id=$id";
            
        }
        
        $result = $connection->query($query);
        
        $books;
        
        if (($result == TRUE) && ($result->num_rows != 0)) {
            
            foreach ($result as $row) {
                
                $book = new Book();
                $book->id = $row['id'];
                $book->title = $row['title'];
                $book->author = $row['author'];

                $books = $book;
            
            }
            
            return $books;
            
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

