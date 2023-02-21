<?php


require_once dirname(__DIR__) . '/config/db.php';

class user {

    private $conn;

    function __construct()
    {
        try {
            $this->conn = db::getConnection();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getUserByID($id){
        $query = $this->conn->prepare('select * from adherent where id = ?');
        $query->bindParam(1, $id);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}