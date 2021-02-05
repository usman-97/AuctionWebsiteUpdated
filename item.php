<?php
require_once ('Models/BidItemDataSet.php');
require_once ('Models/AuctionItemDateSet.php');

$view = new stdClass();
$view->pageTitle = 'Car';

// session_start();
require_once ('logout.php');
/*if (isset($_POST['back']))
{
    unset($_SESSION['viewItem']);
    // require_once ('auctionItem.php');
    // header("location: auctionItem.php");
}*/

$view->item = new AuctionItemDateSet();
$view->bidItemDataSet = new BidItemDataSet();
$view->displayBids = $view->bidItemDataSet->fetchAllBids();

$view->item->getItem($_POST['lotID']);
// var_dump($_POST['lotID']);
// var_dump($view->item->getItem($_POST['lotID']));

$_SESSION['lot_id'] = $view->item->getItem($_POST['lotID'])->getLotId();

if (!$view->displayBids = $view->bidItemDataSet->fetchAllBids()) {
    $view->error = 'No bid placed yet.';
    // require_once('Views/item.phtml');
} else {
    echo $view->displayBids;
    // require_once('Views/item.phtml');
}

if (isset($_POST['placeBid'])) {
    if (!empty(trim($_POST['userBid']))) {
        if (is_numeric($_POST['userBid'])) {
            $view->placeBid = $view->bidItemDataSet->placeBid($_SESSION['userID'], $_POST['lotID'], $_POST['auctionID'], $_POST['userBid']);
            $view->displayBids;
        }
        else {
            $view->error = 'Invalid bid';
        }
    }
    else {
        $view->error = 'Insufficient amount';
    }
}

if (isset($_POST['lotID']))
{
    $view->lotID = $_POST['lotID'];
}
else
{
    if (isset($_POST['lot_id']))
    {
        $view->lotID = $_POST['lot_id'];
    }
}
/*var_dump($_POST['lotID']);
var_dump($_POST['lot_id']);
var_dump($_POST['lot_id_filler']);*/
var_dump($view->lotID);

if (isset($_POST['lotTitle']))
{
    $view->lotTitle = $_POST['lotTitle'];
}
else
{
    if (isset($_POST['lot_title']))
    {
        $view->lotTitle = $_POST['lot_title'];
    }
}
// var_dump($_POST['lot_title']);
// var_dump($_POST['lot_title_filler']);

if (isset($_POST['lotMain']))
{
    $view->lotTitle = $_POST['lotMain'];
}
else
{
    if (isset($_POST['lot_main']))
    {
        $view->lotTitle = $_POST['lot_main'];
    }
}


if (isset($_POST['back']))
{
    require_once('auctionItem.php');
}
else
{
    require_once('Views/item.phtml');
}

// var_dump($_SESSION['lotID']);
// var_dump(isset($_POST['placeBid']));
// var_dump($view->placeBid);
// var_dump($view->displayBids);
// require_once ('Views/item.phtml');