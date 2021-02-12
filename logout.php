<?php

// Start the session
session_start();
// var_dump($_SESSION['item']);

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
        echo 'Please sign in again';
    }
}
// var_dump($_SESSION['timeout']);