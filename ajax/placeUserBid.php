<?php
require_once ('../Models/BidItemDataSet.php');
session_start();

$bidItemDataSet = new BidItemDataSet();

$q = $_REQUEST["q"]; // Received request with user placed bid
$txt = "";

// Check if user placed bid is greater than the current highest bid
$isHighest = $bidItemDataSet->checkHighestBid($_SESSION['viewLotID'], $q);
if ($isHighest)
{
    // If user new bid is the highest then place the bid for user
    $bidItemDataSet->placeBid($_SESSION['userID'], $_SESSION['viewLotID'], $_SESSION['viewAuctionID'], $q);
}
else
{
    $txt = "Invalid bid";
}

echo $txt;