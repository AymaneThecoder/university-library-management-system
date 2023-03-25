<?php

require_once dirname(__DIR__) . '/../config/db.php';

$conn = getConnection();

function add_borrow($borrow_id, $user_id, $doc_id, $borrow_date, $return_date){
        global $conn;
        $query = $conn->prepare('insert into borrow values (?, ?, ?, ?, ?)');
        $query->bindParam(1, $borrow_id);
        $query->bindParam(2, $user_id);
        $query->bindParam(3, $doc_id);
        $query->bindParam(4, $borrow_date);
        $query->bindParam(5, $return_date);
        $query->execute();
}
