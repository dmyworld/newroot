<?php
define('BASEPATH', 'dummy');
include 'application/config/database.php';
$db_config = $db['default'];
$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "--- LOCATIONS ---\n";
$res = $conn->query("SELECT id, cname FROM geopos_locations");
while($row = $res->fetch_assoc()) {
    echo "ID: {$row['id']}, Name: {$row['cname']}\n";
}
?>
