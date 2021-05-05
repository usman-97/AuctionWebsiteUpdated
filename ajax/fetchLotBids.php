<?php
require_once ('../Models/BidItemDataSet.php');

$q = $_REQUEST['q']; // Received request for lot

$bidItemDataSet = new BidItemDataSet();
$fetchBids = $bidItemDataSet->fetchItemBids($q); // Fetch lot bids from database
$token = "";

session_start();
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
    echo json_encode($fetchBids); // Encode the bids and send them to client side
}