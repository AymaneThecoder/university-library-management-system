<?php

require_once '../../app/config/db.php';

session_start();

$connection = getConnection();


if(isset($_POST['submit-btn'])){

    $loginError = '';

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $loginError = 'Les deux champs sont obligatoires!';
    }
    
    if (!$loginError && $stmt = $connection->prepare('SELECT id, password FROM admin WHERE username = ?')) {

        $stmt->bindParam(1, $_POST['username']);
    
        if ($stmt->execute()) {

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($result) > 0 && $_POST['password'] == $result[0]['password']){

                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['user_id'] = $result[0]['id'];
                header("Location: http://localhost/management-of-library/admin/dashboard/index.php");
                exit;
            }

            $loginError = 'Invalid login!';
        }
    
    }
}

?>
