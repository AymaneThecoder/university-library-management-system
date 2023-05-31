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
    if($_FILES['doc_img']['name'])
    {
        $imageExt = explode('.', $_FILES['doc_img']['name'])[1];

        // Create a unique name
        $imageUniqueName = uniqid();
    
        $imagePath = $imageUniqueName .'.' . $imageExt;
    
        move_uploaded_file($_FILES['doc_img']['tmp_name'], dirname(__DIR__) . '../../assets/images/uploads/doc_images/' . $imagePath);
    }

       
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $page_count = htmlspecialchars($_POST['page_count']);
    $copies_left = htmlspecialchars($_POST['copies_left']);
    $doc_desc = htmlspecialchars($_POST['doc_desc']);
    $category_id= htmlspecialchars($_POST['category_id']);
    $type_id = htmlspecialchars($_POST['type_id']);
    $doc_img = $imagePath ?? null;
    
    $insert = $connection->prepare("INSERT INTO documents
                                    (title, doc_desc, author, page_count, doc_img, copies_left, type_id, category_id) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                                    );

    if($insert)
    {
        $insert->bindParam(1, $title);
        $insert->bindParam(2, $doc_desc);
        $insert->bindParam(3, $author);
        $insert->bindParam(4, $page_count);
        $insert->bindParam(5, $doc_img);
        $insert->bindParam(6, $copies_left);
        $insert->bindParam(7, $type_id);
        $insert->bindParam(8, $category_id);

        $insert->execute();
        $toReturn['status'] = 'success';

        echo json_encode($toReturn);
    }

     
        
?>