<?php

// Start the session
session_start();
// var_dump($_SESSION['item']);
// var_dump( $_SESSION['viewAuctionLots']);

// If logout button is pressed
if (isset($_POST['logout']))
{
    // then unset loggedIn session
    unset($_SESSION['loggedIn']);
    // destroy session
    session_destroy();
    //echo 'You have successfully logged out';
    header("location: index.php");
}

// If user has been loggedIn and timeout session is set
if (isset($_SESSION['timeout'])) {
    // If user last activity time is less than expiry time
    if ($_SESSION['timeout'] < time() - $_SESSION['expire']) {
        unset($_SESSION['loggedIn']);
        session_destroy();
        // echo 'Please sign in again';
        header("location: index.php");
    }
}
// var_dump($_SESSION['timeout']);

$token = substr(str_shuffle(MD5(microtime())), 0, 20);
$_SESSION['token'] = $token;