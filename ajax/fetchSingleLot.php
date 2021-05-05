<?php
require_once ('../Models/AuctionItemDateSet.php');

session_start();

$q = $_REQUEST["q"]; // Lot id for the lot
$_SESSION["viewLotID"] = $q; // Start a session for that lot
header('location: /viewItem.php'); // redirect user to viewItem page
