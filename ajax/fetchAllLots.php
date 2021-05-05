<?php
require_once ('../Models/AuctionItemDateSet.php');

session_start(); // start session
$auctionItem = new AuctionItemDateSet(); // AuctionItemDataSet instance

$q = $_REQUEST["q"]; // Sorting filter
$r = $_REQUEST["r"]; // Selected category
$s = $_REQUEST["s"]; // Minimum price
$t = $_REQUEST["t"]; // Maximum price
// var_dump($_SESSION['searchedItem']);

$token = "";

// If user is using search
if (isset($_SESSION['searchMode']))
{
    // then fetch items which matching with user's search with their chosen filters
    $auctionItemDataSet = $auctionItem->fetchSomeAuctionItem($_SESSION['searchedItem'], $_SESSION['lotPerPage'], $_SESSION['lotPerPage'] + 20 , $q, $r, $s, $t);
}
else
{
    // otherwise fetch all lots which user's chosen filters
    $auctionItemDataSet = $auctionItem->fetchAllAuctionItem($_SESSION['lotPerPage'], $_SESSION['lotPerPage'] + 20 , $q, $r, $s, $t);
}

// Start session for each chosen filter
if ($q != '')
{
    $_SESSION['sortingFilter'] = $q;
}

if ($r != '')
{
    $_SESSION['selectedCategory'] = $r;
}

if ($s != '')
{
    $_SESSION['minPrice'] = $s;
}

if ($t != '')
{
    $_SESSION['maxPrice'] = $t;
}

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
    echo json_encode($auctionItemDataSet); // Send requested data back to client side
}