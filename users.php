<?php
require_once __DIR__ . "/../db.php";

function registerUser($chat) {
    global $DB;

    $id = $chat["id"];
    $username = $chat["username"] ?? "";
    $first = $chat["first_name"] ?? "";

    $DB->exec("
      INSERT OR IGNORE INTO users
      (chat_id, username, first_name, package, expiry)
      VALUES ('$id','$username','$first','free',0)
    ");
}

function activatePackage($chat_id, $package, $days = 30) {
    global $DB;
    $expiry = time() + ($days * 86400);

    $DB->exec("
      UPDATE users SET package='$package', expiry=$expiry
      WHERE chat_id='$chat_id'
    ");
}
