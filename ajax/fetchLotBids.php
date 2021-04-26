<?php
require_once ('../Models/BidItemDataSet.php');

$q = $_REQUEST['q']; // Received request for lot

$bidItemDataSet = new BidItemDataSet();
$fetchBids = $bidItemDataSet->fetchItemBids($q); // Fetch lot bids from database

echo json_encode($fetchBids); // Encode the bids and send them to client side
// echo $_SESSION['viewLotID'];