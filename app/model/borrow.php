<?php


require_once dirname(__DIR__) . '/config/db.php';

class borrow {

    private $conn;

    function __construct()
    {
        try {
            $this->conn = db::getConnection();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function add_borrow($borrow_id, $user_id, $doc_id){
        $query = $this->conn->prepare('insert into borrow values (?, ?, ?)');
        $query->bindParam(1, $borrow_id);
        $query->bindParam(2, $user_id);
        $query->bindParam(3, $doc_id);
        $query->execute();
    }
}