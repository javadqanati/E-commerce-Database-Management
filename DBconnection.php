<?php
    $host = "localhost";
    $username = "root";
    $password = "8151@Javad";
    $database = "ecommerce_db";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>
