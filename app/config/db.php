<?php


function getConnection(){
    $dsn = 'mysql:host=localhost;dbname=library_management';
    $user = 'root';
    $pwd = '';
    try {
        $conn = new PDO($dsn, $user, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
        } catch (PDOException $e){
            echo $e->getMessage();
    }
}