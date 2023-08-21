<?php

$url2 = "https://apiv2.bitcoinaverage.com/indices/global/ticker/BCHUSD";

$ch = curl_init();

// set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url2);
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 180);

$result = curl_exec($ch);

curl_close($ch);

$result = json_decode($result, true);

$USD = $result['ask'];

$url2 = "https://apiv2.bitcoinaverage.com/indices/global/ticker/BCHEUR";

$ch = curl_init();

// set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url2);
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 180);

$result = curl_exec($ch);

curl_close($ch);

$result = json_decode($result, true);

$EUR = $result['ask'];

$url2 = "https://apiv2.bitcoinaverage.com/indices/global/ticker/BCHCAD";

$ch = curl_init();

// set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url2);
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 180);

$result = curl_exec($ch);

curl_close($ch);

$result = json_decode($result, true);

$CAD = $result['ask'];

$array = array();
$array['USD'] = $USD;
$array['EUR'] = $EUR;
$array['CAD'] = $CAD;

$sendback = json_encode($array);

echo($sendback)

?>