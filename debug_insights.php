<?php
define('BASEPATH', 'dummy');
$active_group = 'default';
$query_builder = TRUE;
require_once 'application/config/database.php';
$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
if ($mysqli->connect_error) { die('Connect Error'); }

echo "--- share_logs count ---\n";
$res = $mysqli->query("SELECT COUNT(*) as c FROM share_logs");
$row = $res->fetch_assoc();
echo "Total shares in system: " . $row['c'] . "\n";

echo "\n--- Recent share_logs ---\n";
$res = $mysqli->query("SELECT * FROM share_logs ORDER BY id DESC LIMIT 5");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "\n--- social_referral_clicks count ---\n";
$res = $mysqli->query("SELECT COUNT(*) as c FROM social_referral_clicks");
$row = $res->fetch_assoc();
echo "Total clicks in system: " . $row['c'] . "\n";

echo "\n--- User Data Check ---\n";
$res = $mysqli->query("SELECT id, username, roleid FROM geopos_users LIMIT 5");
while($row = $res->fetch_assoc()) {
    echo "ID: {$row['id']} | User: {$row['username']} | Role: {$row['roleid']}\n";
}

$mysqli->close();
