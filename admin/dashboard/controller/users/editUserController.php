<?php

    include_once "../../../../app/config/db.php";
    require_once '../../../../app/includes/logic/helpers.php';

    $connection = getConnection();

    // Validate form
    $toReturn = [
        'status' => '',
        'errors' => []
    ];

    $userId = htmlspecialchars($_POST['id']);

    $toReturn['errors'] = validateUserData($_POST, [
        'full_name' => ['required'],
        'email' => ['required', 'email', 'unique:users:' . $userId],
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
    
    $update = $connection->prepare("UPDATE users
                                    set full_name=?, email=?, branch_id=?, borrows_left=?, password=?, phone_number=? 
                                    WHERE id=?"
                                    );

    if($update)
    {
        $update->bindParam(1, $full_name);
        $update->bindParam(2, $email);
        $update->bindParam(3, $branch_id);
        $update->bindParam(4, $max_borrows);
        $update->bindParam(5, $password);
        $update->bindParam(6, $phone);
        $update->bindParam(7, $userId);

        $update->execute();
        $toReturn['status'] = 'success';

        echo json_encode($toReturn);
    }

     
        
?>