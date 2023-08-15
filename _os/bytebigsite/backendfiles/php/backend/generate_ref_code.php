<?php

if (isset($_POST['email'])) {

    include_once __DIR__ . "/../include.php";

    $email = $_POST['email'];
    $code   = generate_ref_code($email);
    echo ($code);
    exit;
}

echo ("ERROR");
exit;
