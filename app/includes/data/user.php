<?php


require_once dirname(__DIR__) . '/../config/db.php';

$conn = getConnection();


function addUser($fullName, $email, $majorId, $password){
        global $conn;

        // Max borrows per user
        define('MAX_BORROWS', 3);

        $sql = 'insert into users values (?, ?, ?, ?, ?, ?)';
        $query = $conn->prepare($sql);
        $id = null;
        $maxBorrows = MAX_BORROWS;
        $query->bindParam(1, $id);
        $query->bindParam(2, $fullName);
        $query->bindParam(3, $email);
        $query->bindParam(4, $majorId);
        $query->bindParam(5, $maxBorrows);
        $query->bindParam(6, $password);
        $query->execute();
}

function getUserByIDOrEmail($findBy){
        global $conn;
        $sql = '';

        if(strpos($findBy, '@'))
        {
         $sql = 'select * from users where email = ?';
        } else {
         $sql = 'select * from users where userId = ?';
        }

        $query = $conn->prepare($sql);
        $query->bindParam(1, $findBy);
        $query->execute();
        $user = $query->fetchAll(PDO::FETCH_ASSOC);
        return !empty($user) ? $user[0] : null;
}
