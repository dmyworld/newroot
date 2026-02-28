<?php
define('BASEPATH', 'foo');
require 'application/config/database.php';
$db_config = $db['default'];

$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

echo "=== GEOPOS_ACCOUNTS TABLE STRUCTURE ===\n";
$result = $mysqli->query("DESCRIBE geopos_accounts");
while ($row = $result->fetch_assoc()) {
    echo "{$row['Field']} | {$row['Type']} | {$row['Null']} | {$row['Key']} | " . ($row['Default'] ?? 'NULL') . "\n";
}

echo "\n=== UNIVARSAL_API TABLE STRUCTURE ===\n";
$result = $mysqli->query("DESCRIBE univarsal_api");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "{$row['Field']} | {$row['Type']} | {$row['Null']} | {$row['Key']} | " . ($row['Default'] ?? 'NULL') . "\n";
    }
} else {
    echo "Error: " . $mysqli->error . "\n";
}

echo "\n=== SAMPLE ACCOUNT ===\n";
$result = $mysqli->query("SELECT * FROM geopos_accounts LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    print_r($row);
}

echo "\n=== SAMPLE UNIVARSAL_API ===\n";
$result = $mysqli->query("SELECT * FROM univarsal_api LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    print_r($row);
}

$mysqli->close();
?>
