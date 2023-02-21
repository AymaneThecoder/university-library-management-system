<?php

require_once './model/user.php';
require_once './model/borrow.php';

$borrow_data = json_decode($_POST['data'], true);

$borrow_response = borrowDocument($borrow_data);
echo json_encode($borrow_response);

function borrowDocument($borrow_data){
    $response = array();
    if(userCanBorrow($borrow_data['userID']))
    {
        $borrow_id = uniqid();
        $borrow_data += array('borrow_id' => $borrow_id);
        createBorrow($borrow_data);
        $response = array('borrowCode' => $borrow_id);
    } else {
      $response = array('borrowError' => 'Vous avez epuise votre empruntes, Vous devez ramenez une empruntes pour profiter d\'une autre');
    }
    return $response;
}

function userCanBorrow($user_id){
  $userModel = new user();
  $user = $userModel->getUserByID($user_id);
  $borrows_left = $user['borrows_left'];
  return $borrows_left > 0;
}

function createBorrow($data){
  $borrow_id = $data['borrow_id'];
  $user_id = $data['userID'];
  $doc_id = $data['docID'];
  $borrowModel = new borrow();
  $borrowModel->add_borrow($borrow_id, $user_id, $doc_id);
}