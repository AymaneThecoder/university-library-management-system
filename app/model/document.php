<?php

require_once '../config/db.php';

class document {

    private $conn;

    function __construct()
    {
        try {
            $this->conn = db::getConnection();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getDocuments(){
        $sql = 'select * from document';
        $query = $this->conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $documents = $query->fetchAll();
        return $documents;
    }

    public function getDocumentByID($id){
        $sql = 'select * from document where doc_id = ?';
        $query = $this->conn->prepare($sql);
        $query->bindParam(1, $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $document = $query->fetchAll();
        $document = $document[0];
        return $document;
    }
}