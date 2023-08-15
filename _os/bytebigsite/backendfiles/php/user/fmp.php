<?php

if (isset($_POST['userid'])) {

    include_once __DIR__ . "/../include.php";
    
    $userid = $_POST['userid'];
    $password   = encrypt(randomize_pw(), $userid);

    $nat_user_handler = new NatUserHandler();

    $user_email = $nat_user_handler->get_user_email($userid);
    $nat_user_handler->change_password($userid, $password);

    $password = decrypt($password, $userid);
    $subject  = 'Forgotten Password At ' . SITE_NAME;

    ob_start();
    include __DIR__."/../../../templates/fmp_email.php";
    // The template files hold HTML templates, with PHP variables (ex: $userid, $new_tier)
    // This pulls the file in and cleaning the Object Buffer treats it like a string.
    // See backend/change_tier.php for example
    $email_text = ob_get_clean();

    send_email($user_email, $subject, $email_text);
    echo (true);
}
