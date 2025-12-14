<?php
require_once __DIR__ . "/../db.php";
require_once "telegram.php";
require_once "users.php";
require_once __DIR__ . "/../config.php";

function startPayment($chat_id, $package, $amount) {
    global $DB, $PAYSTACK_SECRET;

    $reference = "TG_{$chat_id}_" . time();

    $DB->exec("
      INSERT INTO payments (reference, chat_id, amount, package, status)
      VALUES ('$reference','$chat_id',$amount,'$package','pending')
    ");

    $payload = [
        "email" => "tg{$chat_id}@bot.local",
        "amount" => $amount * 100,
        "reference" => $reference,
        "metadata" => [
            "chat_id" => $chat_id,
            "package" => $package
        ]
    ];

    $ch = curl_init("https://api.paystack.co/transaction/initialize");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $PAYSTACK_SECRET",
            "Content-Type: application/json"
        ],
        CURLOPT_RETURNTRANSFER => true
    ]);

    $res = json_decode(curl_exec($ch), true);

    api("sendMessage", [
        "chat_id" => $chat_id,
        "text" => "Pay here:\n".$res["data"]["authorization_url"]
    ]);
}
