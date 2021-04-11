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

    if (intval($lotBid) == intval($userBid))
    {
        $status = "Highest bid";
    }
    else
    {
        $status = "Outbid";
    }

}

echo $status;
