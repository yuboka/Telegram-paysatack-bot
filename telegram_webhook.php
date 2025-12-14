<?php
require "../core/telegram.php";
require "../core/users.php";
require "../core/payments.php";

$update = json_decode(file_get_contents("php://input"), true);

if (isset($update["message"])) {
    $msg = $update["message"];
    $chat_id = $msg["chat"]["id"];
    $text = $msg["text"] ?? "";

    registerUser($msg["chat"]);

    if ($text === "/start") {
        api("sendMessage", [
            "chat_id" => $chat_id,
            "text" => "Choose your package:",
            "reply_markup" => json_encode([
                "inline_keyboard" => [
                    [["text"=>"Free","callback_data"=>"free"]],
                    [["text"=>"Standard ₦2500","callback_data"=>"standard"]],
                    [["text"=>"Premium ₦5000","callback_data"=>"premium"]]
                ]
            ])
        ]);
    }
}

if (isset($update["callback_query"])) {
    $data = $update["callback_query"]["data"];
    $chat_id = $update["callback_query"]["message"]["chat"]["id"];

    if ($data === "standard") startPayment($chat_id,"standard",2500);
    if ($data === "premium") startPayment($chat_id,"premium",5000);
}
