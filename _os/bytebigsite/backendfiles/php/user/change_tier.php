<?php

session_start();

include_once __DIR__ . "/../include.php";

$subject = "Change Tier at " . SITE_NAME;

$userid      = $_SESSION['user'];
$tier_choice = $_POST['tier_choice'];

$date     = date("Y-m-d");
$ip       = get_ip();
$user_key = trim($_POST['key']);
$honeypot = $_POST['email9'];

$user_data = array(
    'tier_choice' => $tier_choice,
);

if (!validate_user_data($user_data, $user_key, $honeypot, $_FILES, false)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.location.href='../../../index.html';
		</SCRIPT>");
    exit;
}

$message = "Request for a Tier Change: \r\n Tier Choice: $tier_choice \r\n User ID: $userid \r\n Date: $date \r\n IP: $ip";

send_email_with_attachments($subject, $message, $tier_choice, false, $_FILES);

session_destroy();

echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Thank you for requesting a change of tier! Your request will be verified shortly.')
    window.location.href='../../../index.html';
    </SCRIPT>");

/* ############################################################################ */
