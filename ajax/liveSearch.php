<?php
require_once ('../Models/AuctionItemDateSet.php');

$auctionItems = new AuctionItemDateSet(); // AuctionDataSet instance

$q = $_REQUEST["q"]; // Searched keywords by user
$token = ""; // token
$fetchSearchedItems = $auctionItems->fetchSomeAuctionItem($q, 0, 10); // Fetch lots which match user's keywords

session_start(); // start session

if (isset($_SESSION["token"]))
{
    $token = $_SESSION['token'];
}

// If token is not set or sent token doesn't match current token
if (!isset($_GET['token']) || $_GET['token'] != $token)
{
    // Send warning message to user
    $data = new stdClass();
    $data->error = "ACCESS DENIED";
    echo json_encode($data);
}
else
{
    // Otherwise send requested data back to client
    echo json_encode($fetchSearchedItems);
}