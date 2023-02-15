<?php

require_once '../model/document.php';

$documentModel = new document();

$documents = $documentModel->getDocuments();
$documents_count = count($documents);