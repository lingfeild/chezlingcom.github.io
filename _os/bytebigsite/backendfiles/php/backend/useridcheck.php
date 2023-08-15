<?php

include_once __DIR__ . "/../include.php";

if (isset($_POST['userid'])) {

    $nat_user_handler = new NatUserHandler();
    $userid   = $_POST['userid'];
    echo($nat_user_handler->get_tier($userid));
    exit;

}
