<?php
require_once ('../Models/BidItemDataSet.php');
session_start();

$bidItemDataSet = new BidItemDataSet();

$q = $_REQUEST["q"];
$txt = "";

$isHighest = $bidItemDataSet->checkHighestBid($_SESSION['viewLotID'], $q);
if ($isHighest)
{
    $bidItemDataSet->placeBid($_SESSION['userID'], $_SESSION['viewLotID'], $_SESSION['viewAuctionID'], $q);
}
else
{
    $txt = "Invalid bid";
}

echo $txt;