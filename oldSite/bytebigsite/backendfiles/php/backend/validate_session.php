<?php
session_start();
ob_start();

include_once __DIR__ . "/../include.php";

$admin_user_handler = new AdminUserHandler();

if (!isset($_SESSION['admin']) || !$admin_user_handler->is_valid($_SESSION['admin'])) {
    session_destroy();
    echo (false);
    exit;
}

$admin = $_SESSION['admin'];
echo ($admin);
exit;
