<?php

require_once('Models/AuctionItemDateSet.php');
require_once('Models/BidItemDataSet.php');
require_once('Models/AuctionDataSet.php');
require_once ('Models/AuctionDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Feature Lots';
$view->lotID = '';
$view->currentSearchItem = '';
$view->filter  = '';
$view->category = '';
$view->minPrice = '';
$view->maxPrice = '';
// $view->isCategoryChecked = '';

// logout script
require_once ('logout.php');

// Instance of AuctionItemDataSet
$view->auctionItemDateSet = new AuctionItemDateSet();
// Instance of BidItemDataSet
$bidItemDataSet = new BidItemDataSet();
$auction = new AuctionDataSet();

$view->totalPages = '';
$view->nameOfAuction = '';
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


if (isset($_POST['searchButton']) || isset($_POST['morePages']) ||  isset($_POST['lessPages'])
    || isset($_POST['view']) || isset($_POST['back']) || isset($_POST['clearFilter']))
{
    // If search bar is filled
    if (!empty($_POST['searchBar']))
    {
        // Then store the value of search bar
        $_SESSION['searchedItem'] = $_POST['searchBar'];
        $view->currentSearchItem =  $_SESSION['searchedItem'];
        $view->currentLimit = 0;
    }
    else
    {
        // If save search is filled
        if (isset($_POST['saveSearch']))
        {
            // Then store the value of save search field
            $view->currentSearchItem = $_POST['saveSearch'];
        }
        elseif (isset($_SESSION['searchedItem']))
        {
            $view->currentSearchItem = $_SESSION['searchedItem'];
        }
    }
}

require ('searchBar.php');
// var_dump($_SESSION['searchMode']);

$view->limit = 20;
$view->firstPage = ($page - 1) * $view->limit;

if (isset($_SESSION['sortingFilter']))
{
    $view->filter = $_SESSION['sortingFilter'];
}

if (isset($_SESSION['selectedCategory']))
{
    $view->category = $_SESSION['selectedCategory'];
}

if (isset($_SESSION['minPrice']))
{
    $view->minPrice = $_SESSION['minPrice'];
}

if (isset($_SESSION['maxPrice']))
{
    $view->maxPrice = $_SESSION['maxPrice'];
}

//echo '<br /><br /><br /><br />';
//var_dump($_SESSION['sortingFilter']);
//var_dump($_SESSION['selectedCategory']);

// If searchMode session is set
if (isset($_SESSION['searchMode'])) {
    // Total number of records which are searched by user.
    $view->totalRecords = $view->auctionItemDateSet->getTotalSearchRecords($_SESSION['searchedItem']);
    // If no record found from user search
    if (!$view->totalRecords) {
        // then return error message
        $view->error = $_SESSION['searchedItem'] . ' not found';
    }

    $view->totalPages = ceil($view->totalRecords/$view->limit);

    // var_dump($view->totalPages);
    // only show records that match the entered search term
    $view->auctionItem = $view->auctionItemDateSet->fetchSomeAuctionItem($_SESSION['searchedItem'], $view->firstPage, $view->limit, $view->filter);
}
else {
    if (isset($_SESSION['item']))
    {
        $view->auctionItem = $view->auctionItemDateSet->fetchSpecificItem($view->firstPage, $view->limit, $_SESSION['item']);
        $view->totalRecords = $view->auctionItemDateSet->getTotalCategoryRecords($_SESSION['item']);
    }
    elseif (isset($_SESSION['viewAuctionLots']))
    {
        $view->auctionItem = $view->auctionItemDateSet->fetchAuctionLots($view->firstPage, $view->limit, $_SESSION['viewAuctionLots']);
        $view->totalRecords = $auction->getTotalRecords($_SESSION['viewAuctionLots']);
    }
    else
    {
        $view->auctionItem = $view->auctionItemDateSet->fetchAllAuctionItem($view->firstPage, $view->limit, $view->filter, $view->category, $view->minPrice, $view->maxPrice);
        // shuffle($view->auctionItem);
        $view->totalRecords = $view->auctionItemDateSet->getTotalRecords(); // Total number of records in Lots table
    }
    $view->totalPages = $view->totalRecords / $view->limit; // Total number of pages
    // var_dump($view->totalRecords);
}

$_SESSION['lotPerPage'] = $view->firstPage;
$_SESSION['limitPerPage'] = $view->limit;
//echo '<br /><br /><br /><br />';
//var_dump($_SESSION['lotPerPage']);
//var_dump($_SESSION['lotPerPage'] + 20);

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

if (isset($_POST['lotID']))
{
    $view->lotID = $_POST['lotID'];
}
else
{
    if (isset($_POST['lot_id']))
    {
        $view->lotID = $_POST['lot_id'];
    }
}

// If view button is pressed
if (isset($_POST['view']))
{
    // require_once('item.php');

    // Start viewItem session
    $_SESSION['viewItem'] = true;
    $_SESSION['viewLotID'] = $view->lotID;
    $_SESSION['viewAuctionID'] = $_POST['auctionID'];
    $view->auctionItemDateSet->incrementView($view->lotID);
    header("Location: viewItem.php");
}

//var_dump($_POST['sortingFilter']);
//var_dump($_SESSION['selectedCategory']);
if (isset($_POST['clearFilters']) || isset($_POST['clearSearch']))
{
    unset($_SESSION['sortingFilter']);
    unset($_SESSION['selectedCategory']);
    unset($_SESSION['minPrice']);
    unset($_SESSION['maxPrice']);
}

//if (isset($_POST['applyFilter']))
//{
//    echo $_POST['filters'];
//}

//if (isset($_SESSION['sortingFilter']))
//{
//    var_dump($_SESSION['sortingFilter']);
//}

require_once('Views/auctionItem.phtml');


