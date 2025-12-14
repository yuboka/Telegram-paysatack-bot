<?php
require "../db.php";
require "../config.php";
require "../core/users.php";

$payload = file_get_contents("php://input");
$sig = $_SERVER["HTTP_X_PAYSTACK_SIGNATURE"] ?? "";

if ($sig !== hash_hmac("sha512", $payload, $PAYSTACK_SECRET)) exit;

$data = json_decode($payload, true)["data"];

$ref = $data["reference"];
$chat = $data["metadata"]["chat_id"];
$pkg = $data["metadata"]["package"];

$DB->exec("UPDATE payments SET status='success' WHERE reference='$ref'");
activatePackage($chat, $pkg);
