<?php

require_once dirname(__DIR__) . '/data/document.php';


// Index

function index() {
   $documents = getDocuments();
   return $documents;
}

// Show

function show() {
    $doc_id = filter_input(INPUT_GET, 'doc_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $document = getDocumentByID($doc_id);
    return $document;
}

// Search

function search() {
    $search_query = filter_input(INPUT_GET, 'search-query', FILTER_SANITIZE_SPECIAL_CHARS);

// Stay in the home page if the query is empty
    if(!$search_query)
    {
        header('Location: http://localhost/management-of-library/public/home.php');
        exit;
    }

    $documents = searchDocuments($search_query);
    return array(
        'documents' => $documents,
        'q' => $search_query
    );
}