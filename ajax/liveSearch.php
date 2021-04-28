<?php
require_once ('../Models/AuctionItemDateSet.php');

$auctionItems = new AuctionItemDateSet();

$q = $_REQUEST["q"];
$token = "";
$fetchSearchedItems = $auctionItems->fetchSomeAuctionItem($q, 0, 10, "none");
 // var_dump(json_encode($fetchSearchedItems));

//if ($q != "")
//{
//    $q = strtolower($q);
//    $len = strlen($q);
//
//    foreach ($fetchSearchedItems as $searchedItems)
//    {
//        // var_dump(json_encode($searchedItems));
////        foreach ($searchedItems as $items)
////        {
//            $itemsStr = json_encode($searchedItems);
//            // var_dump($itemsStr);
//            if (stristr($itemsStr, $q))
//            {
//                if ($hint == "")
//                {
//                    $hint = $itemsStr;
//                }
//                else
//                {
//                    $hint .= ", $itemsStr";
//                }
//            // }
//        }
//    }
//}

// echo $hint == "" ? "no suggestion" : $hint;

session_start();

if (isset($_SESSION["token"]))
{
    $token = $_SESSION['token'];
}
// var_dump($token);

if (!isset($_GET['token']) || $_GET['token'] != $token)
{
    $data = new stdClass();
    $data->error = "ACCESS DENIED";
    echo json_encode($data);
}
else
{
    echo json_encode($fetchSearchedItems);
}
// echo json_encode($fetchSearchedItems);