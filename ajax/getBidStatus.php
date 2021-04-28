<?php

require_once ("../Models/BidItemDataSet.php");
session_start(); // start session

$bid = new BidItemDataSet(); // BidItemDataSet instance

$q = $_REQUEST["q"]; // Request send by UserBidStatus javascript class
$status = ""; // current status of the user bid

// If received request is not empty
if ($q != "")
{
    $lotBid = $bid->getItemHighestBid($q); // The highest bid on the lot
    $userBid = $bid->getUserHighestBid($_SESSION['userID'], $q); // User highest bid on the lot

    if ($lotBid != null)
    {
        // If user bid is same as the lot highest bid
        if ($lotBid == $userBid)
        {
            $status = true;
        }
        else
        {
            // If user bid is smaller than the lot highest bid
            $status = false;
        }
    }

    echo $status; // status of the lot bid
}
