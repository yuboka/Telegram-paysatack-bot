<?php
require __DIR__ . "/../db.php";

$now = time();

$DB->exec("
  UPDATE users SET package='free'
  WHERE expiry < $now AND expiry > 0
");

echo "Expired subscriptions cleared\n";
