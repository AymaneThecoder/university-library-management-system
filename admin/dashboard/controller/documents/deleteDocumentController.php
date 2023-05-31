<?php

    include_once "../../../../app/config/db.php";
    require_once '../../../../app/includes/logic/helpers.php';

    $connection = getConnection();
    $toReturn = [
        'status' => '',
        'errors' => []
    ];
    $docId = htmlspecialchars($_POST['docId']);

    // Check if the document has any active borrows
    if($stmt = $connection->prepare('SELECT * FROM borrows b WHERE doc_id=? AND b.status != "returned" '))
    {
        $stmt->bindParam(1, $docId);
        $stmt->execute();
        $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($borrows) > 0)
        {
            $toReturn['status'] = 'error';
            $toReturn['errors']['canDelete'] = false;
        }
    }

    if(count($toReturn['errors']) > 0)
    {
        echo json_encode($toReturn);
        exit;
    }
    
    $delete = $connection->prepare("DELETE FROM documents
                                    WHERE id=?"
                                    );

    if($delete)
    {
        $delete->bindParam(1, $docId);
        $delete->execute();
        $toReturn['status'] = 'success';

        echo json_encode($toReturn);
    }

     
        
?>