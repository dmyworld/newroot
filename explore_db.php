<?php
define('BASEPATH', 'TRUE');
include("application/config/database.php");
$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$tables = ['geopos_timber_photos', 'geopos_timber_logs', 'geopos_timber_log_items', 'geopos_timber_bids'];

foreach ($tables as $table) {
    echo "--- $table Schema ---\n";
    $res = $mysqli->query("DESCRIBE $table");
    while($row = $res->fetch_assoc()) {
        echo "Field: " . $row['Field'] . " - Type: " . $row['Type'] . "\n";
    }
    echo "\n";
}

$mysqli->close();
?>
