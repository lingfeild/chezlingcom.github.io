<?php

include_once __DIR__ . "/../include.php";

$wallet = $_POST['wallet'];

$message = "OK";
try {
    validate($wallet);
} catch (\Exception $e) {$message = $e->getMessage();}
echo "$message";

exit();
