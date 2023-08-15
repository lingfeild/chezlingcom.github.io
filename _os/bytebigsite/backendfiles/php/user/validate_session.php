<?php
session_start();
ob_start();

include_once __DIR__ . "/../include.php";

$nat_user_handler = new NatUserHandler();

if (!$nat_user_handler->is_valid($_SESSION['user'])) {
    session_destroy();
    echo (false);
    exit;
}

$userid = $_SESSION['user'];
echo ($userid);
exit;
