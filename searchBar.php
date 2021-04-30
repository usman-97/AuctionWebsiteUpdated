<?php


if (isset($_POST['searchButton'])) {

    if (isset($_SESSION['searchedItem']))
    {
        unset($_SESSION['searchedItem']);
    }

    $_SESSION['searchedItem'] = $_POST['searchBar'];
    unset($_SESSION['viewItem']); // set viewItem session to view individual item
    // $_SESSION['auctionItem'] = true;
    $searchTerm = $_POST['searchBar']; // Stores the value from search bar

    // if search field is not empty
    if (!empty(trim($searchTerm))) {
        // Then start searchMode session
        $_SESSION['searchMode'] = true;
    }

//    if (isset($_SESSION['searchedItem']))
//    {
//        if (empty($_POST['searchBar']))
//        {
//            $_POST['searchBar'] = $_SESSION['searchedItem'];
//        }
//    }

    header("location: auctionItem.php");
}

// If clear button is pressed
if (isset($_POST['clearSearch'])) {
    $_SESSION['searchMode'] = null; // Delete searchMode session
    // $_SESSION['searchItem'] = null; // Clear search item session
    $_POST['searchBar'] = null; // Clear search field
    unset($_SESSION['viewItem']); // Clear view item session
    unset($_SESSION['searchedItem']);
}

$token = substr(str_shuffle(MD5(microtime())), 0, 20);
$_SESSION['token'] = $token;