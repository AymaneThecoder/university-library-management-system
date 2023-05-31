<?php

    include_once "../../../../app/config/db.php";
    require_once '../../../../app/includes/logic/helpers.php';

    $connection = getConnection();

    // Validate form
    $toReturn = [
        'status' => '',
        'errors' => []
    ];

    $toReturn['errors'] = validateUserData($_POST, [
        'full_name' => ['required'],
        'email' => ['required', 'email', 'unique:users'],
        'phone_number' => ['required', 'phone'],
        'password' => ['required', 'min:8', 'confirmed']
    ]);

    if(count($toReturn['errors']) > 0)
    {
        $toReturn['status'] = 'error';
        echo json_encode($toReturn);
        exit;
    }
       
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $branch_id = htmlspecialchars($_POST['branch_id']);
    $phone = htmlspecialchars($_POST['phone_number']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

    // Maw borrows per user
    $max_borrows =  3;
    
    $insert = $connection->prepare("INSERT INTO users
                                    (full_name, email, branch_id, borrows_left, password, phone_number) 
                                    VALUES (?, ?, ?, ?, ?, ?)"
                                    );

    if($insert)
    {
        $insert->bindParam(1, $full_name);
        $insert->bindParam(2, $email);
        $insert->bindParam(3, $branch_id);
        $insert->bindParam(4, $max_borrows);
        $insert->bindParam(5, $password);
        $insert->bindParam(6, $phone);

        $insert->execute();
        $toReturn['status'] = 'success';

        echo json_encode($toReturn);
    }

     
        
?>