<?php
if (!defined('SERVER_NAME')) {
    if (!array_key_exists("SERVER_NAME", $_SERVER)) {
        define("SERVER_NAME", "");
    } else {
        define("SERVER_NAME", $_SERVER['SERVER_NAME']);
    }
}

define('SECRET_KEY', 'U750Zp3Tha');
if (!defined('ENCRYPTION_METHOD')) {
    define('ENCRYPTION_METHOD', 'AES-128-ECB');
}
define('OPERATOR_KEY', 'RScKvFKcQkihEnrY');
date_default_timezone_set('America/New_York');

if (SERVER_NAME == 'localhost') {
    define('SITE_NAME', "www.bytebigsite.com");
    define('SITE_URL', "http://" . SERVER_NAME . ":" . $_SERVER['SERVER_PORT'] . "/" . SITE_NAME);
} else {
    define('SITE_NAME', SERVER_NAME);
    define('SITE_URL', 'https://' . SITE_NAME);
}

define('DB_CONFIG', __DIR__ . '/../../config/.dbinfo.xml');
define('BITCOIN_CONFIG', __DIR__ . '/../../config/.bitcoin_config');

if (file_exists(BITCOIN_CONFIG)) {
    define('SITE_EMAIL', file_get_contents(BITCOIN_CONFIG));
}
