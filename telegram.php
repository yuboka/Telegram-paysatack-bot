<?php
require_once __DIR__ . "/../config.php";

function api($method, $params = []) {
    global $TOKEN;

    $ch = curl_init("https://api.telegram.org/bot$TOKEN/$method");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true
    ]);
    return json_decode(curl_exec($ch), true);
}
