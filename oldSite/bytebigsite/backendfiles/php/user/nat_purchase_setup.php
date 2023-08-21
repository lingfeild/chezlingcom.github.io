<?php
session_start();
ob_start();

include_once __DIR__ . "/../include.php";
include_once __DIR__ . "/../../../controller/include.php";

if (!isset($_SESSION['user'])) {
    return false;
}

$user = $_SESSION['user'];

$nat_user_handler     = new NatUserHandler();
$curl_request         = new CurlRequest();
$nat_purchase_handler = new NatPurchaseHandler($user);
$nat_purchase_handler->set_nat_user_handler($nat_user_handler);
$nat_purchase_handler->set_curl_request($curl_request);

$player_data = $nat_purchase_handler->setup_purchase();
echo ($player_data);
exit;
