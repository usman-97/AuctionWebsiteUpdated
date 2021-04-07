<?php
require_once ('Models/BidItemDataSet.php');
require_once ('Models/AuctionItemData.php');

$view = new stdClass();
$view->pageTitle = 'My Bidding List';

require_once ('logout.php');
require_once ('resetSessions.php');

$bidItemDataSet = new BidItemDataSet();
$view->error = '';
$view->bidStatus = '';

if (isset($_SESSION['userID'])) {
    $view->bidItemDataSet = $bidItemDataSet->fetchAllBids($_SESSION['userID']);
    // var_dump($view->bidItemDataSet[0]->getBid());
    if (!$view->bidItemDataSet) {
        $view->bidError = 'You don\'t have any bids.';
    }
}

if (isset($_POST['removeBid']))
{
    $bidItemDataSet->removeBid($_POST['bidID']);
    header("location: myBiddingList.php");
}

if (isset($_POST['editBid']))
{
    if (isset($_POST['newBid']) && is_numeric($_POST['newBid'])) {
        $bidItemDataSet->editBid($_POST['bidID'], $_POST['newBid']);
    }
    else
    {
        $view->error = 'Invalid amount';
    }
}

if (isset($_POST['statusButton'])) {
    $highestItemBid = $bidItemDataSet->getItemHighestBid(intval($_POST['lotID']));
    $userHighestBid = $bidItemDataSet->getUserHighestBid(intval($_SESSION['userID']), intval($_POST['lotID']));
    if ($highestItemBid == $userHighestBid)
    {
        $view->bidStatus = 'Highest bidder';
    }
    else
    {
        $view->bidStatus = 'Outbid by other bidder';
    }

    // var_dump($highestItemBid);
    // var_dump($userHighestBid);
    // var_dump(intval($_POST['lotID']));
    // var_dump(intval($_SESSION['userID']));
}

if (isset($_POST['viewItem']))
{
    $_SESSION['viewLotID'] = $_POST['lotID'];
    header("location: viewItem.php");
    // var_dump($_SESSION['viewLotID']);
}

require_once('Views/myBiddingList.phtml');