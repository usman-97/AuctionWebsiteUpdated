<?php
require_once ('../Models/AuctionItemDateSet.php');

session_start();
$auctionItem = new AuctionItemDateSet();

$q = $_REQUEST["q"];
$auctionItemDataSet = $auctionItem->fetchAllAuctionItem($_SESSION['lotPerPage'], $_SESSION['lotPerPage'] + 20 , $q);

echo json_encode($auctionItemDataSet);