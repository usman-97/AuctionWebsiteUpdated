<?php
if (isset($_POST['searchButton'])) {

    $_SESSION['searchedItem'] = $_POST['searchBar'];
    unset($_SESSION['viewItem']); // set viewItem session to view individual item
    // $_SESSION['auctionItem'] = true;
    $searchTerm = $_POST['searchBar']; // Stores the value from search bar

    // if search field is not empty
    if (!empty(trim($searchTerm))) {
        // Then start searchMode session
        $_SESSION['searchMode'] = true;
    }

    if (isset($_SESSION['searchedItem']))
    {
        if (empty($_POST['searchBar']))
        {
            $_POST['searchBar'] = $_SESSION['searchedItem'];
        }
    }

    header("location: auctionItem.php");
}