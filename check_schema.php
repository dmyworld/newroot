<?php
define('BASEPATH', 'TRUE');
require_once('application/config/database.php');

$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function dump_table($conn, $table) {
    echo "\n--- Schema for $table ---\n";
    $result = $conn->query("DESCRIBE $table");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            printf("%-20s %-20s %-10s %-10s %-10s\n", $row['Field'], $row['Type'], $row['Null'], $row['Key'], $row['Default']);
        }
    } else {
        echo "Error describe $table: " . $conn->error . "\n";
    }
}

dump_table($conn, 'geopos_products');
dump_table($conn, 'geopos_users');
dump_table($conn, 'geopos_quotes');

$conn->close();
?>
