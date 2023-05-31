<?php
include_once "../dataBaseCon/dbconnect.php";
$borrow_code = $_POST["borrow_code"];

$sqlUpdateEmprunt = "UPDATE emprunt SET is_returned = 1 WHERE id_emp = '$borrow_code'";
$resultUpdateEmprunt = $conn->query($sqlUpdateEmprunt);

if ($resultUpdateEmprunt) {
  $sqlUpdateHistorical = "UPDATE historique SET return_date = NOW() WHERE id_emp = '$borrow_code'";
  $resultUpdateHistorical = $conn->query($sqlUpdateHistorical);

  if ($resultUpdateHistorical) {

    $sqlIncrementStock = "UPDATE document SET qte = qte + 1 WHERE id_doc IN (SELECT id_doc FROM emprunt WHERE id_emp = '$borrow_code')";
    $resultIncrementStock = $conn->query($sqlIncrementStock);
 
  } 
} 
?>
