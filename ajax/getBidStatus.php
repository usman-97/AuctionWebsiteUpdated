<?php

require_once ("../Models/BidItemDataSet.php");
session_start(); // start session

$bid = new BidItemDataSet(); // BidItemDataSet instance

$q = $_REQUEST["q"]; // Request send by UserBidStatus javascript class
$status = ""; // current status of the user bid
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
    }
    echo $status; // status of the lot bid
}
