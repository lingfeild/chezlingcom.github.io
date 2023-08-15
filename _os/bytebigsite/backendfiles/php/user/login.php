<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

include_once __DIR__ . "/../include.php";

if (isset($_POST['userid'], $_POST['password'])) {

    $userid         = $_POST['userid'];
    $input_password = $_POST['password'];

    $nat_user_handler = new NatUserHandler();

    if (!$nat_user_handler->validate_login($userid, $input_password)) {
        return false;
    }
    if (!$nat_user_handler->is_active($userid)) {
        return false;
    }
    session_start();
    $_SESSION['user'] = $userid;
    echo (true);
}
