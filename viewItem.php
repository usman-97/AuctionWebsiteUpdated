<?php

require_once('Models/AuctionItemDateSet.php');
require_once('Models/BidItemDataSet.php');
require_once('Models/AuctionDataSet.php');
require_once ('Models/AuctionDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Feature Lot';
$view->lotID = '';
$view->bidItemDataSet = new BidItemDataSet();

// logout script
require_once ('logout.php');

$view->auctionItem = new AuctionItemDateSet();
$view->getItem = $view->auctionItem->fetchSingleLot($_SESSION['viewLotID']);

// Fetch all bids for items
$view->bidItemData = $view->bidItemDataSet->fetchItemBids($_SESSION['viewLotID']);
// If there are no bids for items
if (!$view->bidItemData)
{
    // Then display a message to inform user
    $view->emptyBidError = 'No bid has been placed on this item yet.';
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
            $highestBid = $view->bidItemDataSet->checkHighestBid($_POST['lotID'], $_POST['userBid']);

            // Check If user's bid is greater than opening item bid
            if ($_POST['lotPrice'] < $_POST['userBid']) {
                // Check if user's bid is greater than current highest bid
                if ($highestBid == true) {
                    $userBid = $_POST['userBid'];
                    // Place user bid
                    $view->bidItemDataSet->placeBid(intval($_SESSION['userID']), intval($_POST['lotID']), intval($_POST['auctionID']), $userBid);
                    /*if ($bidItemDataSet->checkUserLotBid($_POST['lotID'], $_SESSION['userID']))
                    {
                        $bidItemDataSet->updateUserBid($_POST['lotID'], $_SESSION['userID'], $userBid);
                    }
                    else
                    {
                        $bidItemDataSet->placeBid(intval($_SESSION['userID']), intval($_POST['lotID']), intval($_POST['auctionID']), $userBid);
                    }*/
                    $userBid = '';
                    $view->userBidError = '';
                    // header("location: viewItem.php");
                    // unset($_SESSION['viewItem']);
                    // echo 'You have successfully placed a bid!';
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

/*if (isset($_POST['back']))
{
    header("location: auctionItem.php");
}*/

require_once ('Views/viewItem.phtml');