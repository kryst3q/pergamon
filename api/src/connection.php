<?php

$host = 'localhost';
$username = 'root';
$password = 'coderslab';
$dbname = 'pergamon';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

