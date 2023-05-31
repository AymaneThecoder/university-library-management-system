<?php
include_once "../dataBaseCon/dbconnect.php";
$borrow_code = $_POST["borrow_code"];

// Update emprunt table to mark the borrow as confirmed
$sqlUpdateEmprunt = "UPDATE emprunt SET is_confirmed = 1 WHERE id_emp = '$borrow_code'";
$resultUpdateEmprunt = $conn->query($sqlUpdateEmprunt);

if ($resultUpdateEmprunt) {
  $sqlInsertHistorical = "INSERT INTO historique (id_emp, id_adh, id_doc, borrow_date) SELECT id_emp, id_adh, id_doc, NOW() FROM emprunt WHERE id_emp = '$borrow_code'";
  $resultInsertHistorical = $conn->query($sqlInsertHistorical);

  if ($resultInsertHistorical) {
    // Decrement the stock count in the document table
    $sqlDecrementStock = "UPDATE document SET qte = qte - 1 WHERE id_doc IN (SELECT id_doc FROM emprunt WHERE id_emp = '$borrow_code')";
    $resultDecrementStock = $conn->query($sqlDecrementStock);
  } 
} 
?>