<?php
require_once ('Models/User.php');

$view = new stdClass();
$view->pageTitle = 'Salford Cars';;

// session_start();
require_once ('logout.php');
// require_once ('login.php');

unset($_SESSION['viewItem']);
unset($_SESSION['searchMode']);

require_once('Views/index.phtml');