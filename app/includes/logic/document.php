<?php

require_once dirname(__DIR__) . '/data/document.php';
require_once dirname(__DIR__) . '/logic/helpers.php';

// Search

function search() {

    
    $search_query = filter_input(INPUT_GET, 'search_query', FILTER_SANITIZE_SPECIAL_CHARS);
    $docType = filter_input(INPUT_GET, 'doc_type', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Filters
    $filters = $sqlParams = [];

    if($search_query)
    {
        $filters[] = "(title like ? OR author like ?)";
        array_push($sqlParams, "%$search_query%", "%$search_query%");
    }

    if($docType)
    {
        $filters[] = "docType = ?";
        array_push($sqlParams, $docType);
    }    

    if(count($filters) > 0)
    {
        $filtersString = ' where ' . implode(' and ', $filters);
    }

    // Paginate

    $toReturn = paginate(12, 'documents', @$filtersString, $sqlParams);
    
    return array(
        'documents' => $toReturn['items'],
        'q' => $search_query ?? null,
        'nbrPages' => $toReturn['nbrOfPages'],
        'currentPage' => $toReturn['currentPage']
    );

}