<?php
require_once ('Models/AuctionDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Feature Auctions';
$view->auctions = new AuctionDataSet();
$view->pagination = "auctions.php?page=";
$view->totalRecords = $view->auctions->totalAuctions(); // Total number of records in Lots table

require_once ('logout.php');
require_once ('resetSessions.php');

$view->allAuctions = $view->auctions->fetchAllAuctions();

require ('pagination.php');

if (isset($_POST['viewAuctionLots']))
{
    $_SESSION['viewAuctionLots'] = $_POST['auctionID'];
    header("location: auctionItem.php");
}

// require_once ('pagination.php');

require_once ('Views/auctions.phtml');