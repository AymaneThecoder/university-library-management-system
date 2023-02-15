<?php

class db {
    static private $host = 'localhost';
    static private $db_name = 'library_management'; 
    static private $user = 'root';
    static private $pwd = '';


    public static function getConnection(){
        try {
            $conn = new PDO("mysql:host=".self::$host.";dbname=".self::$db_name, self::$user, self::$pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}