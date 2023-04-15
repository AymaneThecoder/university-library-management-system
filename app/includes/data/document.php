<?php

require_once dirname(__DIR__) . '/../config/db.php';

$conn = getConnection();

function getDocuments(){
        global $conn;
        $sql = 'select * from documents';
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $documents = $query->fetchAll();
        return $documents;
    }

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

function searchDocuments($search_for){
        global $conn;
        $search_for = '%' . $search_for . '%';
        $sql = "select * from documents where title like ? OR author like ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1, $search_for);
        $query->bindParam(2, $search_for);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $documents = $query->fetchAll();
        return $documents;
    }