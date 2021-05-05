<?php
require_once ('../Models/AuctionItemDateSet.php');

session_start();
$auctionItem = new AuctionItemDateSet();

$q = $_REQUEST["q"];
$r = $_REQUEST["r"];
$s = $_REQUEST["s"];
$t = $_REQUEST["t"];
// var_dump($_SESSION['searchedItem']);

if (isset($_SESSION['searchMode']))
{
    $auctionItemDataSet = $auctionItem->fetchSomeAuctionItem($_SESSION['searchedItem'], $_SESSION['lotPerPage'], $_SESSION['lotPerPage'] + 20 , $q, $r, $s, $t);
}
else
{
    $auctionItemDataSet = $auctionItem->fetchAllAuctionItem($_SESSION['lotPerPage'], $_SESSION['lotPerPage'] + 20 , $q, $r, $s, $t);
}

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

echo json_encode($auctionItemDataSet);