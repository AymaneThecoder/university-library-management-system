<?php

require_once dirname(__DIR__) . '/../config/db.php';

$conn = getConnection();

// List all documents

function getDocuments(){
        global $conn;
        $sql = 'select * from documents';
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $documents = $query->fetchAll();
        return $documents;
}

// Get document by it's identifier

function getDocumentByID($id){
        global $conn;
        $sql = 'select * from documents where id = ?';
        $query = $conn->prepare($sql);
        $query->bindParam(1, $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $document = $query->fetchAll();
        $document = !empty($document) ? $document[0] : array();
        return $document;
}

// This function is used to perform custom
// SQL queries related to documents table

function customDocumentQuery($sql, $params){
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