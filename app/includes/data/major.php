<?php

require_once dirname(__DIR__) . '/../config/db.php';

$conn = getConnection();

function getMajors(){
        global $conn;
        $sql = 'select * from majors';
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $majors = $query->fetchAll();
        return $majors;
    }