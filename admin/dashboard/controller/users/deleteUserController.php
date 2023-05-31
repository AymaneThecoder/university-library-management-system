<?php

    include_once "../../../../app/config/db.php";
    require_once '../../../../app/includes/logic/helpers.php';

    $connection = getConnection();
    $toReturn = [
        'status' => ''
    ];

    $userId = htmlspecialchars($_POST['userId']);
    
    $delete = $connection->prepare("DELETE FROM users
                                    WHERE id=?"
                                    );

    if($delete)
    {
        $delete->bindParam(1, $userId);
        $delete->execute();
        $toReturn['status'] = 'success';

        echo json_encode($toReturn);
    }

     
        
?>