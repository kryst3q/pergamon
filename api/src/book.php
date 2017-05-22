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

    public function validator($text) {
        
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        
        return $text;
        
    }
    
    public function setTitle($title) {
        
        $this->title = $this->validator($title);
        
    }

    public function setAuthor($author) {
        
        $this->author = $this->validator($author);
        
    }
    
    public function setDescription($description) {
        
        $this->description = $this->validator($description);
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }
    
    public function getDescription() {
        return $this->description;
    }

        
    static public function create($connection, $title, $author, $description) {
        
        if (empty($title) || empty($author) || empty($description)) {
            
            return FALSE;
            
        }
        
        $query = "INSERT INTO Books (title, author, description) VALUES ('" . self::validator($title) . "', '" . self::validator($author) . "', '" . self::validator($description) . "')";
        $result = $connection->query($query);
        
        if ($result) {
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    static public function update($connection, $id, $title = undefined, $author = undefined, $description = undefined) {
        
        $Id = (int)$id;
        
        if (is_string($title) && (!empty($title))) {
            
            $query = "UPDATE Books SET title='" . self::validator($title) . "' WHERE id=" . $Id;
            $result = $connection->query($query);
            
        }
        
        if (is_string($author) && (!empty($author))) {
            
            $query = "UPDATE Books SET author='" . self::validator($author) . "' WHERE id=" . $Id;
            $result = $connection->query($query);
            
        }
        
        if (is_string($description) && (!empty($description))) {
            
            $query = "UPDATE Books SET description='" . self::validator($description) . "' WHERE id=" . $Id;
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

