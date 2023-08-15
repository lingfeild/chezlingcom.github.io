<?php

include_once __DIR__ . "/../include.php";

$fullname     = $_POST['fullname'];
$subject      = $_POST['subject'];
$email        = $_POST['email2'];
$message      = $_POST['message'];
$email2       = $_POST['email3'];
$verification = $_POST['verification2'];
$sum          = $_POST['sum'];
$verification = strtoupper($verification);
$nonce_string = trim($fullname);
$key          = $_POST['key'];

$key2 = create_nonce(5, $nonce_string);

if (trim($fullname) == "" || trim($subject) == "" || trim($email) == "" || trim($message) == "" || trim($email2) != "" || trim($verification) == "" || $verification != $sum || !filter_var($email, FILTER_VALIDATE_EMAIL) || $key != $key2) {
    echo 1;
    exit();
}

$ip = get_ip();

$formcontent = "Name: $fullname \n From: $email \n Subject: $subject \n Message: $message \n IP: $ip \n";

$subject    = SITE_NAME . " Contact Form";
$mailheader = "From: " . SITE_EMAIL;

if (mail(SITE_EMAIL, $subject, $formcontent, $mailheader)) {
    echo "sent";
} else {
    echo 'failed';
}
