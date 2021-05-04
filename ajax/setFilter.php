<?php
session_start();

$q = $_REQUEST["q"];
$_SESSION['sortingFilter'] = $q;
