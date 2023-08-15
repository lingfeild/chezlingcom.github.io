<?php

session_start();

include_once __DIR__ . "/../include.php";

$nat_user_handler = new NatUserHandler();

$user_id = $_SESSION['user'];

$current_pw = trim($_POST['current_pw']);
$new_pw     = trim($_POST['new_pw']);
$new_pw     = encrypt($new_pw, $user_id);

if (!$nat_user_handler->validate_login($user_id, $current_pw)) {
    echo (false);
    exit;
}

$nat_user_handler->change_password($user_id, $new_pw);

echo (true);
session_destroy();
exit;
