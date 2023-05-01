<?php

require_once dirname(__DIR__) . '/data/document.php';

// Search

function search() {

    $search_query = filter_input(INPUT_GET, 'search_query', FILTER_SANITIZE_SPECIAL_CHARS);

    /* Pagination */
    
    // Get number of documents avaialabe for that search query

    $sql = 'select count(*) as total from documents where author like ? OR title like ?';
    $countResult = customDocumentQuery($sql, ["%$search_query%", "%$search_query%"]);
    $totalDocs = $countResult[0]['total'];

    // Paginate
    
    $currentPage = htmlspecialchars(abs($_GET['page'] ?? 1));
    $nbrDocsPerPage = 5;
    $nbrPages = ceil($totalDocs / $nbrDocsPerPage);
    $startOffset = ($currentPage - 1) * $nbrDocsPerPage;

    $sql = 'select * from documents where author like ? OR title like ? limit ?,?';
    $documents = customDocumentQuery($sql, ["%$search_query%", "%$search_query%", $startOffset, $nbrDocsPerPage]);
    
    return array(
        'documents' => $documents,
        'q' => $search_query,
        'nbrPages' => $nbrPages,
        'currentPage' => $currentPage
    );

}