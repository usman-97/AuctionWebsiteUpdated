<?php

require_once('Models/AuctionItemDateSet.php');
require_once('Models/BidItemDataSet.php');
require_once('Models/AuctionDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Super Cars Auction';
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
    if (isset($_POST['searchBar']))
    {
        // Then store the value of search bar
        $view->currentSearchItem = $_POST['searchBar'];
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
    }
}

// If search button is pressed
if (isset($_POST['searchButton'])) {

    unset($_SESSION['viewItem']); // set viewItem session to view individual item
    // $_SESSION['auctionItem'] = true;
    $searchTerm = $_POST['searchBar']; // Stores the value from search bar

    // if search field is not empty
    if (!empty(trim($searchTerm))) {
        // Then start searchMode session
        $_SESSION['searchMode'] = true;
    }
}

// If clear button is pressed
if (isset($_POST['clearSearch'])) {
    $_SESSION['searchMode'] = null; // Delete searchMode session
    // $_SESSION['searchItem'] = null; // Clear search item session
    $_POST['searchBar'] = null; // Clear search field
    unset($_SESSION['viewItem']); // Clear view item session
}

// If searchMode session is set
if (isset($_SESSION['searchMode'])) {
    // $_SESSION['searchItem'] = $_POST['searchBar']; // Start search item session to store value from search bar

    // Total number of records which are searched by user.
    $view->totalRecords = $view->auctionItemDateSet->getTotalSearchRecords($view->currentSearchItem);
    // If no record found from user search
    if (!$view->totalRecords) {
        // then return error message
        $view->error = $view->currentSearchItem . ' not found';
    }
    // var_dump($view->totalRecords);

    // Total limit which will be increase or decrease
    // when user will press load more results or load few results
    $view->limit = 20;
    $current = 20;

    // If morePages button is pressed
    if (isset($_POST['morePages'])) {
        // If total searched records are greater than 20
        if ($view->totalRecords < 20) {
            // Then set them limit to show for one page
            $current = $view->totalRecords;
            // Set start point or range to 0
            $view->currentLimit = 0;
        }
        else {
            // Otherwise set limit of 20 to display records for each page
            // $view->limit = 20;

            // If pageLimit field is not empty
            if (isset($_POST['pageLimit'])) {
                // If pageLimit is less than totalNumber of search records
                if ($_POST['pageLimit'] < $view->totalRecords) {
                    // Then add limit of 20 to starting range
                    $view->currentLimit = $_POST['pageLimit'] + $view->limit;
                    // The end range is calculated by adding starting range and limit
                    $current = $view->currentLimit + $view->limit;
                }
            }
            else {
                // If savePageLimit is not empty
                if (isset($_POST['savePageLimit'])) {
                    // Then check if savePageLimit field is not empty
                    if ($_POST['savePageLimit'] < $view->totalRecords) {
                        // Then add limit of 20 to starting range
                        $view->currentLimit = $_POST['savePageLimit'] + $view->limit;
                        // The end range is calculated by adding starting range and limit
                        $current = $view->currentLimit + $view->limit;
                    }
                }
                else {
                    $view->currentLimit = 0;
                }
            }
        }
    }
    // var_dump($view->currentLimit);

    // If lessPages button is pressed
    if (isset($_POST['lessPages'])) {
        // If total searched records are greater than 20
        if ($view->totalRecords < 20) {
            // Then set them limit to show for one page
            $current = $view->totalRecords;
            // Set starting range to 0
            $view->currentLimit = 0;
        } else {
            // Otherwise set limit of 20 to display records for each page
            // $view->limit = 20;

            //If pageLimit field is not empty
            if (isset($_POST['pageLimit'])) {
                // If pageLimit is greater than 0
                if ($_POST['pageLimit'] > 0) {
                    // Then set starting range by subtracting limit to pageLimit
                    $view->currentLimit = $_POST['pageLimit'] - $view->limit;
                    // Set end range to sum of start range and limit
                    $current = $view->currentLimit + $view->limit;
                }
            }
            else {
                // If savePageLimit is set and not empty
                if (isset($_POST['savePageLimit'])) {
                    // If savePageLimit is not greater than total records
                    if ($_POST['savePageLimit'] < $view->totalRecords) {
                        // Then set starting range by subtracting limit to pageLimit
                        $view->currentLimit = $_POST['savePageLimit'] - $view->limit;
                        // Set end range to sum of start range and limit
                        $current = $view->currentLimit + $view->limit;
                    }
                }
                else {
                    // Otherwise set starting range to 0
                    $view->currentLimit = 0;
                }
            }
        }
    }

    // var_dump($view->currentLimit);
    // var_dump($view->limit);
    // var_dump($current);
    // var_dump($_POST['pageLimit']);
    // var_dump($_POST['savePageLimit']);

    $view->totalPages = $view->totalRecords/$view->limit;
    // $firstResultPage = ($view->currentLimit- 1) * $view->limit;
    // var_dump($firstResultPage);
    // var_dump($view->currentSearchItem);

    // only show records that match the entered search term
    $view->auctionItem = $view->auctionItemDateSet->fetchSomeAuctionItem($view->currentSearchItem, $view->currentLimit, $current, $view->filter);
}
else {
// If $page  is set
    /*if (isset($_GET['page'])) {
        // then get $page
        $page = $_GET['page'];
    } else {
        // otherwise set it to 1
        $page = 1;
        $_GET['page'] = 1;
    }

    if (($_GET['page'] - 10) < 1)
    {
        $view->currentPage = $_GET['page'] - 1;
    }
    else
    {
        $view->currentPage = 10;
    }
    var_dump($_GET['page']);
    var_dump($view->currentPage);*/

    $limit = 20; // Limit of lots which will be displayed on auction item page
    $view->totalRecords = $view->auctionItemDateSet->getTotalRecords(); // Total number of records in Lots table
    $view->totalPages = $view->totalRecords / $limit; // Total number of pages
    // var_dump($view->totalRecords);

    // the first page in auction item
    $firstPage = ($page - 1) * $limit;
    // var_dump($firstPage);

    /*if (isset($_GET['page'])) {
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
    }*/

// AuctionItemDataSet instance to display all lots in auction item
    $view->auctionItem = $view->auctionItemDateSet->fetchSpecificItem($firstPage, $limit, 'super car');
    // var_dump($view->auctionItem);
    // $view->auctionDataSet = $auction->fetchAllAuctions();
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
    $view->auctionItemDateSet->incrementView( $view->lotID);

    // If searchMode session is set when view button is pressed
    if (isset($_SESSION['searchMode']))
    {
        // Then unset searchMode session
        unset($_SESSION['searchMode']);
    }
}

