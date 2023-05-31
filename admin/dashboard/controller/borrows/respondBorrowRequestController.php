<?php

    include_once "../../../../app/config/db.php";

    $connection = getConnection();

    // Validate form
    $toReturn = [
        'status' => '',
        'errors' => array()
    ];

    $action = htmlspecialchars($_POST['action']);
    $borrowCode = htmlspecialchars($_POST['borrowCode']);

    if(empty($action) || empty($borrowCode))
    {
        $toReturn['status'] = 'error';
        $toReturn['errors']['update'] = 'erreur lors de modification'; 
    }

    if(count($toReturn['errors']) > 0)
    {
        echo json_encode($toReturn);
        exit;
    }

    $borrowStatus = $action == 'accept'  ? 'active' : 'refuse';
    
    $update = $connection->prepare("UPDATE borrows b
                                    SET b.status = ?
                                    WHERE borrow_code=?"
                                    );
                                    
    if(!$update)
    {
        $toReturn['status'] = 'error';
    }
    else {
        $update->bindParam(1, $borrowStatus);
        $update->bindParam(2, $borrowCode);
        $update->execute();
        $toReturn['status'] = 'success';
    }

    echo json_encode($toReturn);   
?>