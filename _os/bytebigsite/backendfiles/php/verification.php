<?php

include_once 'include.php';

$duration = trim($_POST['duration']);
$string   = trim($_POST['name']);
echo (create_nonce($duration, $string));
