<?php

require_once 'src/book.php';
require_once 'src/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = Book::create($conn, $_POST['title'], $_POST['author'], $_POST['description']);
    
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    if (isset($_GET['id'])) {
        
        $id = (int)$_GET['id'];
        
        $book = Book::loadFromDB($conn,$id);
        header('Content-Type: application/json');
        echo json_encode($book);
        exit();
        
    }
    
    $book = Book::loadFromDB($conn);
    header('Content-Type: application/json');
    echo json_encode($book);
    
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    parse_str(file_get_contents("php://input"),$del_vars);
    $result = Book::deleteFromDB($conn, $del_vars['id']);
    
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    
    $put_vars;
    parse_str(file_get_contents("php://input"), $put_vars);
    console.log($put_vars);
    $result = Book::update($conn, $id, $put_vars['newTitle'], $put_vars['newAuthor'], $put_vars['newDescription']);
    
}
