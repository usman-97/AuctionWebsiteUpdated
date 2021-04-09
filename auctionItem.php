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
// $view->currentPage = 10;

// logout script
require_once ('logout.php');

// Instance of AuctionItemDataSet
$view->auctionItemDateSet = new AuctionItemDateSet();
// Instance of BidItemDataSet
$bidItemDataSet = new BidItemDataSet();
$auction = new AuctionDataSet();
// Instance from AuctionDataSet
// $auction = new AuctionDataSet();
// Number of total pages to display
$view->totalPages = '';
$view->nameOfAuction = '';
$view->currentLimit ='';

// If auctionItem button is pressed
/*if (isset($_POST['auctionItem']))
{
    // Then start auctionItem session
    $_SESSION['auctionItem'] = true;
}

// If backToAuction button is pressed
if (isset($_POST['backToAuction']))
{
    // Then delete auctionItem session
    unset($_SESSION['auctionItem']);
}
var_dump($_SESSION['auctionItem']);
// var_dump($_POST['nameOfAuction']);

if (isset($_POST['nameOfAuction']))
{
    $view->nameOfAuction = $_POST['nameOfAuction'];
}
else
{
    if (isset($_POST['saveAuctionName']))
    {
        $view->nameOfAuction = $_POST['saveAuctionName'];
    }
}
var_dump($view->nameOfAuction);
var_dump($_GET['nameOfAuction']);*/

if (isset($_POST['filters']))
{
    $view->filter = $_POST['filters'];
}
else
{
    if (isset($_POST['filterOption']))
    {
        $view->filter = $_POST['filterOption'];
    }
}

if (isset($_POST['clearFilter']))
{
    $view->filter = 'none';
}
// var_dump($view->filter);

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
// var_dump($_SESSION['searchedItem']);

// If search button is pressed
if (isset($_POST['searchButton'])) {

    $_SESSION['searchedItem'] = $_POST['searchBar'];
    unset($_SESSION['viewItem']); // set viewItem session to view individual item
    // $_SESSION['auctionItem'] = true;
    $searchTerm = $_POST['searchBar']; // Stores the value from search bar

    // if search field is not empty
    if (!empty(trim($searchTerm))) {
        // Then start searchMode session
        $_SESSION['searchMode'] = true;
    }
}
// var_dump($_SESSION['searchMode']);

// If clear button is pressed
if (isset($_POST['clearSearch'])) {
    $_SESSION['searchMode'] = null; // Delete searchMode session
    // $_SESSION['searchItem'] = null; // Clear search item session
    $_POST['searchBar'] = null; // Clear search field
    unset($_SESSION['viewItem']); // Clear view item session
    unset($_SESSION['searchedItem']);
}


$view->limit = 20;
$firstPage = ($page - 1) * $view->limit;

// If searchMode session is set
if (isset($_SESSION['searchMode'])) {
    // Total number of records which are searched by user.
    $view->totalRecords = $view->auctionItemDateSet->getTotalSearchRecords($_SESSION['searchedItem']);
    // If no record found from user search
    if (!$view->totalRecords) {
        // then return error message
        $view->error = $_SESSION['searchedItem'] . ' not found';
    }

    $view->totalPages = $view->totalRecords/$view->limit;

    // var_dump($_SESSION['searchedItem']);
    // only show records that match the entered search term
    $view->auctionItem = $view->auctionItemDateSet->fetchSomeAuctionItem($_SESSION['searchedItem'], $firstPage, $view->limit, $view->filter);
}
else {
    if (isset($_SESSION['item']))
    {
        $view->auctionItem = $view->auctionItemDateSet->fetchSpecificItem($firstPage, $view->limit, $_SESSION['item']);
        $view->totalRecords = $view->auctionItemDateSet->getTotalCategoryRecords($_SESSION['item']);
    }
    elseif (isset($_SESSION['viewAuctionLots']))
    {
        $view->auctionItem = $view->auctionItemDateSet->fetchAuctionLots($firstPage, $view->limit, $_SESSION['viewAuctionLots']);
        $view->totalRecords = $auction->getTotalRecords($_SESSION['viewAuctionLots']);
    }
    else
    {
        $view->auctionItem = $view->auctionItemDateSet->fetchAllAuctionItem($firstPage, $view->limit);
        shuffle($view->auctionItem);
        $view->totalRecords = $view->auctionItemDateSet->getTotalRecords(); // Total number of records in Lots table
    }
    $view->totalPages = $view->totalRecords / $view->limit; // Total number of pages
    // var_dump($view->totalPages);
}

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
    $view->auctionItemDateSet->incrementView($view->lotID);
    header("Location: viewItem.php");
}

if (isset($_POST['applyFilter']))
{
    echo $_POST['filters'];
}

require_once('Views/auctionItem.phtml');


