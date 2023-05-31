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

       
    $name = htmlspecialchars($_POST['name']);

    $insert = $connection->prepare("INSERT INTO doc_types
                                    (name) 
                                    VALUES ('$name')"
                                    );
                                    
    if(!$insert)
    {
        $toReturn['status'] = 'error';
    }
    else {
        $insert->execute();
        $toReturn['status'] = 'success';
    }

    echo json_encode($toReturn);
     
        
?>