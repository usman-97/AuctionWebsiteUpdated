<?php

$view->currentLimit ='';

// If $page  is set
if (isset($_GET['page'])) {
    // then get current page
    $page = $_GET['page'];
} else {
    // otherwise set it to 1
    $page = 1;
    $_GET['page'] = 1;
}

// If current page number is smaller than 10
if (($_GET['page'] - 10) < 1)
{
    $view->currentPage = $_GET['page'] - 1; // Then display pages according to current page
}
else
{
    $view->currentPage = 10; // otherwise show total 10 pages for navigation
}

$limit = 20; // Limit of lots which will be displayed on auction item page
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