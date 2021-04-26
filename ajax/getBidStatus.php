<?php

require_once ("../Models/BidItemDataSet.php");
session_start();

$bid = new BidItemDataSet();

$q = $_REQUEST["q"];
$status = "";

if ($q != "")
{
    $lotBid = $bid->getItemHighestBid($q);
    $userBid = $bid->getUserHighestBid($_SESSION['userID'], $q);
    // var_dump($lotBid);
    // var_dump($userBid);

    if ($lotBid != null)
    {
        if ($lotBid == $userBid)
        {
            // $status = "Highest bid";
            $status = true;
        }
        else
        {
            // $status = "Outbid";
            $status = false;
        }
    }

    echo $status;
}
