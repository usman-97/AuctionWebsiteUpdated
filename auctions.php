<?php
require_once ('Models/AuctionDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Feature Auctions';
$view->auctions = new AuctionDataSet();

require_once ('logout.php');
require_once ('resetSessions.php');

$view->allAuctions = $view->auctions->fetchAllAuctions();

if (isset($_POST['viewAuctionLots']))
{
    $_SESSION['viewAuctionLots'] = $_POST['auctionID'];
    header("location: auctionItem.php");
}

// require_once ('pagination.php');

require_once ('Views/auctions.phtml');