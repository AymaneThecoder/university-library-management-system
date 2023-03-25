<?php

require_once '../../data/user.php';
require_once '../../data/document.php';
require_once '../../data/borrow.php';

$borrow_data = $_POST['data'];

// The max time for the use to keep the document (in days)
define('max_doc_keep', 21);

$borrow_response = borrowDocument($borrow_data);
echo json_encode($borrow_response);

function borrowDocument($borrow_data){
  if(isDocumentAvailable($borrow_data['docID']))
  {
    if(userCanBorrow($borrow_data['userID']))
    {
        $borrow_data = createBorrow($borrow_data);
        return $borrow_data;
    }
    return array('borrowError' => 'Vous avez epuise votre empruntes, Vous devez ramenez une emprunte pour profiter d\'une autre!');
  }
  return array('borrowError' => 'Le document que vous shoautez emprunter n\'est existe pas ou les copies sont epuise');
}


function isDocumentAvailable($doc_id) {
  $documentToBorrow =  getDocumentByID(6);
  $nbrOfCopies =  isset($documentToBorrow['nbrOfCopies']) ? $documentToBorrow['nbrOfCopies'] : 0;
  return $nbrOfCopies > 0;
}


function userCanBorrow($user_id){
  $user = getUserByIDOrEmail($user_id);
  $borrows_left = $user['borrows_left'];
  return $borrows_left > 0;
}

function createBorrow($data){

  $borrow_id = uniqid();

  // The date will be stored in sql in the format (yyyy-m-d)
  $borrow_date = date('Y-m-d');
  $return_date = date('Y-m-d', strtotime($borrow_date . '+ ' . max_doc_keep . ' days'));
  $user_id = $data['userID'];
  $doc_id = $data['docID'];
  add_borrow($borrow_id, $user_id, $doc_id, $borrow_date, $return_date);
  return array('borrowCode' => $borrow_id, 'returnDate' => $return_date);
}