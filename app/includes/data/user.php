<?php


require_once dirname(__DIR__) . '/../config/db.php';

$conn = getConnection();

// Max borrows per user
define('MAX_BORROWS', 3);

//Insert/update a user

function addUser($data){
        global $conn;

        $sql = 'insert into users values (?, ?, ?, ?, ?, ?)';

        $query = $conn->prepare($sql);
        $id = null;
        $maxBorrows = MAX_BORROWS;
        $query->bindParam(1, $id);
        $query->bindParam(2, $data['full_name']);
        $query->bindParam(3, $data['email']);
        $query->bindParam(4, $data['major']);
        $query->bindParam(5, $maxBorrows);
        $query->bindParam(6, $data['password']);
        $query->execute();
}

function getUserByIDOrEmail($findBy){
        global $conn;
        $sql = 'select * from users where userId = ? OR email = ?';
        $query = $conn->prepare($sql);
        $query->bindParam(1, $findBy);
        $query->bindParam(2, $findBy);
        $query->execute();
        $user = $query->fetchAll(PDO::FETCH_ASSOC);
        return !empty($user) ? $user[0] : null;
}

function updateUser($newUser){
        global $conn;

        $sql = 'update users set fullName = ?, email = ?, majorId = ?, password = ? where userId = ?';

        $query = $conn->prepare($sql);
        $query->bindParam(1, $newUser['full_name']);
        $query->bindParam(2, $newUser['email']);
        $query->bindParam(3, $newUser['major']);
        $query->bindParam(4, $newUser['password']);
        $query->bindParam(5, $newUser['user_id']);
        $query->execute();
}

// This function is used to perform custom
// SQL queries related to users table

function customUserQuery($sql, $params){
        global $conn;
        $query = $conn->prepare($sql);
    
        // Bind params
    
        $paramsTypes = [
            'integer' => PDO::PARAM_INT,
            'string' => PDO::PARAM_STR,
            'boolean' => PDO::PARAM_BOOL
        ];
    
        for($i = 0; $i < count($params); $i++)
        {
            $paramType = $paramsTypes[gettype($params[$i])];
            $query->bindParam($i + 1, $params[$i], $paramType);
        }
    
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $result = $query->fetchAll();
    
        return $result;
}