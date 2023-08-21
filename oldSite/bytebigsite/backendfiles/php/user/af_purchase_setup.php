<?php

include_once __DIR__ . "/../include.php";

$af_user_handler         = new AfUserHandler();
$nat_user_handler         = new NatUserHandler();

$af_purchase_handler = new AfPurchaseHandler($_POST);
$af_purchase_handler->set_af_user_handler($af_user_handler);
$af_purchase_handler->set_nat_user_handler($nat_user_handler);

$player_info = $af_purchase_handler->setup_purchase();

echo ($player_info);