// If back button is pressed
if (isset($_POST['back']))
{
    // require_once('item.php');

    // Then unset or delete viewItem session
    unset($_SESSION['viewItem']);
    if (!empty($view->currentSearchItem))
    {
        $_SESSION['searchMode'] = true;
    }
}

// Fetch all bids for items
$view->bidItemDataSet = $bidItemDataSet->fetchItemBids($view->lotID);
// If there are no bids for items
if (!$view->bidItemDataSet)
{
    // Then display a message to inform user
    $view->emptyBidError = 'No bid has been place on this item yet.';
}
// var_dump($view->bidItemDataSet);


if (isset($_POST['lotTitle']))
{
    $view->lotTitle = $_POST['lotTitle'];
}
else
{
    if (isset($_POST['lot_title']))
    {
        $view->lotTitle = $_POST['lot_title'];
    }
}

if (isset($_POST['lotMain']))
{
    $view->lotMain = $_POST['lotMain'];
}
else
{
    if (isset($_POST['lot_main']))
    {
        $view->lotMain = $_POST['lot_main'];
    }
}

if (isset($_POST['lotImage']))
{
    $view->lotImage = $_POST['lotImage'];
}
else
{
    if (isset($_POST['lot_image']))
    {
        $view->lotImage = $_POST['lot_image'];
    }
}
// var_dump($view->lotImage);

if (isset($_POST['lotDescription']))
{
    $view->lotDescription = $_POST['lotDescription'];
}
else
{
    if (isset($_POST['lot_description']))
    {
        $view->lotDescription = $_POST['lot_description'];
    }
}
// var_dump($_POST['lotDescription']);

if (isset($_POST['lotPrice']))
{
    $view->lotPrice = $_POST['lotPrice'];
}
else
{
    if (isset($_POST['lot_price']))
    {
        $view->lotPrice = $_POST['lot_price'];
    }
}

if (isset($_POST['auctionID']))
{
    $view->auctionID = $_POST['auctionID'];
}
else
{
    if (isset($_POST['auction_id']))
    {
        $view->auctionID = $_POST['auction_id'];
    }
}

if (isset($_POST['auctionName']))
{
    $view->auctionName = $_POST['auctionName'];
}
else
{
    if (isset($_POST['auction_name']))
    {
        $view->auctionName = $_POST['auction_name'];
    }
}

if (isset($_POST['auctionLocation']))
{
    $view->auctionLocation = $_POST['auctionLocation'];
}
else
{
    if (isset($_POST['auction_location']))
    {
        $view->auctionLocation = $_POST['auction_location'];
    }
}

if (isset($_POST['auctionDatetime']))
{
    $view->auctionDatetime = $_POST['auctionDatetime'];
}
else
{
    if (isset($_POST['auction_datetime']))
    {
        $view->auctionDatetime = $_POST['auction_datetime'];
    }
}

// If placeBid button is pressed
if (isset($_POST['placeBid']))
{
    // If user bid is not empty
    if (empty(trim($_POST['userBid'])))
    {
        $view->userBidError = 'Insufficient amount';
    }
    else
    {
        // Check if user typed bid is numeric
        if (is_numeric($_POST['userBid']))
        {
            // Get the highest bid for item
            $highestBid = $bidItemDataSet->checkHighestBid($view->lotID, $_POST['userBid']);

            // Check If user's bid is greater than opening item bid
            if ($view->lotPrice < $_POST['userBid']) {
                // Check if user's bid is greater than current highest bid
                if ($highestBid == true) {
                    $userBid = $_POST['userBid'];
                    // Place user bid
                    $bidItemDataSet->placeBid(intval($_SESSION['userID']), intval($view->lotID), intval($view->auctionID), $userBid);
                    $userBid = '';
                    $view->userBidError = '';
                    header("location: myBiddingList.php");
                    // unset($_SESSION['viewItem']);
                    echo 'You have successfully placed a bid!';
                } else {
                    $view->userBidError = 'Your bid is lower than the highest bid for this item.';
                }
            }
            else
            {
                $view->userBidError = 'Your bid is lower than the opening bid for this item.';
            }
        }
        else
        {
            $view->userBidError = 'Invalid amount';
        }
    }
}
else
{
    $view->userBidError = '';
}

if (isset($_POST['applyFilter']))
{
    echo $_POST['filters'];
}

require_once('Views/superCar.phtml');


