<?php

require_once '../model/document.php';

$documentModel = new document();
$doc_id = $_GET['doc_id'];
$document = $documentModel->getDocumentByID($doc_id);
