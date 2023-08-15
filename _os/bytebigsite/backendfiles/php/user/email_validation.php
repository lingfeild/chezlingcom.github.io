<?php

include_once __DIR__ . "/../include.php";

if (isset($_POST['email'])) {

    $email           = $_POST['email'];
    $nat_user_handler = new NatUserHandler();
    $email_check = $nat_user_handler->is_unique_email($email);
    echo($email_check);
}
