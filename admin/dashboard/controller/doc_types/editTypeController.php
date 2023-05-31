<?php

    include_once "../../../../app/config/db.php";

    $connection = getConnection();

    // Validate form
    $toReturn = [
        'status' => '',
        'errors' => array()
    ];

    if(empty($_POST['name']))
    {
        $toReturn['status'] = 'error';
        $toReturn['errors']['name'] = 'Nom est obligatoire!'; 
    }

    if(count($toReturn['errors']) > 0)
    {
        echo json_encode($toReturn);
        exit;
    }

    $typeId = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);

    $update = $connection->prepare("UPDATE doc_types
                                    SET name = '$name'
                                    WHERE id = '$typeId'"
                                    );
                                    
    if(!$update)
    {
        $toReturn['status'] = 'error';
    }
    else {
        $update->execute();
        $toReturn['status'] = 'success';
    }

    echo json_encode($toReturn);
     
        
?>