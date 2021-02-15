<?php
require_once ('Models/AuctionDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Feature Auctions';
$view->auctions = new AuctionDataSet();

$view->allAuctions = $view->auctions->fetchAllAuctions();

require_once ('Views/auctions.phtml');