<?php
define('BASEPATH', 'TRUE');
include("application/config/database.php");
$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "--- Recent Logs ---\n";
$res = $mysqli->query("SELECT * FROM geopos_timber_logs ORDER BY id DESC LIMIT 3");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "\n--- Recent Photos ---\n";
$res = $mysqli->query("SELECT * FROM geopos_timber_photos ORDER BY id DESC LIMIT 5");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "\n--- Sample Users ---\n";
$res = $mysqli->query("SELECT id, username, name FROM geopos_users LIMIT 5");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

$mysqli->close();
?>
