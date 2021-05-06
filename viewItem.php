<?php
require_once('Models/AuctionItemDateSet.php');
require_once('Models/BidItemDataSet.php');
require_once('Models/AuctionDataSet.php');
require_once ('Models/AuctionDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Feature Lot';
$view->lotID = '';
$view->bidItemDataSet = new BidItemDataSet(); // BidItemDataSet instance
$view->auctionItem = new AuctionItemDateSet();
$view->currentDate = date("Y-m-d H:i"); // current date
$view->currentDatetime = strtotime($view->currentDate);
$view->lotStatus = '';

// logout script
require_once ('logout.php');
// var_dump($_SESSION['viewAuctionID']);
// var_dump($_GET["q"]);

// Lot ID
if (isset($_GET["q"]))
{
    $_SESSION['viewLotID'] = $_GET["q"]; // Start viewLotID session
}

if (isset($_GET["a"]))
{
    $_SESSION['viewAuctionID'] = $_GET["a"]; // Start viewLotID session
}

$view->lotHighestBid = $view->bidItemDataSet->getItemHighestBid($_SESSION['viewLotID']);
// var_dump($view->bidItemDataSet->fetchLotHighestBid($_SESSION['viewLotID']));

$view->getItem = $view->auctionItem->fetchSingleLot($_SESSION['viewLotID']); // Fetch data for chosen lot
$startDatetime = strtotime($view->getItem[0]->getDatetime());
$endDatetime = strtotime($view->getItem[0]->getEndDatetime());

require_once ('searchBar.php'); // Lot Search script

// If auction has been started and then
// Inform user according to that
if ($view->currentDatetime <= $startDatetime)
{
    $view->lotStatus = "Auction has not started yet.";
}
elseif ($view->currentDatetime >= $endDatetime)
{
    $view->lotStatus = "SOLD";
}
else
{
    // If auction is live then make sure user is logged in to place bid on the lot
    if ($view->currentDatetime > $startDatetime && $view->currentDate < $endDatetime)
    {
        if (isset($_SESSION['loggedIn']))
        {
            $view->lotStatus = false;
        }
        else
        {
            $view->lotStatus = "You need to login before you can place a bid";
        }
    }
}
echo '<br /><br /><br /><br />';
// var_dump(strtotime($view->currentDate) >= $endDatetime);

// Fetch all bids for items
$view->bidItemData = $view->bidItemDataSet->fetchItemBids($_SESSION['viewLotID']);
// If there are no bids for items
if (!$view->bidItemData)
{
    // Then display a message to inform user
    $view->emptyBidError = 'No bid has been placed on this item yet.';
}

require_once ('Views/viewItem.phtml');