<?php
require_once('Models/AuctionItemDateSet.php');
require_once('Models/BidItemDataSet.php');
require_once('Models/AuctionDataSet.php');
require_once ('Models/AuctionDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Feature Lot';
$view->lotID = '';
$view->bidItemDataSet = new BidItemDataSet(); // BidItemDataSet instance

// logout script
require_once ('logout.php');
// var_dump($_SESSION['viewAuctionID']);
// var_dump($_GET["q"]);

// Lot ID
if (isset($_GET["q"]))
{
    $_SESSION['viewLotID'] = $_GET["q"]; // Start viewLotID session
}

$view->auctionItem = new AuctionItemDateSet();
$view->getItem = $view->auctionItem->fetchSingleLot($_SESSION['viewLotID']); // Fetch data for chosen lot

$view->currentDate = date("Y-m-d H:i"); // current date
$view->lotStatus = '';

require_once ('searchBar.php'); // Lot Search script

// $view->auctionDate = date($view->getItem[0]->getEndDatetime());
// var_dump($view->auctionDate == $view->currentDate);
// var_dump($view->currentDate > $view->getItem[0]->getDatetime());

// If auction has been started and then
// Inform user according to that
if ($view->currentDate <= $view->getItem[0]->getDatetime())
{
    $view->lotStatus = "Auction has not started yet.";
}
elseif ($view->currentDate >= $view->getItem[0]->getEndDatetime())
{
    $view->lotStatus = "SOLD";
}
else
{
    // If auction is live then make sure user is logged in to place bid on the lot
    if ($view->currentDate > $view->getItem[0]->getDatetime() && $view->currentDate < $view->getItem[0]->getEndDatetime())
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

// Fetch all bids for items
$view->bidItemData = $view->bidItemDataSet->fetchItemBids($_SESSION['viewLotID']);
// If there are no bids for items
if (!$view->bidItemData)
{
    // Then display a message to inform user
    $view->emptyBidError = 'No bid has been placed on this item yet.';
}

// If placeBid button is pressed
//if (isset($_POST['placeBid']))
//{
//    // If user bid is not empty
//    if (empty(trim($_POST['userBid'])))
//    {
//        $view->userBidError = 'Insufficient amount';
//    }
//    else
//    {
//        // Check if user typed bid is numeric
//        if (is_numeric($_POST['userBid']))
//        {
//            // Get the highest bid for item
//            $highestBid = $view->bidItemDataSet->checkHighestBid($_POST['lotID'], $_POST['userBid']);
//
//            // Check If user's bid is greater than opening item bid
//            if ($_POST['lotPrice'] < $_POST['userBid']) {
//                // Check if user's bid is greater than current highest bid
//                if ($highestBid == true) {
//                    $userBid = $_POST['userBid'];
//                    // Place user bid
//                    $view->bidItemDataSet->placeBid(intval($_SESSION['userID']), intval($_POST['lotID']), intval($_POST['auctionID']), $userBid);
//                    /*if ($bidItemDataSet->checkUserLotBid($_POST['lotID'], $_SESSION['userID']))
//                    {
//                        $bidItemDataSet->updateUserBid($_POST['lotID'], $_SESSION['userID'], $userBid);
//                    }
//                    else
//                    {
//                        $bidItemDataSet->placeBid(intval($_SESSION['userID']), intval($_POST['lotID']), intval($_POST['auctionID']), $userBid);
//                    }*/
//                    $userBid = '';
//                    $view->userBidError = '';
//                    // header("location: viewItem.php");
//                    // unset($_SESSION['viewItem']);
//                    // echo 'You have successfully placed a bid!';
//                } else {
//                    $view->userBidError = 'Your bid is lower than the highest bid for this item.';
//                }
//            }
//            else
//            {
//                $view->userBidError = 'Your bid is lower than the opening bid for this item.';
//            }
//        }
//        else
//        {
//            $view->userBidError = 'Invalid amount';
//        }
//    }
//}
//else
//{
//    $view->userBidError = '';
//}

//if (isset($_POST['bidBtn']))
//{
//    // $_SESSION['userCurrentBid'] = $_POST['userBid'];
//    $_POST['userBidStore'] = $_POST['userBid'];
//}
//var_dump($_SESSION['userCurrentBid']);

/*if (isset($_POST['back']))
{
    header("location: auctionItem.php");
}*/

require_once ('Views/viewItem.phtml');