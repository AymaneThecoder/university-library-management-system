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
      if(!isDocumentAlreadyBorrowed($borrow_data))
      {
        $borrow_data = createBorrow($borrow_data);
        return $borrow_data;
      }
      return array('borrowError' => 'Vous avez deja cette document dans vos empruntes!');
    }
    return array('borrowError' => 'Vous avez epuise votre empruntes, Vous devez ramenez une emprunte pour profiter d\'une autre!');
  }
  return array('borrowError' => 'Le document que vous shoautez emprunter n\'est existe pas ou les copies sont epuise');
}


function isDocumentAvailable($doc_id) {

  // Check if the document still exist in the database
  // And number of copies > 0

  $documentToBorrow =  getDocumentByID($doc_id);
  $nbrOfCopies =  isset($documentToBorrow['copiesLeft']) ? $documentToBorrow['copiesLeft'] : 0;
  return $nbrOfCopies > 0;
}


function userCanBorrow($user_id){
  
  // Check if the user has borrows left

  $user = getUserByIDOrEmail($user_id);
  $borrows_left = $user['borrows_left'];
  return $borrows_left > 0;
}

function isDocumentAlreadyBorrowed($data){

  // Check if the document is not already borrowed and not returned by that user
  $userId = $data['userID'];
  $docId = $data['docID'];
  
  $borrow = getBorrowByPrimaryKeys($userId, $docId);

  return !empty($borrow);
}

function createBorrow($data){

  // The borrow code is the code in which the librarien will know that this
  // student has made a borrow when he goes to the library to get his book
  
  $borrow_code = uniqid();

  // The date will be stored in sql in the format (yyyy-m-d)
  $borrow_date = date('Y-m-d');
  $return_date = date('Y-m-d', strtotime($borrow_date . '+ ' . max_doc_keep . ' days'));
  $user_id = $data['userID'];
  $doc_id = $data['docID'];
  add_borrow($user_id, $doc_id, $borrow_code, $return_date);
  return array('borrowCode' => $borrow_code, 'returnDate' => $return_date);
}