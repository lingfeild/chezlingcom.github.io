<?php

include_once __DIR__ . "/../include.php";

$nat_user_handler = new NatUserHandler();

$is_refered_user = false;
$_POST['active'] = false;
$_POST['is_vip'] = false;

if ($_POST['ref_code'] == generate_ref_code($_POST['email'])) {
    $is_refered_user = true;
    $_POST['active'] = true;
    $_POST['is_vip'] = true;
}

$user_data = assemble_user_data($nat_user_handler, $_POST);

$honeypot = $_POST['email9'];
$ip       = get_ip();
$user_key = trim($_POST['key']);

if (!validate_user_data($user_data, $user_key, $honeypot, $_FILES, true)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Your session has expired (5 minutes). Please refresh and try again.')
            window.location.href='../../../index.html';
            </SCRIPT>");
    exit();
}

$nat_user_handler->create_user($user_data);

$date    = date("Y-m-d");
$subject = 'New User at ' . SITE_NAME;

$message = "NEW USER: \r\n From: " . SITE_NAME . " \r\n Name: " . $user_data['fname'] . " " . $user_data['lname'] . " \r\n Address: " . $user_data['street'] . " " . $user_data['city'] . " " . $user_data['postal_code'] . " " . $user_data['state'] . " " . $user_data['country'] . " \r\n Contact: Email: " . $user_data['email'] . " - Mobile #: " . $user_data['phone'] . " \r\n Tier Choice: " . $user_data['tier_choice'] . " \r\n User ID: " . $user_data['user_id'] . " \r\n Date: $date \r\n IP: $ip";

send_email_with_attachments($subject, $message, $user_data['tier_choice'], true, $_FILES);

if ($is_refered_user) {
    $userid = $user_data['user_id'];
    ob_start();
    include __DIR__ . "/../../../templates/verify_user_email.php";
    // The template files hold HTML templates, with PHP variables (ex: $userid, $new_tier)
    // This pulls the file in and cleaning the Object Buffer treats it like a string.
    // See backend/change_tier.php for example
    $email_text = ob_get_clean();
} else {
    ob_start();
    include __DIR__ . "/../../../templates/new_user_nat_email.php";
    $email_text = ob_get_clean();
}

send_email($user_data['email'], $subject, $email_text);

echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Thank you for registering! Your registration information will be verified.')
    window.location.href='../../../index.html';
    </SCRIPT>");

exit;
