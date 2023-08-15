<?php

if (isset($_POST['userid']) && isset($_POST['reason'])) {

    include_once __DIR__ . "/../include.php";

    $nat_user_handler = new NatUserHandler();

    $subject = 'Account Denied - ' . SITE_NAME;

    $userid = $_POST['userid'];
    $reason = $_POST['reason'];

    $nat_user_handler->change_active_status($userid, false);
    $user_email = $nat_user_handler->get_user_email($userid);

    ob_start();
    include __DIR__."/../../../templates/deny_user_email.php";
    // The template files hold HTML templates, with PHP variables (ex: $userid, $new_tier)
    // This pulls the file in and cleaning the Object Buffer treats it like a string.
    // See backend/change_tier.php for example
    $email_text = ob_get_clean();

    send_email($user_email, $subject, $email_text);

    echo (true);
    exit;

}
