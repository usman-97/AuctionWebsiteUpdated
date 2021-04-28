<?php
require_once ('../Models/AuctionItemDateSet.php');

session_start();

$q = $_REQUEST["q"];
$_SESSION["viewLotID"] = $q;
//$auctionItem = new AuctionItemDateSet();
//$item = $auctionItem->fetchSingleLot($q);
header('location: /viewItem.php');
