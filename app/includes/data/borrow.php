<?php

require_once dirname(__DIR__) . '/../config/db.php';

$conn = getConnection();

function add_borrow($user_id, $doc_id, $borrow_code, $borrow_date, $return_date, $receiptUrl){
        global $conn;
        $query = $conn->prepare('INSERT INTO borrows VALUES (?, ?, ?, ?, ?, ?, ?)');

        // New borrows is not returned
        $status = 'en cours';

        $query->bindParam(1, $user_id);
        $query->bindParam(2, $doc_id);
        $query->bindParam(3, $borrow_code);
        $query->bindParam(4, $borrow_date);
        $query->bindParam(5, $return_date);
        $query->bindParam(6, $status);
        $query->bindParam(7, $receiptUrl);
        $query->execute();
}

function getBorrowByPrimaryKeys($userId, $docId){
        global $conn;
        $query = $conn->prepare('SELECT * FROM borrows WHERE user_id = ? AND doc_id = ?');
        $query->bindParam(1, $userId);
        $query->bindParam(2, $docId);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
}

function getBorrowsByUserID($userId){
        global $conn;
        $query = $conn->prepare('SELECT b.*, d.title from borrows b
                                LEFT JOIN documents d ON b.doc_id=d.id 
                                WHERE user_id = ?
                                ORDER BY b.borrow_date DESC');
        $query->bindParam(1, $userId);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
}




