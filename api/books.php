<?php

require_once 'src/Book.php';
require_once 'src/connection.php';

$book1 = new Book();
$book1->loadFromDB($conn, 1);
var_dump($book1);
var_dump(Book::loadFromDB($conn,1));
//var_dump(Book::jsonSerialize(Book::loadFromDB($conn)));

//if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//    
//} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    
//}

