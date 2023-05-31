<?php

    include_once "../../../../app/config/db.php";

    $connection = getConnection();

    // Validate form
    $toReturn = [
        'status' => '',
        'errors' => []
    ];

    $ctgrId = htmlspecialchars($_POST['ctgrId']);
    
    if(empty($ctgrId))
    {
        $toReturn['status'] = 'error';
        $toReturn['errors']['id'] = 'ID cannot be empty!';
        echo json_encode($toReturn);
    }

    $delete = $connection->prepare("DELETE from doc_categories
                                    WHERE id = '$ctgrId'"
                                    );
                                    
    if(!$delete)
    {
        $toReturn['status'] = 'error';
    }
    else {
        $delete->execute();
        $toReturn['status'] = 'success';
    }

    echo json_encode($toReturn);
     
        
?>