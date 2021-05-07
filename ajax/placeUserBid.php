<?php
require_once ('../Models/BidItemDataSet.php');
session_start();

$bidItemDataSet = new BidItemDataSet(); // BidItemDataSet instance

$q = $_REQUEST["q"]; // Received request with user placed bid
$txt = "";

if ($_GET["r"] != '')
{
    $_SESSION['viewLotID'] = $_GET["r"];
}
if ($_GET["s"] != '')
{
    $_SESSION['viewAuctionID'] = $_GET["s"];
}
// var_dump($_SESSION['viewAuctionID']);

// Check if user placed bid is greater than the current highest bid
$isHighest = $bidItemDataSet->checkHighestBid($_SESSION['viewLotID'], $q);
$lotHighestBid = $bidItemDataSet->getItemHighestBid($_SESSION['viewLotID']);
$token = "";

if (isset($_SESSION["token"]))
{
    $token = $_SESSION['token'];
}

if (!isset($_GET['token']) || $_GET['token'] != $token)
{
    // Send warning message to user
    $data = new stdClass();
    $data->error = "ACCESS DENIED";
    echo json_encode($data);
}
else
{
    // If user placed bid is the highest bid
    if ($isHighest)
    {
        // Check if user new bid is greater than current highest by 15
        if ($q >= ($lotHighestBid + 15))
        {
            // If user new bid is the highest then place the bid for user
            $bidItemDataSet->placeBid($_SESSION['userID'], $_SESSION['viewLotID'], $_SESSION['viewAuctionID'], $q);
            $txt = $bidItemDataSet->getItemHighestBid($_SESSION['viewLotID']);
        }
        else
        {
            $txt = "Invalid bid";
        }
    }
    else
    {
        $txt = "Invalid bid";
    }

    echo $txt;
}