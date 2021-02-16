<?php

$limit = 20; // Limit of lots which will be displayed on auction item page
$view->totalRecords = $view->auctionItemDateSet->getTotalRecords(); // Total number of records in Lots table
$view->totalPages = $view->totalRecords / $limit; // Total number of pages

// the first page in auction item
$firstPage = ($page - 1) * $limit;

if (isset($_GET['page'])) {
    // If $page is greater than 1
    if ($_GET['page'] > 1) {
        // then decrement it by 1
        $view->previous = '?page=' . ($_GET['page'] - 1);
    } else {
        $view->previous = '#';
    }
}

if (isset($_GET['page'])) {
    // if page is less than total pages
    if ($_GET['page'] < $view->totalPages) {
        // increment $page by 1
        $view->next = '?page=' . ($_GET['page'] + 1);
    } else {
        $view->next = '#';
    }
}