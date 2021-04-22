<?php
require_once ('../Models/BidItemDataSet.php');

$q = $_REQUEST['q'];

$bidItemDataSet = new BidItemDataSet();
$fetchBids = $bidItemDataSet->fetchItemBids($q);

echo json_encode($fetchBids);
// echo $_SESSION['viewLotID'];