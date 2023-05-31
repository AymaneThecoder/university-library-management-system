<?php

include_once "../../../../app/config/db.php";
include_once "../../../../app/includes/logic/helpers.php";

$connection = getConnection();

$borrow_code = htmlspecialchars($_POST['borrowCode']);

// Grab doc title and user email
$sql = 'SELECT b.*, u.email, u.full_name, d.title from borrows b
        INNER JOIN users u ON b.user_id=u.id
        INNER JOIN documents d ON b.doc_id=d.id
        WHERE b.borrow_code=?';

if($stmt = $connection->prepare($sql))
{
    $stmt->bindParam(1, $borrow_code);
    $stmt->execute();
    $borrow = $stmt->fetch();
    
    // Send the alert email
    $to = $borrow['email'];
    $subject = 'Retourner le document';
    $body = "<h2 style='margin-bottom: 30px;'>ESTLIB</h2>";
    $body .= "<p style='font-size: 16px;'>Bonjour monsieur <b>{$borrow['full_name']}</b>, vous devez rendre le document <b>{$borrow['title']}</b> à la librairie dans le plus tot possible</p>.";

    try {

        if(sendEmail(compact('to', 'subject', 'body')))
        {

            // Save the alert 
            $insert = $connection->prepare('INSERT INTO return_doc_alert (borrow_code) values (?)');

            if($insert)
            {
                $insert->bindParam(1, $borrow['borrow_code']);
                $insert->execute();
            }

            echo json_encode(['status' => 'success']);
            
        } else {
            echo json_encode(['status' => 'error']);
        }
    } catch(Exception $e){
        echo json_encode(['status' => 'error']);
    }

    exit;
}