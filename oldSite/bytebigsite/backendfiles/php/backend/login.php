<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

include_once __DIR__ . "/../include.php";

if (isset($_POST['userid'], $_POST['password'])) {

    $admin_user_handler = new AdminUserHandler();

    $userid         = $_POST['userid'];
    $input_password = $_POST['password'];

    $return_array = array();

    if (!$admin_user_handler->validate_login($userid, $input_password)) {
    	$return_array['is_valid'] = false;
        echo (json_encode($return_array));
        exit;
    }

    $return_array['is_valid'] = true;
    $return_array['is_admin'] = $admin_user_handler->is_admin($userid);

    session_start();
    $_SESSION['admin'] = $userid;
    echo (json_encode($return_array));
    exit;
}
