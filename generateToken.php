<?php
$token = substr(str_shuffle(MD5(microtime())), 0, 20);
$_SESSION['token'] = $token;