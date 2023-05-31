<?php

    include_once "../../../../app/config/db.php";
    require_once '../../../../app/includes/logic/helpers.php';

    $connection = getConnection();

    // Validate form
    $toReturn = [
        'status' => '',
        'errors' => []
    ];

    $toReturn['errors'] = validateUserData(array_merge($_POST, $_FILES), [
        'title' => ['required'],
        'author' => ['required'],
        'doc_desc' => ['required'],
        'copies_left' => ['required'],
        'doc_img' => ['ftypes:png,jpg,jpeg']
    ]);

    if(count($toReturn['errors']) > 0)
    {
        $toReturn['status'] = 'error';
        echo json_encode($toReturn);
        exit;
    }


    // Store the image file
    if(isset($_FILES['doc_img']) && $_FILES['doc_img']['name'])
    {
        $fileExt = explode('.', $_FILES['doc_img']['name'])[1];

        // Create a unique name
        $fileUniqueName = uniqid();
    
        $filePath = $fileUniqueName .'.' . $fileExt;
    
        move_uploaded_file($_FILES['doc_img']['tmp_name'], dirname(__DIR__) . '../../assets/images/uploads/doc_images/' . $filePath);
    }

    $doc_id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $page_count = htmlspecialchars($_POST['page_count']);
    $copies_left = htmlspecialchars($_POST['copies_left']);
    $doc_desc = htmlspecialchars($_POST['doc_desc']);
    $category_id= htmlspecialchars($_POST['category_id']);
    $type_id = htmlspecialchars($_POST['type_id']);
    $doc_img = $filePath ?? null;
    
    $update = $connection->prepare("UPDATE documents
                                    SET title=?, doc_desc=?, author=?, page_count=?, doc_img=?, copies_left=?, type_id=?, category_id=? 
                                    WHERE id=?"
                                    );

    if($update)
    {
        $update->bindParam(1, $title);
        $update->bindParam(2, $doc_desc);
        $update->bindParam(3, $author);
        $update->bindParam(4, $page_count);
        $update->bindParam(5, $doc_img);
        $update->bindParam(6, $copies_left);
        $update->bindParam(7, $type_id);
        $update->bindParam(8, $category_id);
        $update->bindParam(9, $doc_id);

        $update->execute();
        $toReturn['status'] = 'success';

        echo json_encode($toReturn);
    }

     
        
?>