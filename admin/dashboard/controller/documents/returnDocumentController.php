<?php

    include_once "../../../../app/config/db.php";
    require_once '../../../../app/includes/logic/helpers.php';

    $connection = getConnection();

    // Validate form
    $toReturn = [
        'status' => '',
        'errors' => []
    ];
       
    $borrow_code = htmlspecialchars($_POST['borrowCode']);
    
    $update = $connection->prepare("UPDATE borrows b
                                    SET b.status='retourne' 
                                    WHERE borrow_code = ?"
                                    );

    if($update)
    {
        $update->bindParam(1, $borrow_code);

        $update->execute();
        $toReturn['status'] = 'success';

        echo json_encode($toReturn);
    }

     
        
?>